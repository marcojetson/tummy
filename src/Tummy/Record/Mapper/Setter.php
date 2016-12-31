<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class Setter implements Mapper
{
    /**
     * @inheritdoc
     */
    public function map($record, $reference, $value)
    {
        call_user_func([$record, 'set' . ucfirst($reference)], $value);
    }
}
