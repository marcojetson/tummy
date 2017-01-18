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

    /** @var int */
    private $paddingDirection;

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
     * @return int
     */
    public function getPaddingDirection()
    {
        return $this->paddingDirection;
    }

    /**
     * @param int $paddingDirection
     */
    public function setPaddingDirection($paddingDirection)
    {
        $this->paddingDirection = $paddingDirection;
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
