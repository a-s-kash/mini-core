<?php

namespace core\repository;

abstract class Repository extends ActiveRecord
{
    /** @var array  */
    private $response = [];

    public function findById(int $id, $entireRow = true): ? EntityModel
    {
        $query = $this->makeSelectQuery(["id = $id"]);
        $this->response = $this->queryOne($query, $entireRow);
        return $this->makeEntityModel($this->response);
    }

    public function findAll(array $data = null): ? array
    {
        $response = [];
        $query = $this->makeSelectQuery($data);
        $this->response = $this->queryAll($query);
        foreach($this->response as $val){
            $response[] = $this->makeEntityModel($val);
        }

        return $response;
    }

    public function push(EntityModel $entity)
    {
        $properties = $entity->getProperties();

        if($entity->id){
            $set = [];
            unset($properties['id']);
            foreach ($properties as $propertyName => $propertyVal){
                $set[] = "`$propertyName` = '$propertyVal'";
            }
            return $this->updateRecord(implode(', ', $set), '`id` = ' . $entity->id);
        }

        $propertiesName = implode('`, `', array_keys($properties));
        $propertiesVal = implode("', '", $properties);
        return $this->createRecord($propertiesName, $propertiesVal);
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
}
