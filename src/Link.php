<?php

namespace Manzadey\SbuilderXmlSoap;

class Link
{
    const NAME = 'sb_link';

    /**
     * @param \DOMDocument $xml
     * @param int          $value
     *
     * @return \DOMElement|false
     */
    public function __invoke(\DOMDocument $xml, $value)
    {
        return $xml->createElement(self::NAME, $value);
    }
}
