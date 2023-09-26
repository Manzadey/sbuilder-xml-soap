<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap;

use DOMDocument;
use DOMElement;
use Manzadey\SBuilderXmlSoap\Traits;

final class Plugin
{
    use Traits\HasAttribute;
    use Traits\HasCategory;
    use Traits\HasDump;

    public function __construct(
        readonly private int|string $pluginId
    )
    {
        $this->addAttribute('p_id', (string) $this->pluginId);
    }

    public static function make(int|string $pluginId) : Plugin
    {
        return new Plugin($pluginId);
    }

    /**
     * @return string
     */
    public function getPluginId() : string
    {
        return (string) $this->pluginId;
    }

    /**
     * @param  \DOMDocument  $document
     *
     * @throws \DOMException
     * @return \DOMElement
     */
    public function getDOMElement(DOMDocument $document) : DOMElement
    {
        $domElement = $document->createElement("sb_plugin");

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($this->categories as $category) {
            $domElement->appendChild(
                $category->getDOMElement($document)
            );
        }

        return $domElement;
    }
}
