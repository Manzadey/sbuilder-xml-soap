<?php

declare(strict_types=1);

use Manzadey\SbuilderXmlSoap\Category;
use Manzadey\SbuilderXmlSoap\Element;
use Manzadey\SbuilderXmlSoap\Exceptions\CategoriesArrayException;
use Manzadey\SbuilderXmlSoap\Field;
use Manzadey\SbuilderXmlSoap\Plugin;
use PHPUnit\Framework\TestCase;

class PluginTest extends TestCase
{
    private Plugin $plugin;

    protected function setUp() : void
    {
        $this->plugin = new Plugin('pl_plugin_1');
    }

    public function testPluginId() : void
    {
        $this->assertEquals('pl_plugin_1', $this->plugin->getPluginId());
    }

    public function testAddCategory() : void
    {
        $this->plugin->addCategory(new Category);
        $this->assertCount(1, $this->plugin->getCategories());

        $this->plugin->addCategory(
            fn(Plugin $plugin) : Category => $this->plugin->newCategory('1')
        );
        $this->assertCount(2, $this->plugin->getCategories());
    }

    public function testAddCategoryException() : void
    {
        $this->expectException(CategoriesArrayException::class);
        $this->expectExceptionMessage('The closure should return an instance of the class `' . Category::class . '`');

        $this->plugin = new Plugin('pl_sprav');
        $this->plugin->addCategory(
            static fn(Plugin $plugin) => (new Element)
        );
    }

    public function testHasCategory() : void
    {
        $this->plugin = new Plugin('pl_sprav');
        $category     = new Category;

        $category->addField(
            (new Field('p_title', 'test'))
        );
        $this->plugin->addCategory($category);
        $this->assertCount(1, $this->plugin->getCategories());

        $this->assertTrue($this->plugin->hasCategoryFromFieldValue('p_title', 'test'));
        $this->assertEquals($category, $this->plugin->getCategoryFromFieldValue('p_title', 'test'));
    }

    public function testHasAttributes() : void
    {
        $this->assertNull($this->plugin->getAttribute('test'));
        $this->plugin->addAttribute('test', 'test');

        $this->assertTrue($this->plugin->hasAttribute('p_id'));
        $this->assertTrue($this->plugin->hasAttribute('test'));
        $this->assertEquals('pl_plugin_1', $this->plugin->getAttribute('p_id'));
        $this->assertEquals('test', $this->plugin->getAttribute('test'));
    }

    /**
     * @throws \DOMException
     */
    public function testXml() : void
    {
        $dom          = new DOMDocument;
        $this->plugin = new Plugin('pl_plugin_1');

        $domElement = $this->plugin->getDOMElement($dom);

        $this->assertEquals('sb_plugin', $domElement->nodeName);
        $this->assertTrue($domElement->hasAttribute('p_id'));
        $this->assertEquals('pl_plugin_1', $domElement->getAttribute('p_id'));

        $dom->appendChild($domElement);
        $this->assertEquals(54, strlen($dom->saveXML()));
    }
}
