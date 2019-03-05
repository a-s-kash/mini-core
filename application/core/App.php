<?php

namespace core;

use conf\Config;

class App extends Route
{
    /** @var array */
    private static $data = [];

    public function __construct()
    {
        parent::__construct();

        $config = new Config();
        $helper = new Helper($config);

        self::$data = [
            'config' => $config,
            'helper' => $helper,
            'route' => $this,
        ];

        $this->checkFollowingToTheLink();
        $this->launchRouting();
    }

    public static function config(): ? Config
    {
        return self::$data['config'];
    }

    public static function helper(): ? Helper
    {
        return self::$data['helper'];
    }

    public static function route(): ? Route
    {
        return self::$data['route'];
    }

    public static function currentDateTime(): ? \DateTime
    {
        return (new \DateTime('now', new \DateTimeZone(self::config()->getParams('date_time_zone'))));
    }
}
