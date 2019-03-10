<?php

namespace core\repository;

use core\App;

class ActiveRecord extends ActiveQuerySQLite
{
    /** @var string */
    protected $tableName;

    /** @var EntityModel */
    protected $entityModelName;

    /** @var Repository */
    protected $repository;

    public function __construct()
    {
        $this->makeTableAndEntityName();

        $dbPatch = App::config()->getParams('app_patch');
        $dbPatch .= App::config()->getParams('db_patch');

        parent::__construct($dbPatch);
    }

    private function makeTableAndEntityName(): void
    {
        preg_match_all(
            '/[A-Z][^A-Z]*?/Usu',
            array_pop(
                explode('\\', get_called_class())
            ),
            $incompleteTableName
        );

        $incompleteTableName = array_slice($incompleteTableName[0], 0,-1);

        $this->entityModelName = 'models\\entity\\' . implode('', $incompleteTableName);

        $this->tableName = strtolower(
            implode('_', $incompleteTableName)
        );
    }

    public static function find()
    {
        d([
//           "Self: " => get_class(self),
//           "Parent: " => get_class(parent),
//           "Derived: " => get_class(static)
        ]);
        return '';
    }

    protected function makeSelectQuery(array $data = null): string
    {
        if(!$this->tableName){
            d('makeSelectQuery');
        }

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
}
