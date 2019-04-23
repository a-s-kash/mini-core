<?php

namespace models\entity;

use core\repository\EntityModel;

class PredictionCategory extends EntityModel
{
    private $messages = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function setCategoryName(string $categoryName): self
    {
        $this->categoryName = $categoryName;

        return $this;
    }

    public function addPredictionMessageInCategory(PredictionMessage $predictionMessage): self
    {
        if(!$this->id){
            self::repository()->push($this);
        }

        $this->messages[] = $predictionMessage
            ->setCategoryId($this)
        ;

        d([
            'PredictionMessage #3',
            'check id',
            $this,
            $this->id
        ], false);

        PredictionMessage::repository()->push(
            $predictionMessage
        );

        return $this;
    }
}
