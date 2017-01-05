<?php

namespace Tummy\Record\Element\Converter\Decorator;

use Tummy\Record\Element\Converter;

class FailSafe implements Converter
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
        try {
            return $this->converter->serialize($value);
        } catch (\Exception $e) {
            return '';
        }
    }

    /**
     * @inheritdoc
     */
    public function deserialize($value)
    {
        try {
            return $this->converter->deserialize($value);
        } catch (\Exception $e) {
            return null;
        }
    }
}