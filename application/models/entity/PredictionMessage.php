<?php

namespace models\entity;

use core\App;
use core\repository\EntityModel;

class PredictionMessage extends EntityModel
{
    private $predictionMessageLogs = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCategoryId(): string
    {
        return $this->categoryId;
    }

    public function setCategoryId(PredictionCategory $category): self
    {
        $this->categoryId = $category->getId();

        return $this;
    }

    public function addPredictionMessageLog(PredictionMessageLog $predictionMessageLog): self
    {
        if(!$this->id){
            self::repository()->push($this);
        }

        d([
            'PredictionMessage #3',
            'check id',
            $this,
        ]);

        PredictionMessageLog::repository()->push(
            $predictionMessageLog
                ->setPredictionMessageId($this)
                ->setCookieTime(
                    App::helper()->currentDateTime()
                )
        );

        $this->predictionMessageLogs[] = $predictionMessageLog;

        return $this;
    }
}
