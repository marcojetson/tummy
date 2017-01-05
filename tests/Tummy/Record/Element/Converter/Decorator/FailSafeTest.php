<?php

namespace Tummy\Record\Element\Converter\Decorator;

use Tummy\Record\Element\Converter;

class FailSafeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $converter = $this->getMock(Converter::class);
        $decorator = new FailSafe($converter);
        $this->assertInstanceOf(Converter::class, $decorator);
    }

    public function testSerializeError()
    {
        $value = 'marco';
        $expectedValue = '';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('serialize')->with($value)->willThrowException(new \Exception());

        $decorator = new FailSafe($converter);
        $convertedValue = $decorator->serialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testSerialize()
    {
        $value = 'marco';
        $expectedValue = 'MARCO';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('serialize')->with($value)->willReturn($expectedValue);

        $decorator = new FailSafe($converter);
        $convertedValue = $decorator->serialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testDeserializeError()
    {
        $value = 'marco';
        $expectedValue = null;

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('deserialize')->with($value)->willThrowException(new \Exception());

        $decorator = new FailSafe($converter);
        $convertedValue = $decorator->deserialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }

    public function testDeserialize()
    {
        $value = 'marco';
        $expectedValue = 'MARCO';

        $converter = $this->getMock(Converter::class);
        $converter->expects($this->once())->method('deserialize')->with($value)->willReturn($expectedValue);

        $decorator = new FailSafe($converter);
        $convertedValue = $decorator->deserialize($value);

        $this->assertEquals($expectedValue, $convertedValue);
    }
}