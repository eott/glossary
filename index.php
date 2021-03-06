<?php

// This is final, we do not negotiate about error reporting.
// We show all errors and that's it. No excuses.
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

// Useful globals
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__)));

defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Register autoloaders
require 'library/vendor/autoload.php';
require 'library/Glossary/autoload.php';

// Read config file
if (file_exists(APPLICATION_PATH . '/config.ini')) {
    $config = parse_ini_file(APPLICATION_PATH . '/config.ini', true);
} else {
    $config = parse_ini_file(APPLICATION_PATH . '/config-default.ini', true);
}

// Create database connection
$dbConfig           = new \Doctrine\DBAL\Configuration();
$connectionParams = array(
    'dbname'   => $config['DB']['name'],
    'user'     => $config['DB']['user'],
    'password' => $config['DB']['password'],
    'host'     => $config['DB']['host'],
    'driver'   => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $dbConfig);

// Bootstrap the Slim app
$app = new \Slim\Slim(array(
    'templates.path' => './templates',
    'view'           => new \Glossary\View(),
    'settings'       => $config,
    'db'             => $conn,
));

// Add the routes to the app
$router = new \Glossary\Router();
foreach ($router->getRoutes() as $route) {
    $app->map($route['pattern'], function() use ($route, $router) {
        $params = func_get_args();
        $router->routeCallback($route, $params);
    })->via('GET', 'POST');
}

// All done, run
$app->run();