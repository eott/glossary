<?php
namespace Glossary\Controller;

/**
 * Handles request about definitions.
 */
class Definition extends \Glossary\Controller\AbstractController
{
    /**
     * Handles when a term search form has been fired. Reads the search term
     * from the form then either redirects to the definition page or back
     * to the front page.
     *
     * @param array $args The route parameters
     */
    public function indexAction($args)
    {
        if (
            isset($_POST['searchTerm'])
            && !empty($_POST['searchTerm'])
        ) {
            $this->redirect('definition/' . $_POST['searchTerm']);
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Is called when a definition should be displayed. Further definitions
     * will be loaded on demand, so we start with only the central one.
     *
     * @param array $args The route parameters
     */
    public function defineAction($args)
    {
        $term = reset($args);
        $this->_view->mainTerm = $term;
    }
}