<?php

namespace models\entity;

use core\repository\EntityModel;

class PredictionMessageLog extends EntityModel
{
    public function getId(): int
    {
        return $this->id;
    }

    public function getPredictionMessageId(): string
    {
        return $this->predictionMessageId;
    }

    public function setPredictionMessageId(PredictionMessage $message)
    {
        $this->predictionMessageId = $message->getId();

        return $this;
    }

    public function getVisitorId(): string
    {
        return $this->visitorId;
    }

    public function setVisitorId(Visitor $visitor): self
    {
        $this->visitorId = $visitor->getId();

        return $this;
    }
}
