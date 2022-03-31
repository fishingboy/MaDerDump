<?php

use Fishingboy\MaDump\MaDump;
use Fishingboy\MaDump\MaDumpSchema;
use Fishingboy\MaDump\MaDumpOutput;
use PHPUnit\Framework\TestCase;

class DumpOutputTest extends TestCase
{
    public function test_dump_value_int()
    {
        $data_schema = ["type" => "value", "value" => 1];
        $response = MaDumpOutput::text($data_schema);
        $this->assertEquals("<pre>1 (integer)</pre>", $response);
    }

    public function test_dump_value_bool()
    {
        $data_schema = ["type" => "value", "value" => true];
        $response = MaDumpOutput::text($data_schema);
        $this->assertEquals("<pre>true (boolean)</pre>", $response);
    }

    public function test_dump_array()
    {
        $data_schema = [
            "type" => "array",
            "attributes" => [
                ["type" => "value", "value" => 1]
            ]
        ];
        $response = MaDumpOutput::text($data_schema);
        $this->assertEquals("<pre>Array(1) => \n    [0] => 1 (integer)</pre>", $response);
    }

    public function test_dump_object()
    {
        $data_schema = [
            "type" => "object",
            "class" => "stdClass",
            "attributes" => [
                "a" => ["type" => "value", "value" => 1]
            ]
        ];
        $response = MaDumpOutput::text($data_schema);
        $this->assertEquals("<pre>stdClass
    [a] => 1 (integer)</pre>", $response);
    }

    public function test_dump_object2()
    {
        $object = new Car();
        $response = MaDump::dump($object, true);
        echo $response;
        $this->assertEquals("<pre>Car
    ->__construct()
    ->getLength() : 1 (integer)
    ->getLight() : Light
    ->getLight2(bool \$flag, int \$on)
    [attrs] (Key Value Array)
    [items] (Array)
    [length] => 1 (integer)
    [light] (Light)</pre>", $response);
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

    public function getLight(): Light
    {
        return $this->light;
    }

    public function getLight2(bool $flag, int $on): Light
    {
        return $this->light;
    }

    private function getPrivateName(): string
    {
        return "MaDerDump";
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