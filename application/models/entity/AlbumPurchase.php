<?php

namespace models\entity;

use core\repository\EntityModel;
use models\repository\ClickLinkRepository;

class AlbumPurchase extends EntityModel
{
    /** @var Artist */
    private $artist;

    public function getId(): int
    {
        return $this->id;
    }

    public function getPurchaseDate(): \DateTime
    {
        return (new \DateTime())->setTimestamp($this->albumName);
    }

    public function setPurchaseDate(\DateTime $purchaseDate): self
    {
        $this->purchaseDate = $purchaseDate->getTimestamp();

        return $this;
    }

    public function getPurchasePrice(): float
    {
        return round($this->purchasePrice, 2);
    }

    public function setPurchasePrice(int $price): self
    {
        $this->purchasePrice = round($price, 2);

        return $this;
    }

    public function getStorageCode(): ? string
    {
        if(!$this->artist){
            $this->artist = Artist::repository()
                ->find($this->artistId)
                ->one()
            ;
        }

        return $this->artist;
    }

    public function setStorageCode(array $storageCode): self
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
