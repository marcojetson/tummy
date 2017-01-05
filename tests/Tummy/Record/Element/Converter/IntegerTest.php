<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $converter = new Integer();
        $this->assertInstanceOf(Converter::class, $converter);
    }

    /**
     * @param string $value
     * @param int $expected
     * @dataProvider serializeProvider
     */
    public function testSerialize($value, $expected)
    {
        $converter = new Integer();
        $convertedValue = $converter->serialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function serializeProvider()
    {
        return [
            [0, '0'],
            [1, '1'],
            [12, '12'],
        ];
    }

    /**
     * @param string $value
     * @param int $expected
     * @dataProvider deserializeProvider
     */
    public function testDeserialize($value, $expected)
    {
        $converter = new Integer();
        $convertedValue = $converter->deserialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function deserializeProvider()
    {
        return [
            ['0', 0],
            ['1', 1],
            ['12', 12],
            ['12asd', 12],
            ['asd12', 0],
        ];
    }
}
