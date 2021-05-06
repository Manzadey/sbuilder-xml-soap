<?php

namespace Manzadey\SbuilderXmlSoap;

use DOMDocument;

class Sprav extends Plugin
{
    /**
     * Sprav constructor.
     *
     * @param \DOMDocument $xml
     * @param array        $attributes
     */
    public function __construct(DOMDocument $xml, $attributes = [])
    {
        parent::__construct($xml, 'pl_sprav', $attributes);
    }
}
