<?php

declare(strict_types=1);

use Manzadey\SBuilderXmlSoap\Category;
use Manzadey\SBuilderXmlSoap\Traits\HasCategory;
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
        $this->assertTrue(method_exists($this, 'newCategory'));
    }

    public function testMethodAddCategory() : void
    {
        $this->assertTrue(method_exists($this, 'addCategory'));
    }

    public function testMethodGetCategories() : void
    {
        $this->assertTrue(method_exists($this, 'getCategories'));

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

    public function testHasCategoriesMethod() : void
    {
        $this->assertTrue(method_exists($this, 'hasCategories'));

        $this->assertFalse($this->hasCategories());

        $this->addCategory(
            $this->newCategory()->addField('cat_title', 'category title')
        );

        $this->assertTrue($this->hasCategories());
    }

    public function testCountCategoriesMethod() : void
    {
        $this->assertTrue(method_exists($this, 'countCategories'));
        $this->assertEquals(0, $this->countCategories());

        $this->addCategory(
            $this->newCategory()->addField('cat_title', 'category title')
        );
        $this->assertEquals(1, $this->countCategories());

        $this->addCategory(
            $this->newCategory()->addField('cat_title', 'category title 2')
        );
        $this->assertEquals(2, $this->countCategories());
    }

    public function testGetCategoriesByAttributeValueMethod() : void
    {
        $this->assertTrue(method_exists($this, 'getCategoriesByAttributeValue'));

         $this->assertCount(0, $this->getCategoriesByAttributeValue('c_id', '123'));

        $categories = [
            '123',
            '456',
            '789',
            '101',
        ];

        foreach ($categories as $category) {
            $this->addCategory(
                Category::make($category),
            );
        }

        $this->assertCount(1, $this->getCategoriesByAttributeValue('c_id', '123'));
    }

    public function testRemoveCategoryMethod() : void
    {
        $this->assertTrue(method_exists($this, 'removeCategory'));

        $this->assertFalse($this->removeCategory(Category::make('123')));

        $categories = [
            '123',
            '456',
            '789',
            '101',
        ];

        $totalCategories = count($categories);

        foreach ($categories as $category) {
            $this->addCategory(
                Category::make($category),
            );
        }

        $this->assertEquals($totalCategories, $this->countCategories());

        $categoriesFound = $this->getCategoriesByAttributeValue('c_id', '123');
        $category        = array_shift($categoriesFound);

        $this->assertTrue($this->removeCategory($category));
    }
}
