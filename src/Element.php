<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap;

use DOMDocument;
use DOMElement;
use DOMException;
use Manzadey\SbuilderXmlSoap\Traits\HasAttribute;
use Manzadey\SbuilderXmlSoap\Traits\HasField;
use Manzadey\SbuilderXmlSoap\Traits\HasIsDelete;
use Manzadey\SbuilderXmlSoap\Traits\HasTap;
use Manzadey\SbuilderXmlSoap\Traits\HasWhen;

final class Element
{
    use HasField;
    use HasAttribute;
    use HasIsDelete;
    use HasWhen;
    use HasTap;

    /**
     * @var array<int, int>
     */
    private array $links = [];

    public function __construct(
        readonly private ?string $id = null,
        readonly private ?string $extId = null,
    )
    {
        $this->addAttribute('e_id', (string) $id);
        $this->addAttribute('e_ext_id', (string) $extId);
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
    public function xml(DOMDocument $document) : bool|DOMElement
    {
        $domElement = $document->createElement('sb_elem');

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($this->getFields() as $field) {
            $domElement->appendChild($field->xml($document));
        }

        foreach ($this->getLinks() as $link) {
            $domElement->appendChild(
                $document->createElement('sb_link', (string) $link)
            );
        }

        return $domElement;
    }
}
