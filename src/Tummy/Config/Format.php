<?php

namespace Tummy\Config;

use Tummy\Record\Ident;

class Format
{
    /** @var Ident */
    private $ident;

    /** @var string */
    private $recordClass;

    /** @var Element[] */
    private $elements;

    /**
     * @return Ident
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * @param Ident $ident
     */
    public function setIdent(Ident $ident)
    {
        $this->ident = $ident;
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

    /**
     * @param Element $element
     */
    public function addElement(Element $element)
    {
        $this->elements[] = $element;
    }
}
