<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @param array $args
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
     * @param array $args
     * @param bool $value
     * @param string $expected
     * @dataProvider serializeProvider
     */
    public function testSerialize(array $args, $value, $expected)
    {
        $converter = new Boolean(...$args);
        $convertedValue = $converter->serialize($value);
        $this->assertEquals($expected, $convertedValue);
    }

    public function serializeProvider()
    {
        return [
            [[], true, '1'],
            [['Y', 'N'], false, 'N'],
            [['YES'], true, 'YES'],
            [['YES'], false, '0'],
        ];
    }

    /**
     * @param array $args
     * @param string $string
     * @dataProvider deserializeFailProvider
     * @expectedException \Tummy\Exception\ConverterException
     */
    public function testDeserializeFail(array $args, $string)
    {
        $converter = new Boolean(...$args);
        $converter->deserialize($string);
    }

    public function deserializeFailProvider()
    {
        return [
            [[], 'y'],
            [['Y', 'N'], 'M'],
            [['YES'], 'MAYBE'],
        ];
    }

    /**
     * @param array $args
     * @param string $value
     * @param bool $expected
     * @dataProvider deserializeProvider
     */
    public function testDeserialize(array $args, $value, $expected)
    {
        $converter = new Boolean(...$args);
        $convertedValue = $converter->deserialize($value);
        $this->assertEquals($expected, $convertedValue);
    }

    public function deserializeProvider()
    {
        return [
            [[], '1', true],
            [['Y', 'N'], 'N', false],
            [['YES'], 'YES', true],
            [['YES'], '0', false],
        ];
    }
}
