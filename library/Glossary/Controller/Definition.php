<?php
namespace Glossary\Controller;

use \Glossary\Definition\Format;
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
            $this->redirect('definition/' . urlencode($_POST['searchTerm']));
        } else {
            $this->redirect('/');
        }
    }

    /**
     * Is called when a definition should be displayed. Further definitions
     * will be loaded on demand, so we start with only the central one.
     *
     * @todo Rework data storage of definitions to use a database or something
     * @param array $args The route parameters
     */
    public function defineAction($args)
    {
        $term = Format::cleanTerm(urldecode(reset($args)));

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->fromTerm($term);
        } catch (Exception $e) {
            $this->_view->errors = array('Suchbegriff nicht gefunden.');
            return;
        }

        $this->_view->mainTerm = $definition->getTerm();
        $this->_view->mainDescription = Format::formatDescription($definition->getDescription());
    }

    /**
     * Is called when a definition is loaded via AJAX call, for example from an
     * existing definition page. We load the definition data and return it
     * formated as a card, that is supposed be inserted into a card area.
     *
     * NOTE: Because this is an AJAX action, we do not return from this call and
     * exit script execution with "exit".
     *
     * @todo Restructure AJAX calls to not exit early, but somehow use the existing
     *    MVC structure. Maybe something with disableHeaderFooter?
     * @param array $args The AJAX call's arguments as key -> value pairs
     */
    public function ajaxAction($args)
    {
        $term = Format::cleanTerm(urldecode(reset($args)));

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->fromTerm($term);

            echo "<div class=\"definitionCard main\">
                    <span class=\"definitionTerm\">"
                         . $definition->getTerm()
                    . "</span>

                    <br/>

                    <span class=\"definitionDescription\">"
                        . Format::formatDescription($definition->getDescription())
                    . "</span>
                </div>";

        } catch (Exception $e) {
            echo "<div class=\"errors\">
                <span class=\"error\">Suchbegriff nicht gefunden</span>
                </div>";
        }

        exit;
    }
}