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
     * @dataProvider convertFailProvider
     * @expectedException \RuntimeException
     */
    public function testConvertFail($format, $string)
    {
        $converter = new DateTime($format);
        $converter->convert($string);
    }

    public function convertFailProvider()
    {
        return [
            ['Y-m-d', '20161231'],
            ['Ymd', '2016-12-31'],
            ['marco', 'tummy'],
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert($format, $string)
    {
        $converter = new DateTime($format);
        $value = $converter->convert($string);
        $this->assertEquals($string, $value->format($format));
    }

    public function convertProvider()
    {
        return [
            ['Y-m-d', '2016-12-31'],
            ['Ymd', '20161231'],
        ];
    }
}
