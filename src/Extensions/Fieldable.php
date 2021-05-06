<?php

namespace Manzadey\SbuilderXmlSoap\Extensions;

trait Fieldable
{
    /**
     * @param \Manzadey\SbuilderXmlSoap\Field $field
     *
     * @return \Manzadey\SbuilderXmlSoap\Fieldable
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
     * @return \Manzadey\SbuilderXmlSoap\Field
     */
    public function newField($value, $attributes = [])
    {
        return new Field($this->xml, $value, $attributes);
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
        $this->fields[] = new Field($this->xml, $active, ['name' => $this->prefix . '_active']);

        return $this;
    }

    public function setUpFields()
    {
        /* @var \Manzadey\SbuilderXmlSoap\Field $field */
        foreach ($this->fields as $field) {
            $this->DOMElement->appendChild($field->getField());
        }
    }
}
