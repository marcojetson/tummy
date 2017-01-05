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

    public function testGet()
    {
        $mapper = new Setter();
        $record = $this->getMock(\stdClass::class, ['getAge']);

        $record->expects($this->once())->method('getAge');

        $mapper->get($record, 'age');
    }

    public function testSet()
    {
        $mapper = new Setter();
        $record = $this->getMock(\stdClass::class, ['setAge']);

        $value = 31;

        $record->expects($this->once())->method('setAge')->with($value);

        $mapper->set($record, 'age', $value);
    }
}
