<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class DateTime implements Converter
{
    /** @var string */
    private $format;

    /**
     * @param string $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @inheritdoc
     */
    public function convert($value)
    {
        return \DateTime::createFromFormat($this->format, $value);
    }
}
