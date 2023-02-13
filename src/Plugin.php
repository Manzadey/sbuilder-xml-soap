<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap;

use Closure;
use DOMDocument;
use DOMElement;
use Manzadey\SbuilderXmlSoap\Exceptions\CategoriesArrayException;
use Manzadey\SbuilderXmlSoap\Traits\HasAttribute;
use Manzadey\SbuilderXmlSoap\Traits\HasCategory;

final class Plugin
{
    use HasAttribute;
    use HasCategory;

    public function __construct(
        readonly private string $pluginId
    )
    {
        $this->addAttribute('p_id', $this->pluginId);
    }

    /**
     * @return string
     */
    public function getPluginId() : string
    {
        return $this->pluginId;
    }

    /**
     * @param  \DOMDocument  $document
     *
     * @throws \DOMException
     * @return \DOMElement
     */
    public function xml(DOMDocument $document) : DOMElement
    {
        $domElement = $document->createElement("sb_plugin");

        foreach ($this->getAttributes() as $name => $value) {
            $domElement->setAttribute($name, $value);
        }

        foreach ($this->categories as $category) {
            $domElement->appendChild(
                $category->xml($document)
            );
        }

        return $domElement;
    }
}
