<?php

//use ;
use Fishingboy\MaDump\MaDump;
use PHPUnit\Framework\TestCase;

class DumpTest extends TestCase
{
    public function test_dump()
    {
        $dump = new MaDump();
        $response = $dump->dump();
        $this->assertTrue($response);
    }
}