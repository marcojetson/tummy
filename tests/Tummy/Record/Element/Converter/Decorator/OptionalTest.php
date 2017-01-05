<?php

namespace Tummy\Record\Element\Converter\Decorator;

use Tummy\Record\Element\Converter;

class OptionalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $converter = $this->getMock(Converter::class);
        $decorator = new Optional($converter);
        $this->assertInstanceOf(Converter::class, $decorator);
    }

    public function testSerializeEmpty()
    {
        $value = $expectedValue = null;

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->never())->method('serialize');

        $decorator = new Optional($converter);
        $convertedValue = $decorator->serialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testSerialize()
    {
        $value = 'marco';
        $expectedValue = 'MARCO';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('serialize')->with($value)->willReturn($expectedValue);

        $decorator = new Optional($converter);
        $convertedValue = $decorator->serialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testDeserializeEmpty()
    {
        $value = $expectedValue = '';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->never())->method('deserialize');

        $decorator = new Optional($converter);
        $convertedValue = $decorator->deserialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testDeserialize()
    {
        $value = 'marco';
        $expectedValue = 'MARCO';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('deserialize')->with($value)->willReturn($expectedValue);

        $decorator = new Optional($converter);
        $convertedValue = $decorator->deserialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }
}