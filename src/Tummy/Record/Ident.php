<?php

namespace Tummy\Record;

interface Ident
{
    /**
     * @param string $line
     * @return bool
     */
    public function test($line);
}
