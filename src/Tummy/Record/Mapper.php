<?php

namespace Tummy\Record;

interface Mapper
{
    /**
     * @param object $record
     * @param string $reference
     * @param mixed $value
     */
    public function map($record, $reference, $value);
}
