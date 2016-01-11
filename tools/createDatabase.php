<?php

// This is final, we do not negotiate about error reporting.
// We show all errors and that's it. No excuses.
error_reporting(E_ALL | E_NOTICE);
ini_set('display_errors', 1);

// Useful globals
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../'));

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
    'dbname'   => 'information_schema', // Doctrine DBAL does not allow a connection without a database
    'user'     => $config['DB']['user'],
    'password' => $config['DB']['password'],
    'host'     => $config['DB']['host'],
    'driver'   => 'pdo_mysql',
);
$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $dbConfig);

// Create database
$sql = file_get_contents(APPLICATION_PATH . '/schema/database.sql');
$conn->executeQuery($sql);

// Check which tables to create and execute their creation script
$tables = parse_ini_file(APPLICATION_PATH . '/schema/tables.ini');
foreach ($tables["tables"] as $tableName) {
    $fileName = APPLICATION_PATH . '/schema/' . $tableName . '.sql';
    if (file_exists($fileName)) {
        $sql = file_get_contents($fileName);
        $conn->executeQuery($sql);
    }
}