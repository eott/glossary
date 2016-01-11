<?php
namespace Glossary;

class View extends \Slim\View
{
    /**
     * @var string The base URL of our application.
     */
    protected $_baseUrl = null;

    /**
     * @see \Slim\View::render()
     */
    public function render($template)
    {
        return parent::render($template);
    }

    /**
     * Returns the base URL used for constructing relative URI paths. Lazy-loads
     * the base URL from the app config if it is not set.
     *
     * @return string The base URL
     */
    public function getBaseUrl()
    {
        if ($this->_baseUrl === null) {
            $config = \Slim\Slim::getInstance()->config('settings');
            $this->_baseUrl = $config['App']['base_url'];
        }
        return $this->_baseUrl;
    }

    /**
     * Sets the base URL to the given value.
     *
     * @param string $url The base URL
     * @return $this
     */
    public function setBaseUrl($url)
    {
        $this->_baseUrl = $url;
        return $this;
    }

    /**
     * Formats the given route fragment so it completes the baseURL to form
     * a valid URL that points to the correct URI for what we're linking.
     * This method is designed to not touch already valid global URLs outside
     * the app space.
     *
     * @param string $route The route to link to
     * @return string The formatted URL
     */
    public function url($route)
    {
        if (stristr($route, ':') !== false) {
            // Looks like we got a global URL with procotol and whatnot
            return $route;
        }

        if (strpos($route, '//') === 0) {
            // A lazy-format global URL
            return $route;
        }

        // Now we are reasonably certain we got in fact a route relative to our
        // base URL

        // Check if route already begins with slash
        $slash = false;
        if (strpos($route, '/') === 0) {
            $slash = true;
        }

        return $this->getBaseUrl() . ($slash ? '' : '/') . $route;
    }
}