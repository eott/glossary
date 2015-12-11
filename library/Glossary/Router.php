<?php
namespace Glossary;

class Router
{
    /**
     * Returns a list of routes that should be registered with the Slim app.
     * Each routes contains the route pattern as well as the template that
     * should be rendered.
     *
     * @return array A list of routes with the pattern as key and the template
     *    name as value.
     */
    public function getRoutes()
    {
        return array('/' => 'index.phtml');
    }
}