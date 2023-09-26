<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap;

use DOMDocument;
use DOMElement;
use Manzadey\SBuilderXmlSoap\Traits;

final class Field
{
    use Traits\HasAttribute;
    use Traits\HasDump;

    public function __construct(
        readonly private string $name,
        readonly private string $value,
    )
    {
        $this->addAttribute('name', $name);
    }

    public static function make(
        string $name,
        string $value,
    ) : Field
    {
        return new Field($name, $value);
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue() : string
    {
        return $this->value;
    }

    public function extId() : Field
    {
        $this->addAttribute('ext_id', 'true');

        return $this;
    }

    public function isExtId() : bool
    {
        return $this->getAttribute('ext_id') === 'true';
    }

    /**
     * @throws \DOMException
     */
    public function getDOMElement(DOMDocument $document) : DOMElement
    {
        $domElement = $document->createElement('sb_field', $this->getValue());

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        return $domElement;
    }
}
