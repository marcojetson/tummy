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
    public function serialize($value)
    {
        if (!$value instanceof \DateTimeInterface) {
            throw new ConverterException();
        }

        return $value->format($this->format);
    }

    /**
     * @inheritdoc
     */
    public function deserialize($value)
    {
        $dateTime = \DateTime::createFromFormat($this->format, $value);

        if ($dateTime) {
            return $dateTime;
        }

        throw new ConverterException();
    }
}
