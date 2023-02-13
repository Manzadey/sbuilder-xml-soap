<?php

declare(strict_types=1);

use Manzadey\SbuilderXmlSoap\Category;
use Manzadey\SbuilderXmlSoap\Traits\HasCategory;
use PHPUnit\Framework\TestCase;

class HasCategoryTraitTest extends TestCase
{
    use HasCategory;

    public function testReturnCategories() : void
    {
        $this->assertIsArray($this->getCategories());
    }

    public function testMethodNewCategory() : void
    {
        $this->assertTrue(method_exists($this,'newCategory'));
    }

    public function testMethodAddCategory() : void
    {
        $this->assertTrue(method_exists($this,'addCategory'));
    }

    public function testMethodGetCategories() : void
    {
        $this->assertTrue(method_exists($this,'getCategories'));

        $this->assertIsArray($this->getCategories());
    }

    public function testMethodHasCategoryFromFieldValue() : void
    {
        $this->assertTrue(method_exists($this, 'hasCategoryFromFieldValue'));

        $this->addCategory(
            $this->newCategory()->addField('cat_title', 'category title')
        );

        $this->assertTrue($this->hasCategoryFromFieldValue('cat_title', 'category title'));
        $this->assertFalse($this->hasCategoryFromFieldValue('cat_title', 'category title 2'));
        $this->assertFalse($this->hasCategoryFromFieldValue('cat_title2', 'category title'));
    }

    public function testMethodGetCategoryFromFieldValue() : void
    {
        $this->assertTrue(method_exists($this, 'getCategoryFromFieldValue'));

        $this->addCategory(
            $this->newCategory()->addField('cat_title', 'category title')
        );

        $this->assertInstanceOf(Category::class, $this->getCategoryFromFieldValue('cat_title', 'category title'));
        $this->assertNull($this->getCategoryFromFieldValue('cat_title2', 'category title'));
        $this->assertNull($this->getCategoryFromFieldValue('cat_title', 'category title2'));
    }
}
