<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @dataProvider createProvider
     */
    public function testCreate(array $args)
    {
        $converter = new Boolean(...$args);
        $this->assertInstanceOf(Converter::class, $converter);
    }

    public function createProvider()
    {
        return [
            [[]],
            [['Y', 'N']],
            [['YES']],
        ];
    }

    /**
     * @dataProvider convertFailProvider
     * @expectedException Tummy\Exception\ConverterException
     */
    public function testConvertFail(array $args, $string)
    {
        $converter = new Boolean(...$args);
        $converter->convert($string);
    }

    public function convertFailProvider()
    {
        return [
            [[], 'y'],
            [['Y', 'N'], 'M'],
            [['YES'], 'MAYBE'],
        ];
    }

    /**
     * @dataProvider convertProvider
     */
    public function testConvert(array $args, $string, $expected)
    {
        $converter = new Boolean(...$args);
        $value = $converter->convert($string);
        $this->assertEquals($expected, $value);
    }

    public function convertProvider()
    {
        return [
            [[], '1', true],
            [['Y', 'N'], 'N', false],
            [['YES'], 'YES', true],
            [['YES'], '0', false],
        ];
    }
}
