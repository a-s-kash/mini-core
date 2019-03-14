<?php

namespace models\entity;

use core\repository\EntityModel;

class PredictionCategory extends EntityModel
{
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
}
