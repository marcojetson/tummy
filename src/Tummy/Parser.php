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
     * @throws Exception\RequiredException
     */
    protected function extractValue($line, Config\Element $element, &$position = 0)
    {
        $length = $element->getLength();
        
        $value = mb_substr($line, $position, $length);
        $value = $this->trim($value, $element);

        if ($element->isRequired() && $value === '') {
            throw new Exception\RequiredException(sprintf('Required element "%s" is empty', $element->getReference()));
        }

        $position += $length;

        $converter = $element->getConverter();
        if ($converter !== null) {
            $value = $converter->deserialize($value);
        }

        return $value;
    }

    /**
     * @param string $value
     * @param Config\Element $element
     * @return string
     */
    protected function trim($value, Config\Element $element)
    {
        $method = [
            \STR_PAD_LEFT => 'ltrim',
            \STR_PAD_RIGHT => 'rtrim',
            \STR_PAD_BOTH => 'trim',
        ][$element->getPaddingDirection()];

        return $method($value, $element->getPaddingChar());
    }
}
