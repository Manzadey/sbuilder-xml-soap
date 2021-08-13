<?php

namespace Manzadey\SbuilderXmlSoap\v1;

use Manzadey\SbuilderXmlSoap\v1\Extensions\Attributeable;

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
     * @param string|int $name
     *
     * @return $this
     */
    public function name($name)
    {
        if(is_int($name)) {
            $name = "user_f_$name";
        }

        $this->attributes['name'] = $name;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function userF($id)
    {
        return $this->name((int) $id);
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
