<?php

namespace Tummy\Config;

use Tummy\Record;

class Format
{
    /** @var Record\Ident */
    private $ident;

    /** @var Record\Mapper */
    private $recordMapper;

    /** @var string */
    private $recordClass;

    /** @var Element[] */
    private $elements;

    /**
     * @return Record\Ident
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * @param Record\Ident $ident
     */
    public function setIdent(Record\Ident $ident)
    {
        $this->ident = $ident;
    }

    /**
     * @return Record\Mapper
     */
    public function getRecordMapper()
    {
        return $this->recordMapper;
    }

    /**
     * @param Record\Mapper $recordMapper
     */
    public function setRecordMapper(Record\Mapper $recordMapper)
    {
        $this->recordMapper = $recordMapper;
    }

    /**
     * @return string
     */
    public function getRecordClass()
    {
        return $this->recordClass;
    }

    /**
     * @param string $recordClass
     */
    public function setRecordClass($recordClass)
    {
        $this->recordClass = $recordClass;
    }

    /**
     * @return Element[]
     */
    public function getElements()
    {
        return $this->elements;
    }

    /**
     * @param Element[] $elements
     */
    public function setElements(array $elements)
    {
        $this->elements = $elements;
    }
}
