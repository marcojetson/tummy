<?php

namespace Tummy;

class Record
{
    /** @var array */
    private $properties;

    /**
     * @inheritdoc
     */
    public function __get($property)
    {
        return $this->properties[$property];
    }

    /**
     * @inheritdoc
     */
    public function __set($property, $value)
    {
        $this->properties[$property] = $value;
    }
}
