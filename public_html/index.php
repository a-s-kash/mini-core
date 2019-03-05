<?php

function d($pre, $is = true){
    echo '<pre>';
    print_r($pre);
    echo '</pre>';
    if($is){
        exit;
    }
}

ini_set('display_errors', 1);
spl_autoload_register(function ($class_name) {
    $path = '../application/';
    $path .= str_replace('\\', "/", "$class_name.php");
    if(file_exists($path)){
        include $path;
    }
});

new \core\App();
