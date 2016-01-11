<?php

class AbstractControllerTest extends PHPUnit_Framework_TestCase
{
    public function testActionUnknown()
    {
        try {
            $foo = new Foo(new \Glossary\View());
            $foo->action('bar', array());
        } catch (Exception $e) {
            $this->assertEquals($e->getMessage(), "Unknown action bar in controller Glossary\Controller\AbstractController");
            return;
        }
        $this->fail();
    }

    public function testActionKnown()
    {
        try {
            $foo = new Foo(new \Glossary\View());
            $foo->action('baz', array());
        } catch (Exception $e) {
            $this->fail();
        }
    }
}

class Foo extends \Glossary\Controller\AbstractController {
    public function bazAction() {}
}