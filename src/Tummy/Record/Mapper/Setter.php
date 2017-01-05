<?php

namespace Tummy\Record\Mapper;

use Tummy\Record\Mapper;

class Setter implements Mapper
{
    /**
     * @inheritdoc
     */
    public function get($record, $reference)
    {
        return call_user_func([$record, 'get' . ucfirst($reference)]);
    }

    /**
     * @inheritdoc
     */
    public function set($record, $reference, $value)
    {
        call_user_func([$record, 'set' . ucfirst($reference)], $value);
    }
}
