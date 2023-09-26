<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

use Closure;
use Manzadey\SBuilderXmlSoap\Category;
use Manzadey\SBuilderXmlSoap\Exceptions\CategoriesArrayException;

trait HasCategory
{
    /**
     * @var array<int, \Manzadey\SBuilderXmlSoap\Category>
     */
    private array $categories = [];

    public function newCategory(string $id = null, string $extId = null, string $pId = null) : Category
    {
        return new Category($id, $extId, $pId);
    }

    /**
     * @param  \Manzadey\SBuilderXmlSoap\Category|\Closure  $category
     *
     * @return $this
     */
    public function addCategory(Category|Closure $category) : static
    {
        if($category instanceof Closure) {
            $category = $category($this);

            if($category instanceof Category === false) {
                throw new CategoriesArrayException;
            }
        }

        $this->categories[] = $category;

        return $this;
    }

    /**
     * @return array<int, \Manzadey\SBuilderXmlSoap\Category>
     */
    public function getCategories() : array
    {
        return $this->categories;
    }

    public function hasCategories() : bool
    {
        return !empty($this->getCategories());
    }

    public function countCategories() : int
    {
        return count($this->getCategories());
    }

    public function removeCategory(Category $category) : bool
    {
        if($this->hasCategories()) {
            foreach ($this->getCategories() as $i => $existCategory) {
                if($existCategory === $category) {
                    unset($this->categories[$i]);

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @param  string  $fieldName
     * @param  string  $value
     *
     * @return bool
     */
    public function hasCategoryFromFieldValue(string $fieldName, string $value) : bool
    {
        return $this->getCategoryFromFieldValue($fieldName, $value) !== null;
    }

    /**
     * @param  string  $fieldName
     * @param  string  $value
     *
     * @return \Manzadey\SBuilderXmlSoap\Category|null
     */
    public function getCategoryFromFieldValue(string $fieldName, string $value) : ?Category
    {
        foreach ($this->categories as $category) {
            foreach ($category->getFields() as $field) {
                if($fieldName === $field->getName() && $value === $field->getValue()) {
                    return $category;
                }
            }
        }

        return null;
    }

    /**
     * @param  string  $fieldName
     * @param  string  $value
     *
     * @return array<int, Category>
     */
    public function getCategoriesByFieldValue(string $fieldName, string $value) : array
    {
        $found = [];

        foreach ($this->categories as $category) {
            foreach ($category->getFields() as $field) {
                if($fieldName === $field->getName() && $value === $field->getValue()) {
                    $found[] = $category;
                }
            }
        }

        return $found;
    }

    /**
     * @param  string  $name
     * @param  string  $value
     *
     * @return array<int, Category>
     */
    public function getCategoriesByAttributeValue(string $name, string $value) : array
    {
        $found = [];

        foreach ($this->getCategories() as $category) {
            foreach ($category->getAttributes() as $attributeName => $attributeValue) {
                if($attributeName === $name && $attributeValue === $value) {
                    $found[] = $category;
                }
            }
        }

        return $found;
    }
}
