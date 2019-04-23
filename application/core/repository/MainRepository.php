<?php

namespace core\repository;

use core\query\SelectQueryBuilder;

abstract class MainRepository implements Repository
{
    /** @var string */
    private $tableName;

    /** @var string */
    private $entityModelName;

    /** @var string */
    protected $dbSchema = ActiveRecord::DATA_BASE_SQLITE;

    /** @var ActiveRecord  */
    public $activeRecord;

    public function __construct()
    {
        $this->makeTableAndEntityName();
        $this->activeRecord = new ActiveRecord($this);
    }

    public function find(): SelectQueryBuilder
    {
        return $this->activeRecord
            ->getSelectQueryBuilder()
        ;
    }

    public function findById(int $id): ? EntityModel
    {
        $queryBuilder = $this->activeRecord
            ->getSelectQueryBuilder()
            ->where('id = ' . (int) $id)
        ;

        return $queryBuilder->one();
    }

    public function push(EntityModel $entity): EntityModel
    {
        $properties = $entity->getProperties();

//        d([
//            'Repository - push',
//            $properties,
//        ]);

        if($entity->id){
            $this->activeRecord->getUpdateQueryBuilder($entity);
        } else {
            $this->activeRecord->getInsertQueryBuilder($entity);
        }

//        if($this->createRecord($propertiesName, $propertiesVal)){
//            $entity->id = $this->getLastInsertId();
//        }

        return $entity;
    }

    public function getTableName(): string
    {
        return $this->tableName;
    }

    public function getDbSchemas(): string
    {
        return $this->dbSchema;
    }

    public function getEntityModelName(): ? string
    {
        return $this->entityModelName;
    }

    private function makeTableAndEntityName(): void
    {
        static $config = [];

        $repositoryName = get_called_class();

        if(!$config[$repositoryName]){

            preg_match_all(
                '/[A-Z][^A-Z]*?/Usu',
                array_pop(
                    explode('\\', get_called_class())
                ),
                $incompleteTableName
            );

            $incompleteTableName = array_slice($incompleteTableName[0], 0,-1);

            $config[$repositoryName] = [
                'entityModelName' => 'models\\entity\\' . implode('', $incompleteTableName),
                'tableName' => strtolower(
                    implode('_', $incompleteTableName)
                ),
            ];
        }

        $this->entityModelName = $config[$repositoryName]['entityModelName'];
        $this->tableName = $config[$repositoryName]['tableName'];
    }
}
