<?php

namespace Tummy\Record\Element\Converter;

use Tummy\Record\Element\Converter;

class Decimal implements Converter
{
    /** @var array */
    private $options;

    /**
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (isset($options['places'], $options['separator'])) {
            throw new \InvalidArgumentException('You cannot set places and separator options at the same time');
        }

        $this->options = $options;
    }

    /**
     * @inheritdoc
     */
    public function serialize($value)
    {
        return (string)$value;
    }

    /**
     * @inheritdoc
     */
    public function deserialize($value)
    {
        if (isset($this->options['places'])) {
            $value = sprintf('%s.%s', substr($value, 0, strlen($value) - $this->options['places']), substr($value, -1 * $this->options['places']));
        }

        if (isset($this->options['separator'])) {
            $value = join('.', array_map('intval', explode($this->options['separator'], $value, 2)));
        }

        return (float)$value;
    }
}