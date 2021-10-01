<?php

use Fishingboy\MaDump\MaDump;
use PHPUnit\Framework\TestCase;

class DumpTest extends TestCase
{
    public function test_dump_array()
    {
        $dump = new MaDump();
        $response = $dump->dump([1]);
        $this->assertTrue($response);
    }

    public function test_dump_object()
    {
        $dump = new MaDump();
        $object = (object) ["a" => 1];
        $response = $dump->dump($object);
        $this->assertTrue($response);
    }

    public function test_dump_object2()
    {
        $dump = new MaDump();
        $object = new Car();
        $response = $dump->dump($object);
        $this->assertTrue($response);
    }
}

class Car {
    public $length = 1;
}