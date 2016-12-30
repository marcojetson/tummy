<?php

namespace Tummy\Record\Ident;

use Tummy\Record\Ident; 

class Match implements Ident
{
    /** @var string */
    private $string;

    /** @var int $options */
    private $start = 0;

    /**
     * @param string $string
     * @param int $start
     */
    public function __construct($string, $start = 0)
    {
        $this->string = $string;
        $this->start = $start;
    }

    /**
     * @inheritdoc
     */
    public function test($line)
    {
        return $this->string === substr($line, $this->start, strlen($this->string));
    }
}
