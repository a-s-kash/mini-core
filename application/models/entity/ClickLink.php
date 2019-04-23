<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class ClickLink extends EntityModel
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getMiniLinkId(): string
    {
        return $this->miniLinkId;
    }

    public function setMiniLinkId($id)
    {
        $this->miniLinkId = $id;

        return $this;
    }

    public function getTimeFollowedOnLink(): string
    {
        return $this->timeFollowedOnLink;
    }

    public function setTimeFollowedOnLink($timeFollowedOnLink)
    {
        $this->timeFollowedOnLink = $timeFollowedOnLink;

        return $this;
    }
}
