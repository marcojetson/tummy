# tummy

A fielded flat file parser

[![Build Status](https://travis-ci.org/marcojetson/tummy.svg?branch=master)](https://travis-ci.org/marcojetson/tummy)
[![Code Climate](https://codeclimate.com/github/marcojetson/tummy/badges/gpa.svg)](https://codeclimate.com/github/marcojetson/tummy)
[![Test Coverage](https://codeclimate.com/github/marcojetson/tummy/badges/coverage.svg)](https://codeclimate.com/github/marcojetson/tummy/coverage)

## Usage

### Configuration

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
                'length' => 1, // elements w/o reference will be ignored
            ],
            [
                'length' => 16,
                'reference' => 'username',
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
        'recordClass' => PwdRecord::class, // will use \stdClass if not specified
        'elements' => [
            [
                'length' => 3,
                'reference' => 'type',
            ],
            [
                'length' => 1,
            ],
            [
                'length' => 16,
                'reference' => 'username',
            ],
            [
                'length' => 16,
                'reference' => 'password',
            ],
        ],
    ],
]);
```

### Parse

```php
$parser = new Tummy\Parser($formats);

$records = $parser->parse([
    'NEW marcojetson     31121985',
    'PWD marcojetson     peterete        ',
]);

var_dump($records);

// array(2) {
//   [0]=>
//   object(stdClass)#18 (3) {
//     ["type"]=>
//     string(3) "NEW"
//     ["username"]=>
//     string(11) "marcojetson"
//     ["birthday"]=>
//     object(DateTime)#19 (3) {
//       ["date"]=>
//       string(26) "1985-12-31 23:20:54.000000"
//       ["timezone_type"]=>
//       int(3)
//       ["timezone"]=>
//       string(13) "Europe/Berlin"
//     }
//   }
//   [1]=>
//   object(PwdRecord)#20 (3) {
//     ["type"]=>
//     string(3) "PWD"
//     ["username"]=>
//     string(11) "marcojetson"
//     ["password"]=>
//     string(8) "peterete"
//   }
// }
```

### Compose

```php
$record = new \stdClass();
$record->type = 'NEW';
$record->username = 'marcojetson';
$record->birthday = new \DateTime('1985-12-31');

$composer = new Tummy\Composer($formats['format1']);
echo $composer->compose([$record])[0];

// "NEW marcojetson     31121985"
```
