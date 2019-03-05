<?php

spl_autoload_register(function ($class_name) {
    $path = '../application/';
    $path .= str_replace('\\', "/", "$class_name.php");
    if(file_exists($path)){
        include $path;
    }
});

new \core\App();

d([
    'App end',
    \core\App::helper()->getPrepareAppPatch('df')
]);
//$df = new ActiveQuerySQLite(Config::getParams('db_patch'));


