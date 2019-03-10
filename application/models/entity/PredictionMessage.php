<?php

namespace models\entity;

use core\repository\EntityModel;

class PredictionMessage extends EntityModel
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}
