<?php

namespace Tummy;

class Parser
{
    /** @param Config\Format[] */
    protected $formats;

    /**
     * @param Config\Format[] $formats
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
        return array_map([$this, 'parseLine'], $lines);
    }

    /**
     * @param string $line
     * @return object
     */
    public function parseLine($line)
    {
        $format = $this->ident($line);

        $recordMapper = $format->getRecordMapper();
        $record = $this->createRecord($format);

        $position = 0;
        foreach ($format->getElements() as $element) {
            $value = $this->extractValue($line, $element, $position);

            $reference = $element->getReference();
            if ($reference !== null) {
                $recordMapper->set($record, $reference, $value);
            }
        }

        return $record;
    }

    /**
     * @param string $line
     * @return Config\Format
     * @throws Exception\IdentException
     */
    protected function ident($line)
    {
        foreach ($this->formats as $format) {
            $ident = $format->getIdent();
            if ($ident === null || $ident->test($line)) {
                return $format;
            }
        }

        throw new Exception\IdentException(sprintf('Unable to identify record format for "%s"', $line));
    }

    /**
     * @param Config\Format $format
     * @return object
     */
    protected function createRecord(Config\Format $format)
    {
        $recordClass = $format->getRecordClass();
        return new $recordClass();
    }

    /**
     * @param string $line
     * @param Config\Element $element
     * @param int &$position
     * @return mixed
     */
    protected function extractValue($line, Config\Element $element, &$position = 0)
    {
        $length = $element->getLength();

        $value = substr($line, $position, $length);
        $value = trim($value, $element->getPaddingChar());

        $position += $length;

        $converter = $element->getConverter();
        if ($converter !== null) {
            $value = $converter->deserialize($value);
        }

        return $value;
    }
}
