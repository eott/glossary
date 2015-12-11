<?php
namespace Glossary\Controller;

class Definition
{
    public function __construct($view)
    {
        $this->_view = $view;
    }

    public function action($name, $args)
    {
        if (is_callable(array($this, $name . 'Action'))) {
            $this->{$name . 'Action'}($args);
        } else {
            throw new \Exception("Unknown action $name in controller " . __CLASS__);
        }
    }

    public function indexAction()
    {

    }
}