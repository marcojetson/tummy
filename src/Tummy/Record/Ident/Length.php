<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident; 

class Length implements Ident
{
    /** @var array */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options)
    {
        if (!isset($options['length']) && !isset($options['min']) && !isset($options['max'])) {
            throw new \InvalidArgumentException('You need to set at least one of length, min or max options');
        }

        if (isset($options['length']) && (isset($options['min']) || isset($options['max']))) {
            throw new \InvalidArgumentException('You cannot set min/max options and length at the same time');
        }

        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function test($line)
    {
        $length = strlen($line);

        if (isset($this->options['length']) && $this->options['length'] != $length) {
            return false;
        }

        if (isset($this->options['min']) && $this->options['min'] > $length) {
            return false;
        }

        if (isset($this->options['max']) && $this->options['max'] < $length) {
            return false;
        }

        return true;
    }
}
