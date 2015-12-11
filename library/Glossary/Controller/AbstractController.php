<?php
namespace Glossary\Controller;

/**
 * Used for request handling and work with the MVC pattern. The controller
 * is called by the routing mechanism before the view is rendered. Here, the
 * developers should place to fetch/update data and do other other work that
 * is not specific to the rendering of the response.
 */
abstract class AbstractController
{
    /**
     * Constructor. Create a controller instance working with the given view.
     * The controller might attach data to the view, that it in turn needs
     * to render the content.
     *
     * @param Slim\View $view The view
     */
    public function __construct($view)
    {
        $this->_view = $view;
    }

    /**
     * Calls the action with the given name and the given arguments. If the given
     * action doesn't exist, throws an exception.
     *
     * @param string $name The name of the action without the 'Action' suffix
     * @param array $args An array of function arguments
     */
    public function action($name, $args)
    {
        if (is_callable(array($this, $name . 'Action'))) {
            $this->{$name . 'Action'}($args);
        } else {
            throw new \Exception("Unknown action $name in controller " . __CLASS__);
        }
    }
}