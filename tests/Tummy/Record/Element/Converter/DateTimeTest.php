<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $converter = new DateTime('Y-m-d');
        $this->assertInstanceOf(Converter::class, $converter);
    }

    /**
     * @expectedException \Tummy\Exception\ConverterException
     */
    public function testSerializeFail()
    {
        $converter = new DateTime('c');
        $converter->serialize('uh oh');
    }

    /**
     * @param string $format
     * @param \DateTimeInterface $value
     * @dataProvider serializeProvider
     */
    public function testSerialize($format, $value)
    {
        $converter = new DateTime($format);
        $convertedValue = $converter->serialize($value);
        $this->assertEquals($value->format($format), $convertedValue);
    }

    public function serializeProvider()
    {
        return [
            ['Y-m-d', new \DateTime()],
            ['Ymd', new \DateTime()],
        ];
    }

    /**
     * @param string $format
     * @param string $value
     * @dataProvider deserializeFailProvider
     * @expectedException \Tummy\Exception\ConverterException
     */
    public function testDeserializeFail($format, $value)
    {
        $converter = new DateTime($format);
        $converter->deserialize($value);
    }

    public function deserializeFailProvider()
    {
        return [
            ['Y-m-d', '20161231'],
            ['Ymd', '2016-12-31'],
            ['marco', 'tummy'],
        ];
    }

    /**
     * @param string $format
     * @param string $value
     * @dataProvider deserializeProvider
     */
    public function testDeserialize($format, $value)
    {
        $converter = new DateTime($format);
        $convertedValue = $converter->deserialize($value);
        $this->assertInstanceOf(\DateTimeInterface::class, $convertedValue);
        $this->assertEquals($value, $convertedValue->format($format));
    }

    public function deserializeProvider()
    {
        return [
            ['Y-m-d', '2016-12-31'],
            ['Ymd', '20161231'],
        ];
    }
}
