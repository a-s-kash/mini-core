<?php

namespace models\repository;

use core\repository\Repository;
use models\entity\MiniLink;

class MiniLinkRepository extends Repository
{
    public function findByMinimizedLinkKey(string $linkKey): ? MiniLink
    {
        $query = $this->makeSelectQuery([
            "minimized_link_key = '$linkKey'",
            //'life_time > ' . App::currentDateTime()->getTimestamp()
        ]);

        if(!$response = $this->queryOne($query)){
            return null;
        }

        /** @var MiniLink $miniLink */
        $miniLink = $this->makeEntityModel($response);

        return $miniLink;
    }
}
