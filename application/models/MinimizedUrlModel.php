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

        return $this->keyGeneration(array_reverse(explode("-", $minimizedLinkKey)));
    }
//!$miniLink = $MiniLinkRepository->findAll(["original_link = '$originalLink'"])[0]
    private function keyGeneration(array $miniLinkKeyArray, $recursion = 0): ? string
    {
        switch ($recursion){
            case 0;
            case 1:
                if(!$this->increaseByOne($miniLinkKeyArray[$recursion])){
                    $miniLinkKeyArray[$recursion] = $this->alphabet[0];
                    return $this->keyGeneration($miniLinkKeyArray, ++$recursion);
                }
                break;
            default :
                $miniLinkKeyArray[$recursion]++;
                break;
        }

        return implode('-', array_reverse($miniLinkKeyArray));
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
}
