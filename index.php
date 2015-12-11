<?php

// This is final, we do not negotiate about error reporting.
// We show all errors and that's it. No excuses.
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

// Register autoloaders
require 'library/vendor/autoload.php';
require 'library/Glossary/autoload.php';

// Bootstrap the Slim app
$app = new \Slim\Slim(array(
    'templates.path' => './templates'
));

// Add the routes to the app
$router = new \Glossary\Router();
foreach ($router->getRoutes() as $route) {
    $app->get($route['pattern'], function() use ($app, $route) {
        // Check if the given controller needs to do something
        if (!empty($route['controller'])) {
            $action     = isset($route['action']) ? $route['action'] : 'index';
            $controller = new $route['controller']($app->view());
            $controller->action($action, func_get_args());
        }

        // Render the template
        $app->render($route['template']);
    });
}

// All done, run
$app->run();