<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class Boolean implements Converter
{
    /** @var string */
    private $true;

    /** @var string */
    private $false;

    /**
     * @param string $true
     * @param string $false
     */
    public function __construct($true = '1', $false = '0')
    {
        $this->true = $true;
        $this->false = $false;
    }

    /**
     * @inheritdoc
     */
    public function convert($value)
    {
        if ($value === $this->true) {
            return true;
        }

        if ($value === $this->false) {
            return false;
        }

        throw new \RuntimeException(sprintf('Unable to convert "%s" to boolean', $value));
    }
}
