<?php

class ViewTest extends PHPUnit_Framework_TestCase
{
    public function testUrlExternalUnchanged()
    {
        $view = new \Glossary\View();
        $this->assertEquals($view->url('http://www.example.org'), 'http://www.example.org');
    }

    public function testUrlExternalUnchangedShort()
    {
        $view = new \Glossary\View();
        $this->assertEquals($view->url('//cdn.example.org'), '//cdn.example.org');
    }
}