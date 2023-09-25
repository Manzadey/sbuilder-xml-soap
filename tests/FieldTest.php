<?php

declare(strict_types=1);

use Manzadey\SBuilderXmlSoap\Field;
use PHPUnit\Framework\TestCase;

class FieldTest extends TestCase
{
    private Field $field;

    protected function setUp() : void
    {
        $this->field = new Field('p_title', 'test name');
    }

    public function testHasAttributes() : void
    {
        $this->assertTrue($this->field->hasAttribute('name'));
        $this->assertEquals('test name', $this->field->getValue());
        $this->assertEquals('p_title', $this->field->getName());
        $this->assertNull($this->field->getAttribute('ext_id'));
        $this->assertFalse($this->field->hasAttribute('ext_id'));

        $this->field->extId();

        $this->assertEquals('true', $this->field->getAttribute('ext_id'));
    }

    /**
     * @throws \DOMException
     */
    public function testXml() : void
    {
        $this->field->extId();

        $dom = new DOMDocument;
        $xml = $this->field->getDOMElement($dom);

        $this->assertTrue($xml->hasAttribute('name'));
        $this->assertTrue($xml->hasAttribute('ext_id'));
        $this->assertEquals('sb_field', $xml->nodeName);
        $this->assertEquals('p_title', $xml->getAttribute('name'));
        $this->assertEquals('test name', $xml->nodeValue);

        $dom->appendChild($xml);

        $this->assertEquals(82, strlen($dom->saveXML()));
    }
}
