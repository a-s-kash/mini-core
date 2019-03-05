<?php

use core\Model;
use models\entity\MiniLink;
use models\repository\MiniLinkRepository;

class MinimizedUrlModel extends Model
{
    /** @var array  */
    private $alphabet = [];

    /** @var string  */
    private $defaultKey = '1-a-a';

    /** @var MiniLinkRepository  */
    private $miniLinkRepository;

    /** @var array */
    private $miniLinkKeyArray = [];

    public function __construct()
    {
        $this->alphabet = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
        $this->miniLinkRepository = new MiniLinkRepository();
    }

    public function makeNewMinimizedKey(): string
    {
        /** @var MiniLink $miniLink */
        $miniLink = $this->miniLinkRepository->getLastRecord();
        $minimizedLinkKey = $miniLink ? $miniLink->getMinimizedLinkKey() : $this->defaultKey;

        $this->miniLinkKeyArray = array_reverse(explode("-", $minimizedLinkKey));

        if($this->increaseByOne($this->miniLinkKeyArray[0])){
            return $this->returnNewMiniLinkKey();
        }

        $this->miniLinkKeyArray[0] = $this->alphabet[0];

        if($this->increaseByOne($this->miniLinkKeyArray[1])){
            return $this->returnNewMiniLinkKey();
        }

        $this->miniLinkKeyArray[1] = $this->alphabet[0];
        $this->miniLinkKeyArray[2]++;

        return $this->returnNewMiniLinkKey();
    }

    private function increaseByOne(string &$letter): bool
    {
        if($letter == array_pop($this->alphabet)){
            return false;
        }

        $key = array_search($letter, $this->alphabet);
        $letter = $this->alphabet[++$key];
        return true;
    }

    private function returnNewMiniLinkKey(): string
    {
        return implode('-', array_reverse($this->miniLinkKeyArray));
    }
}
