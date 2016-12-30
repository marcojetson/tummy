<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident;

class MatchTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $ident = new Match('marco');
        $this->assertInstanceOf(Ident::class, $ident);
    }

    public function testCreateWithOffset()
    {
        $ident = new Match('marco', 5);
        $this->assertInstanceOf(Ident::class, $ident);
    }

    /**
     * @dataProvider identFailProvider
     */
    public function testIdentFail(array $args, $string)
    {
        $ident = new Match(...$args);
        $this->assertFalse($ident->test($string));
    }

    public function identFailProvider()
    {
        return [
            [['amarco'], 'marco'],
            [['margo', 1], 'amarco'],
        ];
    }

    /**
     * @dataProvider identProvider
     */
    public function testIdent(array $args, $string)
    {
        $ident = new Match(...$args);
        $this->assertTrue($ident->test($string));
    }

    public function identProvider()
    {
        return [
            [['marco'], 'marcos'],
            [['marco', 1], 'amarco'],
        ];
    }
}
