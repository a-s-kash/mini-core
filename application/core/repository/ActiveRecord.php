<?php

namespace core\repository;

use core\db\DataBaseMySQL;
use core\db\DataBaseSQLite;
use core\db\DataBase;
use core\query\{
    QueryBuilder,
    SelectQueryBuilder
};

class ActiveRecord
{
    /** @var Repository  */
    private $repository;

    /** @var QueryBuilder */
    private $selectQueryBuilder;

    /** @var DataBase  */
    private $dataBase;

    public function __construct(Repository $repository)
    {
        static $dataBases = [];

        if(!$this->dataBase = $dataBases[$repository->getDbSchemas()]) {
            //$dataBases[$repository->getDbSchemas()] = $this->dataBase = new DataBaseSQLite($repository->getDbSchemas());
            $dataBases['my-sql'] = $this->dataBase = new DataBaseMySQL();
        }

        $this->repository = $repository;
        $this->selectQueryBuilder = new SelectQueryBuilder($repository, $this->dataBase);
    }

    public function getSelectQueryBuilder(): SelectQueryBuilder
    {
        return $this->selectQueryBuilder;
    }
}
