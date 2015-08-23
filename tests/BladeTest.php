<?php

use Illuminate\Container\Container;
use Jenssegers\Blade\Blade;

class BladeTest extends PHPUnit_Framework_TestCase {

    public function testBasic()
    {
        $blade = new Blade('tests/views', 'tests/cache');

        $output = $blade->make('basic')->render();
        $this->assertEquals('hello world', trim($output));
    }

    public function testVariables()
    {
        $blade = new Blade('tests/views', 'tests/cache');

        $output = $blade->make('variables', ['name' => 'John Doe'])->render();
        $this->assertEquals('hello John Doe', trim($output));
    }

    public function testNonBlade()
    {
        $blade = new Blade('tests/views', 'tests/cache');

        $output = $blade->make('plain')->render();
        $this->assertEquals('this is plain php', trim($output));
    }

}
