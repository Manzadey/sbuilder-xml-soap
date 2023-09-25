<?php

declare(strict_types=1);

use Manzadey\SBuilderXmlSoap\Category;
use Manzadey\SBuilderXmlSoap\Element;
use Manzadey\SBuilderXmlSoap\Field;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{
    private Category $category;

    protected function setUp() : void
    {
        $this->category = new Category(
            '123',
            '7175f3f0-a9af-11ed-afa1-0242ac120002',
            '456'
        );
    }

    public function testAddAttributes() : void
    {
        $this->assertTrue($this->category->hasAttribute('c_id'));
        $this->assertTrue($this->category->hasAttribute('c_ext_id'));
        $this->assertTrue($this->category->hasAttribute('c_p_id'));

        $this->assertCount(3, $this->category->getAttributes());
        $this->assertEquals('123', $this->category->getAttribute('c_id'));
        $this->assertEquals('7175f3f0-a9af-11ed-afa1-0242ac120002', $this->category->getAttribute('c_ext_id'));
        $this->assertEquals('456', $this->category->getAttribute('c_p_id'));

        $this->assertEquals('123', $this->category->getId());
        $this->assertEquals('7175f3f0-a9af-11ed-afa1-0242ac120002', $this->category->getExtId());
        $this->assertEquals('456', $this->category->getPId());

        $this->category->setPId('789');
        $this->assertEquals('789', $this->category->getPId());

        $this->assertNull($this->category->getAttribute('test_attribute'));
        $this->category->addAttribute('test_attribute', 'test value');
        $this->assertEquals('test value', $this->category->getAttribute('test_attribute'));
    }

    public function testAddFields() : void
    {
        $this->category->addField(new Field('cat_title', 'test'));
        $this->assertCount(1, $this->category->getFields());

        $this->category->addField(new Field('user_f_10', '98765'));
        $this->assertCount(2, $this->category->getFields());

        $this->category->addField(
            static fn(Category $category) : Field => $category->newField('test_name', 'test_value')
        );
        $this->assertCount(3, $this->category->getFields());

        $this->category->addField('user_f_17', 'value');
        $this->assertCount(4, $this->category->getFields());

        foreach ($this->category->getFields() as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }

    public function testPushElement() : void
    {
        $this->category->pushElement(
            static fn(Element $element) : Element => $element
        );
        $this->assertCount(1, $this->category->getElements());

        $this->category->pushElement(
            static fn(Element $element) : Element => $element,
            '123',
        );
        $this->assertCount(2, $this->category->getElements());

        $this->category->pushElement(
            static fn(Element $element) : Element => $element,
            '123',
            '456'
        );
        $this->assertCount(3, $this->category->getElements());
    }

    public function testAddElements() : void
    {
        $this->category->addElement(new Element);
        $this->assertCount(1, $this->category->getElements());

        $this->category->addElement(new Element);
        $this->assertCount(2, $this->category->getElements());

        $this->category->addElement(
            static fn(Category $category) : Element => $category->newElement()
        );
        $this->assertCount(3, $this->category->getElements());

        foreach ($this->category->getElements() as $element) {
            $this->assertInstanceOf(Element::class, $element);
        }
    }

    public function testAddCategory() : void
    {
        $this->category->addCategory(new Category);
        $this->assertCount(1, $this->category->getCategories());

        $this->category->addCategory(
            static fn(Category $category) : Category => $category->newCategory()
        );

        $this->assertCount(2, $this->category->getCategories());
    }

    /**
     * @throws \DOMException
     */
    public function testXml() : void
    {
        $dom = new DOMDocument;
        $xml = $this->category->getDOMElement($dom);

        $this->assertEquals('sb_cat', $xml->nodeName);
        $this->assertTrue($xml->hasAttribute('c_id'));
        $this->assertTrue($xml->hasAttribute('c_ext_id'));
        $this->assertTrue($xml->hasAttribute('c_p_id'));

        $this->assertEquals('123', $xml->getAttribute('c_id'));
        $this->assertEquals('7175f3f0-a9af-11ed-afa1-0242ac120002', $xml->getAttribute('c_ext_id'));
        $this->assertEquals('456', $xml->getAttribute('c_p_id'));

        $dom->appendChild($xml);

        $this->assertEquals(104, strlen($dom->saveXML()));
    }
}
