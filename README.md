# tummy

A fielded flat file parser

[![Build Status](https://travis-ci.org/marcojetson/tummy.svg?branch=master)](https://travis-ci.org/marcojetson/tummy)
[![Code Climate](https://codeclimate.com/github/marcojetson/tummy/badges/gpa.svg)](https://codeclimate.com/github/marcojetson/tummy)
[![Test Coverage](https://codeclimate.com/github/marcojetson/tummy/badges/coverage.svg)](https://codeclimate.com/github/marcojetson/tummy/coverage)

## Usage

```php
$formats = (new Tummy\Config\Factory())->create([
    'format1' => [
        'ident' => new Tummy\Record\Ident\Match('NEW'), // used for supporting multiple record formats in a single file
        'elements' => [
            [
                'length' => 3,
                'reference' => 'type',
            ],
            [
                'length' => 16,
                'reference' => 'username',
            ],
            [
                'length' => 3, // elements w/o reference will be ignored
            ],
            [
                'length' => 8,
                'reference' => 'birthday',
                'converter' => new Tummy\Record\Element\Converter\DateTime('dmY'),
            ],
        ],
    ],
    'format2' => [
        'ident' => new Tummy\Record\Ident\Match('PWD'),
        'recordClass' => PwdRecord::class, // will use \stdClass by default
        'elements' => [
            [
                'length' => 3,
                'reference' => 'type',
            ],
            [
                'length' => 16,
                'reference' => 'username',
            ],
            [
                'length' => 16,
                'reference' => 'oldPassword',
            ],
            [
                'length' => 16,
                'reference' => 'newPassword',
            ],
        ],
    ],
]);

$parser = new Tummy\Parser($formats);

$records = $parser->parse([
    'NEWmarcojetson     31 29081985',
    'PWDmarcojetson     peterete        poporombo       ',
]);

foreach ($records as $record) {
    var_dump($record);
}

$composer = new Tummy\Composer($formats['format1']);
echo $composer->compose([$records[0]])[0], PHP_EOL;
```
