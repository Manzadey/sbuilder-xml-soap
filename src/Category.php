<?php

namespace Manzadey\SbuilderXmlSoap;

use Closure;
use DOMDocument;
use Manzadey\SbuilderXmlSoap\Extensions\Attributeable;
use Manzadey\SbuilderXmlSoap\Extensions\Categoryable;
use Manzadey\SbuilderXmlSoap\Extensions\DeleteAttributeable;
use Manzadey\SbuilderXmlSoap\Extensions\Fieldable;

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
    private $attributes;

    /**
     * @var \DOMElement|false
     */
    private $DOMElement;

    /**
     * @var \Manzadey\SbuilderXmlSoap\Field[]
     */
    private $fields = [];

    /**
     * @var \Manzadey\SbuilderXmlSoap\Element[]
     */
    private $elements = [];

    /**
     * @var \Manzadey\SbuilderXmlSoap\Category[]
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
    public function __construct(DOMDocument $xml, $attributes = ['c_id' => '', 'c_ext_id' => '', 'c_p_id' => ''])
    {
        $this->xml        = $xml;
        $this->attributes = $attributes;
        $this->DOMElement = $this->xml->createElement(self::NAME);
    }

    /**
     * @param \Manzadey\SbuilderXmlSoap\Element $element
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
     * @return \Manzadey\SbuilderXmlSoap\Element
     */
    public function newElement($attributes = ['e_id' => '', 'e_ext_id' => ''])
    {
        return new Element($this->xml, $attributes);
    }

    /**
     * @param \Closure $closure
     *
     * @return $this
     */
    public function addNewElement(Closure $closure)
    {
        return $this->addElement($closure(new Element($this->xml)));
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
        $this->setUpCategories();
        $this->setUpElements();

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
