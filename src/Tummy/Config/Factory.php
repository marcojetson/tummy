<?php

namespace Tummy\Config;

use Tummy\Record\Mapper\Property;

class Factory
{
    /**
     * @param array $definitions
     * @return Format[]
     */
    public function create(array $definitions)
    {
        $formats = [];

        foreach ($definitions as $id => $definition) {
            $format = new Format();

            if (isset($definition['ident'])) {
                $format->setIdent($definition['ident']);
            }

            $format->setRecordMapper(isset($definition['recordMapper']) ? $definition['recordMapper'] : new Property());
            $format->setRecordClass(isset($definition['recordClass']) ? $definition['recordClass'] : \stdClass::class);

            $elements = [];

            foreach ($definition['elements'] as $options) {
                $element = new Element();
                
                $element->setLength($options['length']);
                $element->setPaddingChar(isset($options['paddingChar']) ? $options['paddingChar'] : ' ');
                $element->setPaddingDirection(isset($options['paddingDirection']) ? $options['paddingDirection'] : \STR_PAD_RIGHT);

                if (isset($options['reference'])) {
                    $element->setReference($options['reference']);
                }

                if (isset($options['converter'])) {
                    $element->setConverter($options['converter']);
                }

                $elements[] = $element;
            }

            $format->setElements($elements);

            $formats[$id] = $format;
        }

        return $formats;
    }
}
