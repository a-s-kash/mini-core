<?php

namespace core\repository;

use core\App;

abstract class Repository
{
    /** @var string */
    protected $tableName;

    /** @var string */
    protected $entityModelName;

    /** @var string */
    protected $dbSchemas;

    /** @var array  */
    private $response = [];

    public function __construct()
    {
        static $dbSchemas  = null;
        static $config = [];

        $repositoryName = get_called_class();

        if(!$config[$repositoryName]){
            $config[$repositoryName] = $this->makeTableAndEntityName();
            $config[$repositoryName]['dbPatch'] = App::config()->getParams('app_patch')
                . App::config()->getParams('db_patch')
            ;
        }

        $this->entityModelName = $config[$repositoryName]['entityModelName'];
        $this->tableName = $config[$repositoryName]['tableName'];

        if(!$this->dbSchemas && !$dbSchemas){
            $dbSchemas = App::config()->getParams('app_patch')
                . App::config()->getParams('db_patch')
            ;

            $this->dbSchemas = $dbSchemas;
        }
    }

    public function findById(int $id, $entireRow = true): ? EntityModel
    {
        $query = $this->makeSelectQuery(["id = $id"]);
        $this->response = $this->queryOne($query, $entireRow);
        return $this->makeEntityModel($this->response);
    }

    public function findAll(array $data = null): ? array
    {


        d([
            'Repository findAll'
        ]);
        $response = [];
        $query = $this->makeSelectQuery($data);
        $this->response = $this->queryAll($query);
        foreach($this->response as $val){
            $response[] = $this->makeEntityModel($val);
        }

        return $response;
    }

    public function find(int $id = null)
    {
        $query = (new ActiveRecord($this))
            ->getSelectQueryBuilder()
        ;

        if($id){
            $query->where('id = ' . (int) $id);
        }

        return $query;
    }

    public function push(EntityModel $entity): EntityModel
    {
        $properties = $entity->getProperties();

        if($entity->id){
            $set = [];
            unset($properties['id']);
            foreach ($properties as $propertyName => $propertyVal){
                $set[] = "`$propertyName` = '$propertyVal'";
            }
            $this->updateRecord(implode(', ', $set), '`id` = ' . $entity->id);
            return $entity;
        }

        $propertiesName = implode('`, `', array_keys($properties));
        $propertiesVal = implode("', '", $properties);

        if($this->createRecord($propertiesName, $propertiesVal)){
            $entity->id = $this->getLastInsertId();
        }

        return $entity;
    }

    protected function makeEntityModel(array $data): ? EntityModel
    {
        $properties = [];
        foreach ($data as $propertyKey => $propertyVal){
            $property = ucwords($propertyKey, '_');
            $property[0] = strtolower($property[0]);
            $properties[str_replace('_', '', $property)] = $propertyVal;
        }

        /** @var EntityModel $entity */
        $entity = new $this->entityModelName;
        $entity->loadingData($properties);

        return $entity;
    }

    public function getLastId(): ? int
    {
        return $this->getLastRecord()->id;
    }

    public function getLastRecord(): ? EntityModel
    {
        $query = $this->makeSelectQuery();
        $query .= ' ORDER BY id DESC LIMIT 1';
        $response = $this->queryOne($query);
        return $response ? $this->makeEntityModel($response) : null;
    }

    protected function makeSelectQuery(array $data = null): string
    {
        $where = $data ? implode(' AND ', $data) : 1;

        return str_replace(
            [
                ':tableName',
                ':1'
            ],
            [
                $this->tableName,
                $where
            ],
            "SELECT * FROM `:tableName` WHERE :1"
        );
    }

    public function createRecord(string $properties, string $values)
    {
        $query = str_replace(
            [
                ':tableName',
                ':properties',
                ':values',
            ],
            [
                $this->tableName,
                $properties,
                $values,
            ],
            "INSERT INTO `:tableName` (`:properties`) VALUES (':values')"
        );

        return $this->query($query);
    }

    public function updateRecord(string $propertiesSet, string $propertyWhere)
    {
        $query = str_replace(
            [
                ':tableName',
                ':propertiesSet',
                ':propertyWhere',
            ],
            [
                $this->tableName,
                $propertiesSet,
                $propertyWhere,
            ],
            "UPDATE `:tableName` SET :propertiesSet WHERE :propertyWhere"
        );

        return $this->query($query);
    }

    private function makeTableAndEntityName(): array
    {
        preg_match_all(
            '/[A-Z][^A-Z]*?/Usu',
            array_pop(
                explode('\\', get_called_class())
            ),
            $incompleteTableName
        );

        $incompleteTableName = array_slice($incompleteTableName[0], 0,-1);

        return [
            'entityModelName' => 'models\\entity\\' . implode('', $incompleteTableName),
            'tableName' => strtolower(
                implode('_', $incompleteTableName)
            ),
        ];
    }

    public function getTableName()
    {
        return $this->tableName;
    }

    public function getDbSchemas()
    {
        return $this->dbSchemas;
    }

    public function getEntityModelName(): ? string
    {
        return $this->entityModelName;
    }
}
