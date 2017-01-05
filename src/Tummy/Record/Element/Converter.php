<?php

namespace Tummy\Record\Element;

interface Converter
{
    /**
     * @param mixed $value
     * @return string
     * @throws \Tummy\Exception\ConverterException
     */
    public function serialize($value);

    /**
     * @param string $value
     * @return mixed
     * @throws \Tummy\Exception\ConverterException
     */
    public function deserialize($value);
}
