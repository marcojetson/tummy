<?php

namespace Tummy\Record\Element\Converter\Decorator;

use Tummy\Record\Element\Converter;

class Optional implements Converter
{
    /** @var Converter */
    private $converter;

    /**
     * @param Converter $converter
     */
    public function __construct(Converter $converter)
    {
        $this->converter = $converter;
    }

    /**
     * @inheritdoc
     */
    public function serialize($value)
    {
        return $value === null ? $value : $this->converter->serialize($value);
    }

    /**
     * @inheritdoc
     */
    public function deserialize($value)
    {
        return $value === '' ? $value : $this->converter->deserialize($value);
    }
}