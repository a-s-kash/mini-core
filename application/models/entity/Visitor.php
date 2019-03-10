<?php

namespace models\entity;

use core\App;
use core\repository\EntityModel;

class Visitor extends EntityModel
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->userIdentifier;
    }

    public function setUserIdentifier(string $userIdentifier): string
    {
        $this->userIdentifier = $userIdentifier;

        return $this->userIdentifier;
    }

    public function getTimeCreated(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->timeCreated);
    }

    public function getProperties(): array
    {
        $this->timeCreated = App::helper()->currentDateTime()->getTimestamp();

        return parent::getProperties();
    }
}
