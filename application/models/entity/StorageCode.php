<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class StorageCode extends EntityModel
{
    /** @var Album */
    private $album;

    /**
     * @var array
     */
    private $storageCode = [];

    private $template = '[roomNumber]:[rackNumber]:[shelfNumber]';

    /** @var string */
    private $roomNumber;

    /** @var string */
    private $rackNumber;

    /** @var string */
    private $shelfNumber;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): string
    {
        return $this->code ?? (
                $this->roomNumber
                && $this->rackNumber
                && $this->shelfNumber
            ) ? $this->setCode()->getCode()
            : null
        ;
    }

    public function setCode(): self
    {
        $storageCode = str_replace([
            '[roomNumber]',
            '[rackNumber]',
            '[shelfNumber]',
        ], [
            $this->roomNumber,
            $this->rackNumber,
            $this->shelfNumber
        ], $this->template);

        if(!$this->roomNumber
            || !$this->rackNumber
            || !$this->shelfNumber
        ){
            self::trace('incorrect "Storage Code"',
                 "\n" . $storageCode
            );
        }

        $this->code = $storageCode;

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
