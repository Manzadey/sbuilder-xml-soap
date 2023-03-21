<?php

declare(strict_types=1);

use Manzadey\SbuilderXmlSoap\Element;
use Manzadey\SbuilderXmlSoap\Field;
use PHPUnit\Framework\TestCase;

class ElementTest extends TestCase
{
    private Element $element;

    private string $id = '123';

    private string $extId = '7175f3f0-a9af-11ed-afa1-0242ac120002';

    protected function setUp() : void
    {
        $this->element = new Element($this->id, $this->extId);
    }

    public function testAddAttributes() : void
    {
        $this->assertTrue($this->element->hasAttribute('e_id'));
        $this->assertTrue($this->element->hasAttribute('e_ext_id'));

        $this->assertEquals($this->id, $this->element->getAttribute('e_id'));
        $this->assertEquals($this->id, $this->element->getId());

        $this->assertEquals($this->extId, $this->element->getAttribute('e_ext_id'));
        $this->assertEquals($this->extId, $this->element->getExtId());

        $this->assertCount(2, $this->element->getAttributes());

        $this->addAttribute('test', 'test value');
        $this->assertTrue($this->element->hasAttribute('test'));
        $this->assertEquals('test value', $this->element->getAttribute('test'));
        $this->assertCount(3, $this->element->getAttributes());
    }

    public function testAddFields() : void
    {
        $this->addField('p_title', 'test');
        $this->assertCount(1, $this->element->getFields());

        $this->addField('user_f_1', '12345');
        $this->assertCount(2, $this->element->getFields());

        $this->element->addField('p_active', '1');
        $this->assertCount(3, $this->element->getFields());

        foreach ($this->element->getFields() as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }

    public function testAddLinks() : void
    {
        $this->addLink(123);
        $this->assertCount(1, $this->element->getLinks());

        $this->addLink(456);
        $this->assertCount(2, $this->element->getLinks());
    }

    /**
     * @throws \DOMException
     */
    public function testXml() : void
    {
        $dom = new DOMDocument;
        $xml = $this->element->getDOMElement($dom);

        $this->assertTrue($xml->hasAttribute('e_id'));
        $this->assertTrue($xml->hasAttribute('e_ext_id'));
        $this->assertEquals($this->id, $xml->getAttribute('e_id'));
        $this->assertEquals($this->extId, $xml->getAttribute('e_ext_id'));


        $this->addLink(123);
        $xml = $this->element->getDOMElement($dom);
        $this->assertSame(1, $xml->getElementsByTagName('sb_link')->count());

        $this->addAttribute('test_attribute', 'test value from test attribute');
        $xml = $this->element->getDOMElement($dom);
        $this->assertTrue($xml->hasAttribute('test_attribute'));

        $this->addField('test_field', 'test field value');
        $xml = $this->element->getDOMElement($dom);
        $this->assertSame(1, $xml->getElementsByTagName('sb_field')->count());

        $dom->appendChild($xml);
        $this->assertSame(226, strlen($dom->saveXML()));
    }

    private function addLink(int $id) : void
    {
        $this->element->addLink($id);
    }

    private function addField(string $name, string $value) : void
    {
        $this->element->addField(new Field($name, $value));
    }

    private function addAttribute(string $key, string $value) : void
    {
        $this->element->addAttribute($key, $value);
    }
}
