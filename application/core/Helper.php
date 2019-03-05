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
}
