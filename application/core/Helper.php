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

    public function checkLink(string $link): bool
    {
        if (function_exists('get_headers'))
        {
            $check_url = get_headers($link);
            return strpos($check_url[0],'200');
        } //else echo "<s>get_headers</s>";

        return false;
    }
}
