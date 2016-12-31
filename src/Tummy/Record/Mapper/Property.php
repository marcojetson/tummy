<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class Property implements Mapper
{
    /**
     * @inheritdoc
     */
    public function map($record, $reference, $value)
    {
        $record->$reference = $value;
    }
}
