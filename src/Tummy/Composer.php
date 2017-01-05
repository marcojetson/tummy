<?php

namespace Tummy;

class Composer
{
    /** @param Config\Format */
    protected $format;

    /**
     * @param Config\Format $format
     */
    public function __construct($format)
    {
        $this->format = $format;
    }

    /**
     * @param object[] $records
     * @return string[]
     */
    public function compose(array $records)
    {
        return array_map([$this, 'composeLine'], $records);
    }

    /**
     * @param object $record
     * @return string
     */
    public function composeLine($record)
    {
        $recordMapper = $this->format->getRecordMapper();
        $line = '';

        foreach ($this->format->getElements() as $element) {
            $reference = $element->getReference();
            if ($reference === null) {
                continue;
            }

            $value = $recordMapper->get($record, $reference);

            $converter = $element->getConverter();
            if ($converter !== null) {
                $value = $converter->serialize($value);
            }

            $line .= str_pad($value, $element->getLength(), $element->getPaddingChar());
        }

        return $line;
    }
}