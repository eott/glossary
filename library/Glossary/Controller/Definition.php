<?php
namespace Glossary\Controller;

/**
 * Handles request about definitions.
 */
class Definition extends \Glossary\Controller\AbstractController
{
    /**
     * Is called when a definition should be displayed. Further definitions
     * will be loaded on demand, so we start with only the central one.
     *
     * @param array $args The route parameters
     */
    public function indexAction($args)
    {

    }
}