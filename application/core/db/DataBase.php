<?php

namespace core\db;


interface DataBase
{
    public function queryAll(string $query);
    public function queryOne(string $query);
}
