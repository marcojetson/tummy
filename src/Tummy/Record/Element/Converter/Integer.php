<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class Integer implements Converter
{
    /**
     * @inheritdoc
     */
    public function serialize($value)
    {
        return (string)$value;
    }

    /**
     * @inheritdoc
     */
    public function deserialize($value)
    {
        return (int)$value;
    }
}
