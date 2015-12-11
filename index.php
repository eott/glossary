<?php

// This is final, we do not negotiate about error reporting.
// We show all errors and that's it. No excuses.
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

require 'library/vendor/autoload.php';
//require 'library/glossary/autoload.php';

$app = new \Slim\Slim(array(
    'templates.path' => './templates'
));

$app->get('/', function () use ($app) {
    $app->render('index.phtml');
});

$app->run();