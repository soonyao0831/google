<?php
// error_reporting(E_ERROR | E_PARSE);

$_SERVER['SCRIPT_NAME'] = basename(__FILE__);
$url = parse_url($_SERVER['REQUEST_URI'])['path'];

$file = __DIR__ . $url;
if (is_file($file)) {
	return false;
}

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/config/includes.php';

$containerBuilder = new ContainerBuilder();
$containerBuilder->addDefinitions([]);
AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

$middlewares = require __DIR__ . '/config/middlewares.php';
$middlewares($app);

$routes = require __DIR__ . '/config/routes.php';
$routes($app, $url);

$exceptions = require __DIR__ . '/config/exceptions.php';
$exceptions($app);