<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class PropertyTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mapper = new Property();
        $this->assertInstanceOf(Mapper::class, $mapper);
    }

    public function testGet()
    {
        $mapper = new Property();
        $record = new \stdClass();

        $reference = 'age';
        $value = 31;

        $record->$reference = $value;

        $this->assertEquals($value, $mapper->get($record, $reference));
    }

    public function testSet()
    {
        $mapper = new Property();
        $record = new \stdClass();

        $reference = 'age';
        $value = 31;

        $mapper->set($record, $reference, $value);
        $this->assertEquals($value, $record->$reference);
    }
}
