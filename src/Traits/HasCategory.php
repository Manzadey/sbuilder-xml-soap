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
}
