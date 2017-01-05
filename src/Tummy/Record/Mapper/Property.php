<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class Property implements Mapper
{
    /**
     * @inheritdoc
     */
    public function get($record, $reference)
    {
        return $record->$reference;
    }

    /**
     * @inheritdoc
     */
    public function set($record, $reference, $value)
    {
        $record->$reference = $value;
    }
}
