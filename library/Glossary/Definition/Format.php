<?php
namespace Glossary\Definition;

/**
 *
 */
class Format
{
    /**
     * Cleans the given seach term for its use in the filename based system.
     *
     * @param string $term The search term
     * @return string The cleaned search term
     */
    public static function cleanTerm($term)
    {
        $search  = array("\r\n", "\r", "\n", "\t", " ");
        $replace = array('', '', '', '', '-');
        $str     = strtolower(str_replace($search, $replace, $term));
        $str     = preg_replace('[^\w-]', '', $str);
        return $str;
    }

    /**
     * Formats the given description for its use in the HTML output.
     * This also looks for other key words in the description and highlights
     * them for the user, so they can choose to load the definition.
     *
     * @todo Extract search for keywords into creation of cards or regular
     *    check. This is too costly to do on every request.
     * @todo The key word search does not work properly yet. This probably
     *    needs an external library for matching words in text
     * @param string $desc The description
     * @param string The formatted description
     */
    public static function formatDescription($desc)
    {
        $search  = array("\r\n", "\r", "\n", "\t");
        $replace = array('<br/>', '', '<br/>', '');
        $str = str_replace($search, $replace, $desc);

        $matches = array();
        $pattern = '#\s(\w+)[\s\.,!\?"\']#m';
        preg_match_all($pattern, $str, $matches);

        if (isset($matches[1])) {
            foreach ($matches[1] as $match) {
                $trimmed = trim($match);
                $term = self::cleanTerm($trimmed);

                $filename = APPLICATION_PATH . '/data/' . strtolower($term) . '.json';
                if (file_exists($filename)) {
                    $str = str_replace($trimmed, '<span class="termLink" data-term="' . $trimmed . '">' . $trimmed . '</span>', $str);
                }
            }
        }

        return $str;
    }
}