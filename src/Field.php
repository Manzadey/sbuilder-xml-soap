<?php

namespace Manzadey\SbuilderXmlSoap;

use Manzadey\SbuilderXmlSoap\Extensions\Attributeable;

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

    /**
     * Field constructor.
     *
     * @param \DOMDocument $xml
     * @param              $value
     * @param array        $attributes
     */
    public function __construct(\DOMDocument $xml, $value, $attributes = [])
    {
        $this->DOMElement = $xml->createElement('sb_field', $value);
        $this->attributes = $attributes;
    }

    /**
     * @return $this
     */
    public function isExtId()
    {
        $this->attributes['ext_id'] = 'true';

        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function name($name)
    {
        $this->attributes['name'] = $name;

        return $this;
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
