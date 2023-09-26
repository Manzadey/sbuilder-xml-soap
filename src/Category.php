<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap;

use Closure;
use DOMDocument;
use DOMElement;
use Manzadey\SBuilderXmlSoap\Exceptions\ElementsArrayException;
use Manzadey\SBuilderXmlSoap\Traits\HasAttribute;
use Manzadey\SBuilderXmlSoap\Traits\HasCategory;
use Manzadey\SBuilderXmlSoap\Traits\HasDump;
use Manzadey\SBuilderXmlSoap\Traits\HasField;
use Manzadey\SBuilderXmlSoap\Traits\HasIsDelete;
use Manzadey\SBuilderXmlSoap\Traits\HasTap;
use Manzadey\SBuilderXmlSoap\Traits\HasWhen;

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
     * @var array<int, \Manzadey\SBuilderXmlSoap\Element>
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

    public static function make(
        ?string $id = null,
        ?string $extId = null,
        ?string $pId = null,
        array   $fields = []
    ) : Category
    {
        return new Category($id, $extId, $pId, $fields);
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
        return Element::make($id, $extId);
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

    public function hasElements() : bool
    {
        return !empty($this->getElements());
    }

    public function countElements() : int
    {
        return count($this->getElements());
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
