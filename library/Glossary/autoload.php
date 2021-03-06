<?php

/**
 * Register an autoloader for glossary classes by their namespace. Only
 * classes within the namespace Glossary are required, others are ignored
 * by this autoloader.
 */
spl_autoload_register(function($name) {
    if (strcasecmp(substr(ltrim($name, "\\"), 0, 8), 'Glossary') === 0) {
        require_once (__DIR__ . '/../' . str_replace('\\', '/', $name) . '.php');
    }
});