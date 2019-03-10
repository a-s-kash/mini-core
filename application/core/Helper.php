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
            echo "<s>!function_exists get_headers</s>";
            return null;
        }

        $check_url = get_headers($link);
        //$file_headers = @get_headers($link);

        if(!(!$check_url || strpos($check_url[0],'404'))){
            return $link;
        }

        switch ($recursion){
            case 0:
                $oldLink = $link;
                $newLink = $link;
                preg_match('(www.)', $link, $matches);
                if(!$matches){
                    $newLink = explode('/', $link);
                    $newLink[2] = 'www.' . $newLink[2];
                    $newLink = implode('/', $newLink);
                }
                break;
            case 1:
                $newLink = str_replace('http:', 'https:', $link);
                break;
            default :
                return null;
        }

        return $this->checkLink($newLink, ++$recursion, $oldLink);
    }

//    private function url_exists($url) {
//        if (!$fp = curl_init($url)) return false;
//        return true;
//    }

    public function currentDateTime(): ? \DateTime
    {
        return (new \DateTime('now', new \DateTimeZone(App::config()->getParams('date_time_zone'))));
    }
}
