<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class MiniLink extends EntityModel
{
    /** @var array  */
    public $clickLinks = [];

    /** @var int */
    public $clickLinksCount;

    /** @var string */
    public $minimizedLink;

    /** @var bool */
    public $timeIsOver = false;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOriginalLink(): ? string
    {
        return $this->originalLink;
    }

    public function setOriginalLink(string $originalLink)
    {
        $this->originalLink = $originalLink;

        return $this;
    }

    public function getMinimizedLinkKey(): ? string
    {
        return $this->minimizedLinkKey;
    }

    public function setMinimizedLinkKey(string $minimizedLinkKey)
    {
        $this->minimizedLinkKey = $minimizedLinkKey;

        return $this;
    }

    public function getLifeTime(): ? int
    {
        return $this->lifeTime;
    }

    public function setLifeTime(int $lifeTime)
    {
        $this->lifeTime = $lifeTime;

        return $this;
    }

    public function makeMinimizedLink(): string
    {
        if(!$this->minimizedLink){
            $this->minimizedLink = implode('', [
                'http://',
                $_SERVER['HTTP_HOST'],
                '/',
                str_replace('-', '', $this->minimizedLinkKey)
            ]);
        }

        return $this->minimizedLink;
    }

    public function makeClickLinks(): void
    {
        if(!$this->clickLinks){
            $this->clickLinks = (new ClickLinkRepository())->findAll(['mini_link_id = ' . $this->getId()]);
        }

        $this->clickLinksCount = count($this->clickLinks);
    }
}
