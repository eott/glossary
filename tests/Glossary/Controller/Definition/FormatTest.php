<?php
use \Glossary\Definition\Format;

class FormatTest extends PHPUnit_Framework_TestCase
{
    public function testCleanTerm()
    {
        $this->assertEquals("foo-bar", Format::cleanTerm("foo bar"));
        $this->assertEquals("foobar", Format::cleanTerm("foo\t\r\nbar"));
    }

    public function testFormatDescriptionUnknownTerms()
    {
        // Note: Because we expect no known terms here, we must use obscure
        // test terms, that will most likely never get a definition
        $input = "Duai289fh doasn230:\n"
            . "\t-bnsb0243\n"
            . "\t-lgj23834";

        $output = "Duai289fh doasn230:<br/>"
            . "-bnsb0243<br/>"
            . "-lgj23834";

        $this->assertEquals($output, Format::formatDescription($input));
    }

    public function testFormatDescriptionKnownTerms()
    {
        $result = $this->getMockBuilder('Doctrine\DBAL\Driver\Statement')
            ->getMock();

        $db = $this->getMockBuilder('Doctrine\DBAL\Connection')
            ->disableOriginalConstructor()
            ->getMock();

        $result->method('fetch')
            ->willReturn(array('definition_id' => 1, 'term' => 'Begriff', 'description' => ''));

        $db->method('executeQuery')
            ->willReturn($result);

        \Glossary\Definition\DefinitionFactory::getInstance()->setDb($db);

        // Note: We must terms here, that we know will exist in the environment
        $input = "f9823hf92hrf Begriff ";
        $output = "f9823hf92hrf <span class=\"termLink\" data-term=\"Begriff\">Begriff</span> ";
        $this->assertEquals($output, Format::formatDescription($input));
    }
}