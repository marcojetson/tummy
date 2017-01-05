<?php

namespace Tummy\Record;

interface Mapper
{
    /**
     * @param object $record
     * @param string $reference
     * @return $value
     */
    public function get($record, $reference);

    /**
     * @param object $record
     * @param string $reference
     * @param mixed $value
     */
    public function set($record, $reference, $value);
}
