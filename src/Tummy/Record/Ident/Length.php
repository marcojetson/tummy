<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident; 

class Length implements Ident
{
    /** @var array */
    protected $options = [
        'length' => null,
        'min' => null,
        'max' => null,
    ];

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($options, $this->options);
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
