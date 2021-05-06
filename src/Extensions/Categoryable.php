<?php

namespace Manzadey\SbuilderXmlSoap\Extensions;

use Manzadey\SbuilderXmlSoap\Category;
use Manzadey\SbuilderXmlSoap\Plugin;

trait Categoryable
{
    /**
     * @param \Manzadey\SbuilderXmlSoap\Category $category
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
     * @return \Manzadey\SbuilderXmlSoap\Category
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
        /* @var \Manzadey\SbuilderXmlSoap\Category $category */
        foreach ($this->categories as $category) {
            $this->DOMElement->appendChild($category->getCategory());
        }
    }
}
