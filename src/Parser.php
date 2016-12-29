<?php

namespace Tummy;

class Parser
{
    /** @param Config\Format[] */
    protected $formats;

    /**
     * @param Format[] $formats
     */
    public function __construct(array $formats)
    {
        $this->formats = $formats;
    }

    /**
     * @param string[] $lines
     * @return array
     */
    public function parse(array $lines)
    {
        $records = [];

        foreach ($lines as $line) {
            $format = $this->ident($line);
            
            if (!$format) {
                continue;
            }

            $recordClass = $format->getRecordClass();
            $record = new $recordClass();

            $position = 0;

            foreach ($format->getElements() as $element) {
                $length = $element->getLength();
                $value = trim(substr($line, $position, $length), $element->getPaddingChar());

                $position += $length;

                $converter = $element->getConverter();
                if ($converter !== null) {
                    $value = $converter->convert($value);
                }

                $reference = $element->getReference();
                if ($reference !== null) {
                    $record->$reference = $value;
                }                
            }

            $records[] = $record;
        }

        return $records;
    }

    /**
     * @param string $line
     * @return Format|null
     */
    protected function ident($line)
    {
        foreach ($this->formats as $format) {
            $ident = $format->getIdent();
            if ($ident === null || $ident->test($line)) {
                return $format;
            }
        }
    }
}
