<?php

namespace Tummy;

use Tummy\Config;

class ComposerTest extends \PHPUnit_Framework_TestCase
{
    public function testCompose()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 8,
                        'reference' => 'name',
                    ],
                    [
                        'length' => 2,
                        'reference' => 'age',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->name = 'Marco';
        $record->age = 31;

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('Marco   31', $lines[0]);
    }

    public function testComposeNoReference()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 8,
                    ],
                    [
                        'length' => 2,
                        'reference' => 'age',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->name = 'Marco';
        $record->age = 31;

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('        31', $lines[0]);
    }

    public function testComposeRecordMapper()
    {
        $recordMapper = $this->getMock(Record\Mapper::class);
        $recordMapper->expects($this->once())->method('get')->with($this->anything(), 'username')->willReturn('ABCD');

        $formats = (new Config\Factory())->create([
            [
                'recordMapper' => $recordMapper,
                'elements' => [
                    [
                        'length' => 4,
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'abcd';

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('    ABCD    ', $lines[0]);
    }

    public function testComposePaddingChar()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                        'reference' => 'type',
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'paddingChar' => '-',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'abcd';

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('NEW abcd----', $lines[0]);
    }

    public function testComposePaddingCharMultibyte()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                        'reference' => 'type',
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'paddingChar' => '-',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'abcdåéî';

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('NEW abcdåéî-', $lines[0]);
    }

    public function testComposeTrim()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                        'reference' => 'type',
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'marco_waiting_for_the_sun';

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('NEW marco_wa', $lines[0]);
    }

    public function testComposePaddingDirection()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                        'reference' => 'type',
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'paddingChar' => '-',
                        'paddingDirection' => \STR_PAD_LEFT,
                    ],
                    [
                        'length' => 4,
                        'reference' => 'age',
                        'paddingChar' => 'X',
                        'paddingDirection' => \STR_PAD_BOTH,
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'abcd';
        $record->age = 31;

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('NEW ----abcdX31X', $lines[0]);
    }

    public function testComposeConverter()
    {
        $converter = $this->getMock(Record\Element\Converter::class);
        $converter->expects($this->once())->method('serialize')->with('abcd')->willReturn('ABCD');

        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                        'reference' => 'type',
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'converter' => $converter,
                    ],
                ],
            ],
        ]);

        $record = new \stdClass();
        $record->type = 'NEW ';
        $record->username = 'abcd';

        $composer = new Composer($formats[0]);
        $lines = $composer->compose([$record]);

        $this->assertCount(1, $lines);
        $this->assertInternalType('string', $lines[0]);
        $this->assertEquals('NEW ABCD    ', $lines[0]);
    }
}
