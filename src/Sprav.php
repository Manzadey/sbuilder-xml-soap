<?php

namespace Manzadey\SbuilderXmlSoap;

use DOMDocument;

class Sprav extends Plugin
{
    public function __construct(DOMDocument $xml, $attributes = [])
    {
        parent::__construct($xml, 'pl_sprav', $attributes);
    }
}
