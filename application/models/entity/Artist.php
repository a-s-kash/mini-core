<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class Artist extends EntityModel
{
    private $albums = [];

    public function getId(): int
    {
        return $this->id;
    }

    public function getArtistName(): string
    {
        return $this->albumName;
    }

    public function setArtistName(string $artistName): self
    {
        $this->artistName = $artistName;

        return $this;
    }

    public function albums(): ? array
    {
        if($this->id){
            $this->albums = Album::repository()
                ->find()
                ->where('artist_id = ' . (int) $this->id)
                ->all()
            ;
        }

        return $this->artist;
    }

    public function addAlbum(Album $album): self
    {
        if(!$this->id){
            self::repository()->push($this);
        }

        Album::repository()->push($album
            ->setArtistId($this)
        );

        return $this;
    }
}
