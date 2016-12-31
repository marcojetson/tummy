<?php

namespace Tummy\Config;

class Factory
{
    /**
     * @param array $definition
     * @return Format[]
     */
    public function create(array $definitions)
    {
        $formats = [];

        foreach ($definitions as $definition) {
            $format = new Format();

            $format->setRecordClass(isset($definition['recordClass']) ? $definition['recordClass'] : \stdClass::class);

            if (isset($definition['ident'])) {
                $format->setIdent($definition['ident']);
            }

            foreach ($definition['elements'] as $options) {
                $element = new Element();
                
                $element->setLength($options['length']);
                $element->setPaddingChar(isset($options['paddingChar']) ? $options['paddingChar'] : ' ');

                if (isset($options['reference'])) {
                    $element->setReference($options['reference']);
                }

                if (isset($options['converter'])) {
                    $element->setConverter($options['converter']);
                }

                $format->addElement($element);
            }

            $formats[] = $format;
        }

        return $formats;
    }
}
