<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class SetterTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $mapper = new Setter();
        $this->assertInstanceOf(Mapper::class, $mapper);
    }

    public function testMap()
    {
        $mapper = new Setter();
        $record = $this->getMock(\stdClass::class, ['setAge']);

        $value = 31;

        $record->expects($this->once())->method('setAge')->with($value);

        $mapper->map($record, 'age', $value);
    }
}
