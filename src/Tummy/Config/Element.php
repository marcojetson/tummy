<?php

namespace Tummy\Config;

use Tummy\Record\Element\Converter;

class Element
{
    /** @var int */
    private $length;

    /** @var string */
    private $reference;

    /** @var string */
    private $paddingChar;

    /** @var Converter */
    private $converter;

    /**
     * @return int
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     */
    public function setReference($reference)
    {
        $this->reference = $reference;
    }

    /**
     * @return string
     */
    public function getPaddingChar()
    {
        return $this->paddingChar;
    }

    /**
     * @param string $paddingChar
     */
    public function setPaddingChar($paddingChar)
    {
        $this->paddingChar = $paddingChar;
    }

    /**
     * @return Converter
     */
    public function getConverter()
    {
        return $this->converter;
    }

    /**
     * @param Converter $converter
     */
    public function setConverter(Converter $converter)
    {
        $this->converter = $converter;
    }
}
