<?php

namespace core;

use conf\Config;

class Helper
{
    /** @var Config  */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function getPrepareAppPatch(string $path): string
    {
        return $this->config->getParams('app_patch') . $path;
    }

    public function checkLink(string $link, int $recursion = 0, string $oldLink = ''): ? string
    {
        if (!function_exists('get_headers')) {
            //echo "<s>get_headers</s>";
            return null;
        }

        $check_url = get_headers($link);

        if(strpos($check_url[0],'200')){
            return $link;
        }

        switch ($recursion){
            case 0:
                $newLink = explode('/', $link);
                $newLink[2] = 'www.' . $newLink[2];
                $newLink = implode('/', $newLink);
                $oldLink = $link;
                break;
            case 1:
                $newLink = str_replace('http:', 'https:', $oldLink);
                break;
            case 2:
                $newLink = explode('/', $link);
                $newLink[2] = 'www.' . $newLink[2];
                $newLink = implode('/', $newLink);
                break;
            default :
                return null;
        }

        return $this->checkLink($newLink, ++$recursion, $oldLink);
    }
}
