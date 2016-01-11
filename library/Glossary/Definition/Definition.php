<?php

namespace Glossary\Definition;

class Definition
{
    /**
     * @var int $_definitionId The ID
     */
    private $_definitionId;

    /**
     * @var string $_term The term
     */
    private $_term;

    /**
     * @var $_description The description
     */
    private $_description;

    /**
     * Constructs a new Definition with the given attributes. The following
     * attributes are supported:
     *
     *    definition_id: int, the ID of the definition,
     *    term:          string, the term of the definition,
     *    description:   string, the description
     *
     * @param array $attr The attributes as associate array
     * @throws Exception when no value was fiven for a required attribute
     */
    public function __construct($attr)
    {
        $get = function($key, $required) use ($attr) {
            if (array_key_exists($key, $attr)) {
                return $attr[$key];
            } elseif ($required) {
                throw new Exception("Required attribute $key of $definition was empty.");
            } else {
                return null;
            }
        };

        $this->_definitionId = (int)$get('definition_id', true);
        $this->_term         = $get('term', true);
        $this->_description  = $get('description', false);
    }

    public function getDefinitionId()
    {
        return $this->_definitionId;
    }

    public function setDefinitionId($id)
    {
        $this->_description = (int)$id;
        return $this;
    }

    public function getTerm()
    {
        return $this->_term;
    }

    public function setTerm($term)
    {
        $this->_term = $term;
        return $this;
    }

    public function getDescription()
    {
        return $this->_description;
    }

    public function setDescription($desc)
    {
        $this->_description = $desc;
        return $this;
    }
}