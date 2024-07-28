<?php
require_once dirname(__FILE__) . '/../data/vendor/autoload.php';
set_time_limit(60);

use \Unclebot\Utils\Logger;

define('FILES_DIR', realpath(dirname(__FILE__) . '/../data/files/') . '/');

try {
    $router = new Unclebot\Router;
    $router->handle();
} catch (Exception $exception) {

    $logger = new Logger('errors');
    $logger->write($exception);
}
