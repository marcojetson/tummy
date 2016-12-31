<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident;

class LengthTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateWithoutOptions()
    {
        $ident = new Length([]);
    }

    /**
     * @expectedException InvalidArgumentException
     */
    public function testCreateIncompatibleOptions()
    {
        $ident = new Length(['length' => 64, 'min' => 0]);
    }

    /**
     * @dataProvider createProvider
     */
    public function testCreate(array $options)
    {
        $ident = new Length($options);
        $this->assertInstanceOf(Ident::class, $ident);
    }

    public function createProvider()
    {
        return [
            [['length' => 64]],
            [['min' => 0]],
            [['max' => 128]],
            [['min' => 0, 'max' => 128]],
        ];
    }

    /**
     * @dataProvider identFailProvider
     */
    public function testIdentFail(array $options, $string)
    {
        $ident = new Length($options);
        $this->assertFalse($ident->test($string));
    }

    public function identFailProvider()
    {
        return [
            [['length' => 5], 'marcos'],
            [['min' => 2], 'x'],
            [['max' => 16], '0123456789abcdefg'],
            [['min' => 2, 'max' => 16], 'y'],
        ];
    }

    /**
     * @dataProvider identProvider
     */
    public function testIdent(array $options, $string)
    {
        $ident = new Length($options);
        $this->assertTrue($ident->test($string));
    }

    public function identProvider()
    {
        return [
            [['length' => 5], 'marco'],
            [['min' => 0], 'peterete'],
            [['max' => 128], 'poporombo'],
            [['min' => 0, 'max' => 128], 'tummy'],
        ];
    }
}
