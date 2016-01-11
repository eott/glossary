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

    public function testUrlLineNoise()
    {
        $view = new \Glossary\View();
        $this->assertEquals($view->url('#t348hf23+23ß+fi2<1^211´4ß234#+-we,f+'), '/glossary/#t348hf23+23ß+fi2<1^211´4ß234#+-we,f+');
    }

    public function testUrlInternalWithSlash()
    {
        $view = new \Glossary\View();
        $this->assertEquals($view->url('/definition/show/foobar'), '/glossary/definition/show/foobar');
    }

    public function testUrlInternalWithoutSlash()
    {
        $view = new \Glossary\View();
        $this->assertEquals($view->url('definition/show/foobar'), '/glossary/definition/show/foobar');
    }
}