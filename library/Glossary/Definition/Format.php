<?php
namespace Glossary\Definition;

/**
 * Provides useful functionality to work with terms and definitions and how
 * they are stored.
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
     * @param string $desc The description
     * @param string The formatted description
     */
    public static function formatDescription($desc)
    {
        $search  = array("\r\n", "\r", "\n", "\t");
        $replace = array('<br/>', '', '<br/>', '');
        $str = str_replace($search, $replace, $desc);

        // Split by whitespace, then trim non-word-characters. What's left is a rough
        // approximation of all words in the given text.
        $matches = preg_split('#\s#', $str);
        $matches = array_map(function($s) {
            return preg_replace('#^[^\w]*#', '', preg_replace('#[^\w]*$#', '', $s));
        }, $matches);
        $matches = array_unique($matches);

        foreach ($matches as $match) {
            $trimmed = trim($match);
            $term = self::cleanTerm($trimmed);

            try {
                $definition = \Glossary\Definition\DefinitionFactory::getInstance()->fromTerm($term);
                $str = str_replace($trimmed, '<span class="termLink" data-term="' . $trimmed . '">' . $trimmed . '</span>', $str);
            } catch (\Exception $e) {
                continue;
            }
        }

        return $str;
    }
}