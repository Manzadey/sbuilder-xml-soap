<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap;

use DOMDocument;
use DOMElement;
use DOMException;
use Manzadey\SBuilderXmlSoap\Traits\HasAttribute;
use Manzadey\SBuilderXmlSoap\Traits\HasDump;
use Manzadey\SBuilderXmlSoap\Traits\HasField;
use Manzadey\SBuilderXmlSoap\Traits\HasIsDelete;
use Manzadey\SBuilderXmlSoap\Traits\HasTap;
use Manzadey\SBuilderXmlSoap\Traits\HasWhen;

final class Element
{
    use HasField;
    use HasAttribute;
    use HasIsDelete;
    use HasWhen;
    use HasTap;
    use HasDump;

    /**
     * @var array<int, int>
     */
    private array $links = [];

    public function __construct(
        readonly private ?string $id = null,
        readonly private ?string $extId = null,
        array                    $fields = [],
    )
    {
        $this->addAttribute('e_id', (string) $id);
        $this->addAttribute('e_ext_id', (string) $extId);

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
     * @return array<int, int>
     */
    public function getLinks() : array
    {
        return $this->links;
    }

    public function addLink(int $id) : Element
    {
        $this->links[] = $id;

        return $this;
    }

    /**
     * @throws DOMException
     */
    public function getDOMElement(DOMDocument $document) : DOMElement
    {
        $domElement = $document->createElement('sb_elem');

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($this->getFields() as $field) {
            $domElement->appendChild($field->getDOMElement($document));
        }

        foreach ($this->getLinks() as $link) {
            $domElement->appendChild(
                $document->createElement('sb_link', (string) $link)
            );
        }

        return $domElement;
    }
}
