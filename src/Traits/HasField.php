<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Traits;

use Closure;
use Manzadey\SbuilderXmlSoap\Exceptions\FieldAddException;
use Manzadey\SbuilderXmlSoap\Exceptions\FieldsArrayException;
use Manzadey\SbuilderXmlSoap\Field;

trait HasField
{
    /**
     * @var array<int, \Manzadey\SbuilderXmlSoap\Field>
     */
    private array $fields = [];

    /**
     * @param  string  $name
     * @param  string  $value
     *
     * @return Field
     */
    public function newField(string $name, string $value) : Field
    {
        return new Field($name, $value);
    }

    /**
     * @param  \Manzadey\SbuilderXmlSoap\Field|\Closure|string  $field
     * @param  string|null  $value
     *
     * @return $this
     */
    public function addField(Field|Closure|string $field, string $value = null) : static
    {
        if(is_string($field) && is_string($value)) {
            $field = $this->newField($field, $value);
        }

        if($field instanceof Closure) {
            $field = $field($this);

            if($field instanceof Field === false) {
                throw new FieldsArrayException;
            }
        }

        if($field instanceof Field === false) {
            throw new FieldAddException;
        }

        $this->fields[] = $field;

        return $this;
    }

    /**
     * @return array<int, Field>
     */
    public function getFields() : array
    {
        return $this->fields;
    }
}
