# tummy

A fielded flat file parser

## Usage

```php
$formats = (new Tummy\Config\Factory())->create([
    [
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
    [
        'ident' => new Tummy\Record\Ident\Match('PWD'),
        'recordClass' => \stdClass::class,
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
    echo '(', get_class($record), ') ', $record->type, ' by ', $record->username, PHP_EOL;
}
```
