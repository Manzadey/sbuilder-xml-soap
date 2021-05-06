<?php

namespace Manzadey\SbuilderXmlSoap\Extensions;

trait Attributeable
{
    private function setUpAttributes()
    {
        foreach ($this->attributes as $name => $value) {
            $this->DOMElement->setAttribute($name, $value);
        }
    }

    /**
     * @param $name
     * @param $value
     *
     * @return $this
     */
    public function addAttribute($name, $value)
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param $key
     *
     * @return string
     */
    public function getAttribute($key)
    {
        return $this->getAttributes()[$key];
    }
}
