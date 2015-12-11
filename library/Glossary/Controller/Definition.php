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
        $term = $this->cleanTerm(urldecode(reset($args)));
        $filename = APPLICATION_PATH . '/data/' . $term . '.json';
        if (file_exists($filename)) {
            $data = json_decode(file_get_contents($filename));
            $this->_view->mainTerm = $data->term;
            $this->_view->mainDescription = $this->formatDescription($data->description);
        } else {
            $this->_view->errors = array('Suchbegriff nicht gefunden.');
        }
    }

    /**
     * Cleans the given seach term for its use in the filename based system.
     *
     * @param string $term The search term
     * @return string The cleaned search term
     */
    public function cleanTerm($term)
    {
        $search  = array('\r', '\n', '\t', ' ');
        $replace = array('', '', '', '-');
        $str     = strtolower(str_replace($search, $replace, $term));
        $str     = preg_replace('[^\w-]', '', $term);
        return $str;
    }

    /**
     * Formats the given description for its use in the output.
     *
     * @param string $desc The description
     * @param string The formatted description
     */
    public function formatDescription($desc)
    {
        $search  = array('\r', '\n', '\t');
        $replace = array('', '<br/>', '');
        return str_replace($search, $replace, $desc);
    }
}