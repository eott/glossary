<?php

namespace Glossary\Definition;

class DefinitionFactory
{
    protected static $_instance = null;

    /**
     * @var Doctrine\DBAL\Connection $_db The database connection to use for
     *    loading definitions.
     */
    protected $_db = null;

    /**
     * Returns the singleton instance of class Glossary\Definition\DefinitionFactory.
     *
     * @return Glossary\Definition\DefinitionFactory
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Returns the database connection to use for loading definitions. Lazy-loads
     * one from the Slim application if none is set.
     *
     * @return Doctrine\DBAL\Connection The database connection
     */
    public function getDb()
    {
        if ($this->_db === null) {
            $this->_db = \Slim\Slim::getInstance()->config('db');
        }
        return $this->_db;
    }

    /**
     * Sets the database connection to use to the given value.
     *
     * @param Doctrine\DBAL\Connection $db The database connection
     * @return \Glossary\Definition\DefinitionFactory $this
     */
    public function setDb($db)
    {
        $this->_db = $db;
        return $this;
    }

    /**
     * Tries to find a Definition with the given ID and returns it.
     *
     * @param int|string The ID
     * @throws Exception when the definition was not found
     * @return Definition The definition with the given ID
     */
    public function fromId($id)
    {
        $db     = $this->getDb();
        $sql    = "SELECT * FROM definition WHERE definition_id = :id";
        $result = $db->executeQuery($sql, array('id' => $id));
        $row    = $result->fetch();

        if (empty($row)) {
            throw new Exception("Could not find definition with given id $id.");
        }

        $definition = new \Glossary\Definition($row);
        return $definition;
    }

    /**
     * Tries to find a Definition with the given term and returns it. If there
     * multiple definitions with the term, returns the first one found.
     *
     * @param string $term The term
     * @throws Exception when the definition was not found
     * @return Definition The definition with the given term
     */
    public function fromTerm($term)
    {
        $db     = $this->getDb();
        $sql    = "SELECT * FROM definition WHERE term = :term";
        $result = $db->executeQuery($sql, array('term' => $term));
        $row    = $result->fetch();

        if (empty($row)) {
            throw new Exception("Could not find definition with given term $term.");
        }

        $definition = new \Glossary\Definition\Definition($row);
        return $definition;
    }
}