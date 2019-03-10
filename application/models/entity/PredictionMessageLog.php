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

    public function getCookieTime(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->cookieTime);
    }

    public function setCookieTime(\DateTime $cookieTime): self
    {
        $this->cookieTime = $cookieTime;

        return $this;
    }

    public function addPredictionMessageLog(PredictionMessageLog $predictionMessageLog): self
    {

        //(new PredictionMessageLogRepository())->push($predictionMessageLog);

        return $this;
    }

    public function addVisitor(Visitor $visitor): self
    {
        (new VisitorRepository())->push($visitor);

        return $this;
    }
}
