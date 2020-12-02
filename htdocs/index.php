<?php
require_once dirname(__FILE__) . '/../data/vendor/autoload.php';
error_reporting(0);

// project scope functions
function ppd($array)
{
	echo '<pre>';
	print_r($array);
	die('</pre>');
}

// const
define('FILES_DIR', realpath(dirname(__FILE__) . '/../data/files/') . '/');

// run router
$router = new Unclebot\Router;
$router->handle();
