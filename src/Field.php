<?php

namespace Manzadey\SbuilderXmlSoap;

class Field
{
    use Attributeable;

    const NAME = 'sb_field';

    /**
     * @var string[]
     */
    private $attributes;

    /**
     * @var \DOMElement|false
     */
    private $DOMElement;

    public function __construct(\DOMDocument $xml, $value, $attributes = [])
    {
        $this->DOMElement = $xml->createElement('sb_field', $value);
        $this->attributes = $attributes;
    }

    /**
     * @return \DOMElement|false
     */
    public function getField()
    {
        $this->setUpAttributes();

        return $this->DOMElement;
    }
}
