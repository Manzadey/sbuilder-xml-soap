<?php

namespace Manzadey\SbuilderXmlSoap\v1\Extensions;

use Closure;
use Manzadey\SbuilderXmlSoap\v1\Field;

trait Fieldable
{
    /**
     * @param \Manzadey\SbuilderXmlSoap\v1\Field $field
     *
     * @return \Manzadey\SbuilderXmlSoap\v1\Extensions\Fieldable
     */
    public function addField(Field $field)
    {
        $this->fields[] = $field;

        return $this;
    }

    /**
     * @param string $value
     * @param array  $attributes
     *
     * @return \Manzadey\SbuilderXmlSoap\v1\Field
     */
    public function newField($value, $attributes = [])
    {
        return new Field($this->xml, $value, $attributes);
    }

    public function addNewField($value, Closure $closure, $attributes = [])
    {
        return $this->addField($closure($this->newField($value, $attributes)));
    }

    /**
     * @param string $name
     * @param string $value
     *
     * @return $this
     */
    public function addColumnField($name, $value)
    {
        $this->fields[] = $this->newField($value, compact('name'));

        return $this;
    }

    /**
     * @param $array
     *
     * @return $this
     */
    public function addColumnFields($array)
    {
        if(is_array($array)) {
            foreach ($array as $name => $value) {
                if(is_int($name)) {
                    $name = "user_f_{$name}";
                }

                $this->fields[] = $this->newField($value, compact('name'));
            }
        }

        return $this;
    }

    /**
     * @param int    $id
     * @param string $value
     *
     * @return $this
     */
    public function addColumnUserF($id, $value)
    {
        $this->fields[] = $this->newField($value, ['name' => "user_f_{$id}"]);

        return $this;
    }

    /**
     * @param string $title
     *
     * @return $this
     */
    public function addColumnTitle($title)
    {
        $this->fields[] = $this->newField($title, ['name' => $this->prefix . '_title']);

        return $this;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function addColumnActive($active)
    {
        $this->fields[] = $this->newField($active, ['name' => "{$this->prefix}_active"]);

        return $this;
    }

    public function addColumnPrice($i, $value)
    {
        $this->fields[] = $this->newField($value, ['name' => "p_price$i"]);

        return $this;
    }

    public function addColumnProp($i, $value)
    {
        $this->fields[] = $this->newField($value, ['name' => "s_prop$i"]);

        return $this;
    }

    public function addColumnSort($value)
    {
        $this->fields[] = $this->newField($value, ['name' => "{$this->prefix}_sort"]);

        return $this;
    }

    public function addColumnPubStart($value)
    {
        $this->fields[] = $this->newField($value, ['name' => 'p_pub_start']);

        return $this;
    }

    public function addColumnPubEnd($value)
    {
        $this->fields[] = $this->newField($value, ['name' => 'p_pub_end']);

        return $this;
    }

    public function addColumnTags($value)
    {
        $this->fields[] = $this->newField($value, ['name' => 'p_tags']);

        return $this;
    }

    public function addColumnUrl($value)
    {
        $this->fields[] = $this->newField($value, ['name' => 'p_url']);

        return $this;
    }

    public function setUpFields()
    {
        foreach ($this->fields as $field) {
            $this->DOMElement->appendChild($field->getField());
        }
    }
}
