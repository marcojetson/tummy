<?php

namespace Tummy;

use Tummy\Config;

class ParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParse()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 8,
                        'reference' => 'name',
                        'required' => true,
                    ],
                    [
                        'length' => 2,
                        'reference' => 'age',
                    ],
                ],
            ],
        ]);

        $parser = new Parser($formats);
        $records = $parser->parse(['Marco   31']);

        $this->assertCount(1, $records);
        $this->assertInstanceOf(\stdClass::class, $records[0]);
        $this->assertEquals('Marco', $records[0]->name);
        $this->assertEquals('31', $records[0]->age);
    }

    public function testParseIdent()
    {
        $formats = (new Config\Factory())->create([
            [
                'ident' => new Record\Ident\Match('NEW '),
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
            [
                'ident' => new Record\Ident\Match('PWD '),
                'elements' => [
                    [
                        'length' => 4,
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                    ],
                    [
                        'length' => 16,
                        'reference' => 'password',
                    ],
                ],
            ],
        ]);

        $parser = new Parser($formats);
        $records = $parser->parse([
            'NEW marco-',
            'PWD marco-  ***',
        ]);

        $this->assertCount(2, $records);

        $this->assertInstanceOf(\stdClass::class, $records[0]);
        $this->assertInstanceOf(\stdClass::class, $records[1]);

        $this->assertEquals('marco-', $records[0]->username);
        $this->assertEquals('marco-', $records[1]->username);

        $this->assertEquals('***', $records[1]->password);
    }

    /**
     * @expectedException \Tummy\Exception\IdentException
     */
    public function testParseIdentFail()
    {
        $formats = (new Config\Factory())->create([
            [
                'ident' => new Record\Ident\Match('NEW '),
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

        $parser = new Parser($formats);
        $records = $parser->parse(['XXX marco-']);
    }

    public function testParseRecordMapper()
    {
        $recordMapper = $this->getMock(Record\Mapper::class);
        $recordMapper->expects($this->once())->method('set')->with($this->anything(), 'username', 'ABCD');

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

        $parser = new Parser($formats);
        $records = $parser->parse(['NEW ABCD']);

        $this->assertCount(1, $records);
    }

    public function testParseRecordClass()
    {
        $recordClass = get_class($this->getMock(\stdClass::class));

        $formats = (new Config\Factory())->create([
            [
                'recordClass' => $recordClass,
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

        $parser = new Parser($formats);
        $records = $parser->parse(['NEW marco-']);

        $this->assertCount(1, $records);
        $this->assertInstanceOf($recordClass, $records[0]);
    }

    public function testParsePaddingChar()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'paddingChar' => '-',
                    ],
                ],
            ],
        ]);

        $parser = new Parser($formats);
        $records = $parser->parse(['NEW ABCD----']);

        $this->assertCount(1, $records);
        $this->assertInstanceOf(\stdClass::class, $records[0]);
        $this->assertEquals('ABCD', $records[0]->username);
    }

    public function testParsePaddingDirection()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
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

        $parser = new Parser($formats);
        $records = $parser->parse([
            'NEW ----ABCDX31X',
            'NEW ABCD----31XX',
        ]);

        $this->assertCount(2, $records);
        
        $this->assertInstanceOf(\stdClass::class, $records[0]);
        $this->assertEquals('ABCD', $records[0]->username);
        $this->assertEquals('31', $records[0]->age);

        $this->assertInstanceOf(\stdClass::class, $records[1]);
        $this->assertEquals('ABCD----', $records[1]->username);
        $this->assertEquals('31', $records[1]->age);
    }

    /**
     * @expectedException \Tummy\Exception\RequiredException
     */
    public function testParseRequiredError()
    {
        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 8,
                        'reference' => 'name',
                        'required' => true,
                    ],
                    [
                        'length' => 2,
                        'reference' => 'age',
                    ],
                ],
            ],
        ]);

        $parser = new Parser($formats);
        $records = $parser->parse(['        31']);
    }

    public function testParseConverter()
    {
        $converter = $this->getMock(Record\Element\Converter::class);
        $converter->expects($this->once())->method('deserialize')->with('ABCD')->willReturn('abcd');

        $formats = (new Config\Factory())->create([
            [
                'elements' => [
                    [
                        'length' => 4,
                    ],
                    [
                        'length' => 8,
                        'reference' => 'username',
                        'converter' => $converter,
                    ],
                ],
            ],
        ]);

        $parser = new Parser($formats);
        $records = $parser->parse(['NEW ABCD']);

        $this->assertCount(1, $records);
        $this->assertInstanceOf(\stdClass::class, $records[0]);
        $this->assertEquals('abcd', $records[0]->username);
    }
}
