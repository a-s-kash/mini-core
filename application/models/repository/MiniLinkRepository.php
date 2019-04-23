<?php

namespace models\repository;

use models\entity\MiniLink;
use core\repository\MainRepository;

class MiniLinkRepository extends MainRepository
{
    public function findByMinimizedLinkKey(string $linkKey): ? MiniLink
    {
        /** @var MiniLink $miniLink */
        $miniLink = $this->find()
            ->where("minimized_link_key = '$linkKey'")
            //->andWhere('life_time > ' . App::currentDateTime()->getTimestamp())
            ->one()
        ;

        //d($miniLink);

        if(!$miniLink){
            return null;
        }

        return $miniLink;
    }
}
