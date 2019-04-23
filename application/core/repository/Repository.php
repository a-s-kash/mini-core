<?php

namespace core\repository;

interface Repository
{
    public function getTableName(): string;

    public function getDbSchemas(): string;

    public function getEntityModelName(): ? string;
}
