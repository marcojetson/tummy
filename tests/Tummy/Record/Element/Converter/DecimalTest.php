<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class DecimalTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $converter = new Decimal();
        $this->assertInstanceOf(Converter::class, $converter);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateIncompatibleOptions()
    {
        new Decimal(['places' => 3, 'separator' => '.']);
    }

    /**
     * @param string $value
     * @param int $expected
     * @dataProvider serializeProvider
     */
    public function testSerialize($value, $expected)
    {
        $converter = new Decimal();
        $convertedValue = $converter->serialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function serializeProvider()
    {
        return [
            [1.0, '1'],
            [1.1, '1.1'],
        ];
    }

    /**
     * @param string $value
     * @param float $expected
     * @dataProvider deserializeProvider
     */
    public function testDeserialize($value, $expected)
    {
        $converter = new Decimal();
        $convertedValue = $converter->deserialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function deserializeProvider()
    {
        return [
            ['1.0', 1.0],
            ['1.1', 1.1],
            ['1.2.3', 1.2],
            ['1.2asd', 1.2],
            ['asd1.2', 0.0],
        ];
    }

    /**
     * @param int $places
     * @param string $value
     * @param float $expected
     * @dataProvider deserializeWithPlacesProvider
     */
    public function testDeserializeWithPlaces($places, $value, $expected)
    {
        $converter = new Decimal(['places' => $places]);
        $convertedValue = $converter->deserialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function deserializeWithPlacesProvider()
    {
        return [
            [3, '1234', 1.234],
            [2, '1234', 12.34],
            [3, '123.4', 12.3],
            [3, '12asd', 12.0],
            [3, 'asd12', 0.0],
            [8, '1234', 0.1234],
        ];
    }

    /**
     * @param string $separator
     * @param string $value
     * @param float $expected
     * @dataProvider deserializeWithSeparatorProvider
     */
    public function testDeserializeWithSeparator($separator, $value, $expected)
    {
        $converter = new Decimal(['separator' => $separator]);
        $convertedValue = $converter->deserialize($value);
        $this->assertSame($expected, $convertedValue);
    }

    public function deserializeWithSeparatorProvider()
    {
        return [
            ['.', '1.234', 1.234],
            [',', '12,34', 12.34],
            ['.', '12.3.4', 12.3],
            ['!', '12!3', 12.3],
            ['x', '1234', 1234.0],
        ];
    }
}
