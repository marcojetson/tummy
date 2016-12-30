<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident; 

class Match implements Ident
{
    /** @var string */
    protected $string;

    /** @var array $options */
    protected $options = [
        'start' => 0,
    ];

    /**
     * @param string $string
     * @param array $options
     */
    public function __construct($string, array $options = [])
    {
        $this->string = $string;
        $this->options = array_merge($options, $this->options);
    }

    /**
     * @inheritdoc
     */
    public function test($line)
    {
        return $this->string === substr($line, $this->options['start'], strlen($this->string));
    }
}
