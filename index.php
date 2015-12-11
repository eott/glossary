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
foreach ($router->getRoutes() as $pattern => $template) {
    $app->get($pattern, function() use ($app, $template) {
        $app->render($template);
    });
}

// All done, run
$app->run();