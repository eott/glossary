<?php
use \Glossary\Definition\Format;

class DefinitionFactoryTest extends PHPUnit_Framework_TestCase
{
    public function testFromIdDoesNotExist()
    {
        $failed = false;

        try {
            \Glossary\Definition\DefinitionFactory::getInstance()->fromId(0);
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertTrue($failed);
    }

    public function testFromIdDoesExist()
    {
        $failed = false;

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->fromId(1);
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertFalse($failed);

        $this->assertEquals('Testbegriff', $definition->getTerm());
    }

    public function testFromTermDoesNotExist()
    {
        $failed = false;

        try {
            // NOTE: We have to be sure the term does not exist
            \Glossary\Definition\DefinitionFactory::getInstance()->fromTerm('08qhew7hg579wghp4ewgh');
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertTrue($failed);
    }

    public function testFromTermDoesExist()
    {
        $failed = false;

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->fromTerm('Testbegriff');
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertFalse($failed);

        $this->assertEquals('Testbegriff', $definition->getTerm());
    }

    public function testCreateFailsMissingData()
    {
        $failed = false;
        $values = array('term' => 'foo');

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->create($values);
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertTrue($failed);
    }

    public function testCreateSuccess()
    {
        $failed = false;
        $values = array(
            // NOTE: We have to make sure the term does not exist yet
            'term'        => 'nfpregnfnfndalkjnfpwcmwaynfhrqegh',
            'description' => 'foo',
        );

        try {
            $definition = \Glossary\Definition\DefinitionFactory::getInstance()->create($values);
        } catch (\Exception $e) {
            $failed = true;
        }

        $this->assertFalse($failed);

        // Delete the definition we just created. This really is not how it's supposed to work, but...
        $db = \Slim\Slim::getInstance()->config('db');
        $db->executeQuery("DELETE FROM definition WHERE term = :term", array('term' => 'nfpregnfnfndalkjnfpwcmwaynfhrqegh'));
    }
}