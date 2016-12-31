<?php

namespace Tummy\Record\Element;

interface Converter
{
    /**
     * @param string $value
     * @return mixed
     * @throws \Tummy\Exception\ConverterException
     */
    public function convert($value);
}
