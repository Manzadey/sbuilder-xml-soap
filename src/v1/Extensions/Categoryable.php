<?php

namespace Manzadey\SbuilderXmlSoap\v1\Extensions;

use Manzadey\SbuilderXmlSoap\v1\Category;

trait Categoryable
{
    /**
     * @param \Manzadey\SbuilderXmlSoap\v1\Category $category
     *
     * @return $this
     */
    public function addCategory(Category $category)
    {
        $this->categories[] = $category;

        return $this;
    }

    /**
     * @param string[] $attributes
     *
     * @return \Manzadey\SbuilderXmlSoap\v1\Category
     */
    public function newCategory($attributes = [])
    {
        return new Category($this->xml, $attributes);
    }

    /**
     * @param \Closure $closure
     * @param array    $attributes
     *
     * @return $this
     */
    public function addNewCategory(\Closure $closure, $attributes = [])
    {
        return $this->addCategory($closure($this->newCategory($attributes)));
    }

    private function setUpCategories()
    {
        foreach ($this->categories as $category) {
            $this->DOMElement->appendChild($category->getCategory());
        }
    }
}
