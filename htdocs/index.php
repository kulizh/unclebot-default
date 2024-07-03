<?php
require_once dirname(__FILE__) . '/../data/vendor/autoload.php';

use \Unclebot\Utils\Logger;

// project scope functions
function ppd($array)
{
    echo '<pre>';
    print_r($array);
    die('</pre>');
}

// const
define('FILES_DIR', realpath(dirname(__FILE__) . '/../data/files/') . '/');

try {
    $router = new Unclebot\Router;
    $router->handle();
} catch (Exception $exception) {
    $logger = new Logger('errors');
    $logger->write($exception);
}
