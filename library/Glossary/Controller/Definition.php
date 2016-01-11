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
     * @param array $args The route parameters
     */
    public function defineAction($args)
    {
        $term = Format::cleanTerm(urldecode(reset($args)));
        $filename = APPLICATION_PATH . '/data/' . $term . '.json';
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename));
            $this->_view->mainTerm = $data->term;
            $this->_view->mainDescription = Format::formatDescription($data->description);
        } else {
            $this->_view->errors = array('Suchbegriff nicht gefunden.');
        }
    }

    public function ajaxAction($args)
    {
        $term = Format::cleanTerm(urldecode(reset($args)));
        $filename = APPLICATION_PATH . '/data/' . strtolower($term) . '.json';
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename));
            echo "<div class=\"definitionCard main\">
                    <span class=\"definitionTerm\">"
                         . $data->term
                    . "</span>

                    <br/>

                    <span class=\"definitionDescription\">"
                        . $data->description
                    . "</span>
                </div>";
        }
        exit;
    }
}