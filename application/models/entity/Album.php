<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class Album extends EntityModel
{
    /** @var Artist */
    private $artist;

    public function getId(): int
    {
        return $this->id;
    }

    public function getAlbumName(): string
    {
        return $this->albumName;
    }

    public function setMiniLinkId(string $albumName): self
    {
        $this->albumName = $albumName;

        return $this;
    }

    public function getAlbumCover(): string
    {
        return $this->timeFollowedOnLink;
    }

    public function setAlbumCover($albumCover): self
    {
        $this->albumCover = $albumCover;

        return $this;
    }

    public function getArtist(): ? Artist
    {
        if(!$this->artist){
            $this->artist = Artist::repository()
                ->find($this->artistId)
                ->one()
            ;
        }

        return $this->artist;
    }

    public function setArtistId(Artist $artist): self
    {
        $this->artist = $artist->getId();

        return $this;
    }

    public function addArtist(Artist $artist): self
    {
        if(!$artist->id){
            Artist::repository()->push($artist);
        }

        $this->setArtistId($artist);

        return $this;
    }

    public function getYearOfIssue(): int
    {
        return (int) $this->yearOfIssue;
    }

    public function setYearOfIssue(int $yearOfIssue): self
    {
        $this->yearOfIssue = (int) $yearOfIssue;

        return $this;
    }

    public function getAlbumDuration()
    {
        return $this->yearOfIssue;
    }

    public function setAlbumDuration(\DateTime $albumDuration): self
    {
        $this->albumDuration = $albumDuration;

        return $this;
    }
}
