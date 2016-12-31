<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Exception\ConverterException;
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
        $dateTime = \DateTime::createFromFormat($this->format, $value);

        if ($dateTime) {
            return $dateTime;
        }

        throw new ConverterException(sprintf('Unable to convert "%s" to DateTime', $value));
    }
}
