<?php

namespace Manzadey\SbuilderXmlSoap;

use Manzadey\SbuilderXmlSoap\Extensions\Attributeable;
use Manzadey\SbuilderXmlSoap\Extensions\DeleteAttributeable;
use Manzadey\SbuilderXmlSoap\Extensions\Fieldable;

class Element
{
    use Attributeable;
    use Fieldable;
    use DeleteAttributeable;

    const NAME = 'sb_elem';

    /**
     * @var \DOMDocument
     */
    private $xml;

    /**
     * @var string[]
     */
    private $attributes = [
        'e_id'     => '',
        'e_ext_id' => '',
    ];

    /**
     * @var \Manzadey\SbuilderXmlSoap\Field[]
     */
    private $fields = [];

    /**
     * @var \DOMElement[]
     */
    private $links = [];

    /**
     * @var \DOMElement|false
     */
    private $DOMElement;

    /**
     * @var string
     */
    private $prefix = 'p';

    /**
     * Element constructor.
     *
     * @param \DOMDocument $xml
     * @param string[]     $attributes
     */
    public function __construct(\DOMDocument $xml, $attributes = [])
    {
        $this->xml        = $xml;
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->DOMElement = $this->xml->createElement(self::NAME);
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->attributes['e_id'] = $id;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setExtId($id)
    {
        $this->attributes['e_ext_id'] = $id;

        return $this;
    }

    /**
     * @param int[]|int $link
     */
    public function addLink($link)
    {
        $linkCall = new Link;

        if(is_array($link)) {
            foreach ($link as $item) {
                if(is_int($item)) {
                    $this->links[] = $linkCall($this->xml, $item);
                }
            }
        } else if(is_int($link)) {
            $this->links[] = $linkCall($this->xml, $link);
        }

        return $this;
    }

    public function setUpLinks()
    {
        foreach ($this->links as $link) {
            $this->DOMElement->appendChild($link);
        }
    }

    /**
     * @return \DOMElement|false
     */
    public function getDOM()
    {
        $this->setUpFields();
        $this->setUpAttributes();
        $this->setUpLinks();

        return $this->DOMElement;
    }

    /**
     * @param $prefix
     *
     * @return $this
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;

        return $this;
    }
}
