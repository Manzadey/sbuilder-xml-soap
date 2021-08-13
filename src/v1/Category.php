<?php

namespace Manzadey\SbuilderXmlSoap\v1;

use Closure;
use DOMDocument;
use Manzadey\SbuilderXmlSoap\v1\Extensions\Attributeable;
use Manzadey\SbuilderXmlSoap\v1\Extensions\Categoryable;
use Manzadey\SbuilderXmlSoap\v1\Extensions\DeleteAttributeable;
use Manzadey\SbuilderXmlSoap\v1\Extensions\Fieldable;

class Category
{
    use Attributeable;
    use Fieldable;
    use DeleteAttributeable;
    use Categoryable;

    const NAME = 'sb_cat';

    /**
     * @var \DOMDocument
     */
    private $xml;

    /**
     * @var string[]
     */
    private $attributes = [
        'c_id'     => '',
        'c_ext_id' => '',
        'c_p_id'   => '',
    ];

    /**
     * @var \DOMElement|false
     */
    private $DOMElement;

    /**
     * @var \Manzadey\SbuilderXmlSoap\v1\Field[]
     */
    private $fields = [];

    /**
     * @var \Manzadey\SbuilderXmlSoap\v1\Element[]
     */
    private $elements = [];

    /**
     * @var \Manzadey\SbuilderXmlSoap\v1\Category[]
     */
    private $categories = [];

    /**
     * @var string
     */
    private $prefix = 'cat';

    /**
     * Category constructor.
     *
     * @param \DOMDocument $xml
     * @param array        $attributes
     */
    public function __construct(DOMDocument $xml, $attributes = [])
    {
        $this->xml        = $xml;
        $this->attributes = array_merge($this->attributes, $attributes);
        $this->DOMElement = $this->xml->createElement(self::NAME);
    }

    /**
     * @param \Manzadey\SbuilderXmlSoap\v1\Element $element
     *
     * @return $this
     */
    public function addElement(Element $element)
    {
        $this->elements[] = $element;

        return $this;
    }

    /**
     * @param string[] $attributes
     *
     * @return \Manzadey\SbuilderXmlSoap\v1\Element
     */
    public function newElement($attributes = [])
    {
        return new Element($this->xml, $attributes);
    }

    /**
     * @param \Closure $closure
     * @param array    $attributes
     *
     * @return $this
     */
    public function addNewElement(Closure $closure, $attributes = [])
    {
        return $this->addElement($closure($this->newElement($attributes)));
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->attributes['c_id'] = $id;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setExtId($id)
    {
        $this->attributes['c_ext_id'] = $id;

        return $this;
    }

    /**
     * @param int $id
     *
     * @return $this
     */
    public function setParentId($id)
    {
        $this->attributes['c_p_id'] = $id;

        return $this;
    }

    private function setUpElements()
    {
        foreach ($this->elements as $element) {
            $this->DOMElement->appendChild($element->getDOM());
        }
    }

    /**
     * @return \DOMElement|false
     */
    public function getCategory()
    {
        $this->setUpAttributes();
        $this->setUpFields();
        $this->setUpElements();
        $this->setUpCategories();

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
