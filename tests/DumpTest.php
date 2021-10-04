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

    public function test_is_normal_array()
    {
        $dump = new MaDump();
        $response = $dump->isNormalArray([1,2,3]);
        $this->assertTrue($response);
    }

    public function test_is_normal_array2()
    {
        $dump = new MaDump();
        $response = $dump->isNormalArray([
            "a" => 1,
            "b" => 1,
            "c" => 1,
        ]);
        $this->assertFalse($response);
    }
}

class Car {
    public $length = 1;

    public $items = [1, 2, 3, 4];

    public $attrs = [
        "name" => "innova",
        "age" => 20,
    ];

    public $light;

    public function __construct()
    {
        $this->light = new Light();
    }

    public function getLength(): int
    {
        return $this->length;
    }
}

class Light {
    public $power = true;

    public function TurnOn()
    {
        $this->power = true;
    }

    public function TurnOff()
    {
        $this->power = false;
    }
}