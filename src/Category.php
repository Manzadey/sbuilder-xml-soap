<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap;

use Closure;
use DOMDocument;
use DOMElement;
use Manzadey\SbuilderXmlSoap\Exceptions\ElementsArrayException;
use Manzadey\SbuilderXmlSoap\Traits\HasAttribute;
use Manzadey\SbuilderXmlSoap\Traits\HasCategory;
use Manzadey\SbuilderXmlSoap\Traits\HasDump;
use Manzadey\SbuilderXmlSoap\Traits\HasField;
use Manzadey\SbuilderXmlSoap\Traits\HasIsDelete;
use Manzadey\SbuilderXmlSoap\Traits\HasTap;
use Manzadey\SbuilderXmlSoap\Traits\HasWhen;

final class Category
{
    use HasField;
    use HasAttribute;
    use HasCategory;
    use HasIsDelete;
    use HasWhen;
    use HasTap;
    use HasDump;

    /**
     * @var array<int, \Manzadey\SbuilderXmlSoap\Element>
     */
    private array $elements = [];

    public function __construct(
        readonly private ?string $id = null,
        readonly private ?string $extId = null,
        private ?string          $pId = null,
        array                    $fields = [],
    )
    {
        $this->addAttribute('c_id', (string) $id);
        $this->addAttribute('c_ext_id', (string) $extId);
        $this->addAttribute('c_p_id', (string) $pId);

        if(!empty($fields)) {
            $this->addNewFields($fields);
        }
    }

    /**
     * @return string|null
     */
    public function getId() : ?string
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getExtId() : ?string
    {
        return $this->extId;
    }

    /**
     * @return string|null
     */
    public function getPId() : ?string
    {
        return $this->pId;
    }

    /**
     * @param  string  $pId
     *
     * @return $this
     */
    public function setPId(string $pId) : Category
    {
        $this->pId = $pId;

        return $this;
    }

    /**
     * @param  string|null  $id
     * @param  string|null  $extId
     *
     * @return Element
     */
    public function newElement(string $id = null, string $extId = null) : Element
    {
        return new Element($id, $extId);
    }

    public function pushElement(Closure|callable $closure, string $id = null, string $extId = null) : Category
    {
        return $this->addElement(
            $closure($this->newElement($id, $extId))
        );
    }

    /**
     * @param  Element|Closure  $element
     *
     * @return $this
     */
    public function addElement(Element|Closure $element) : Category
    {
        if($element instanceof Closure) {
            $element = $element($this);

            if($element instanceof Element === false) {
                throw new ElementsArrayException;
            }
        }

        $this->elements[] = $element;

        return $this;
    }

    /**
     * @return array<int, Element>
     */
    public function getElements() : array
    {
        return $this->elements;
    }

    /**
     * @throws \DOMException
     */
    public function getDOMElement(DOMDocument $document) : DOMElement
    {
        $domElement = $document->createElement('sb_cat');

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($this->getFields() as $field) {
            $domElement->appendChild(
                $field->getDOMElement($document)
            );
        }

        foreach ($this->getElements() as $element) {
            if($this->isDelete()) {
                $element->delete();
            }

            $domElement->appendChild(
                $element->getDOMElement($document)
            );
        }

        foreach ($this->getCategories() as $category) {
            $domElement->appendChild(
                $category->getDOMElement($document)
            );
        }

        return $domElement;
    }
}
