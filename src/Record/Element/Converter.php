<?php

namespace Tummy\Record\Element;

interface Converter
{
    /**
     * @param string $value
     * @return mixed
     */
    public function convert($value);
}
