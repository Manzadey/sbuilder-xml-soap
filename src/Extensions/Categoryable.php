<?php

namespace Manzadey\SbuilderXmlSoap\Extensions;

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

    private function setUpCategories()
    {
        /* @var \Manzadey\SbuilderXmlSoap\Category $category */
        foreach ($this->categories as $category) {
            $this->DOMElement->appendChild($category->getCategory());
        }
    }
}
