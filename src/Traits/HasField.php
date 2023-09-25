<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

use Closure;
use InvalidArgumentException;
use Manzadey\SBuilderXmlSoap\Exceptions\FieldAddException;
use Manzadey\SBuilderXmlSoap\Exceptions\FieldsArrayException;
use Manzadey\SBuilderXmlSoap\Field;

trait HasField
{
    /**
     * @var array<int, \Manzadey\SBuilderXmlSoap\Field>
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

    public function addNewFields(array $fields) : static
    {
        foreach ($fields as $field => $value) {
            if(is_bool($value)) {
                $value = (int) $value;
            }

            if(!is_scalar($value)) {
                throw new InvalidArgumentException(sprintf('The value cannot be an %s', gettype($value)));
            }

            $this->addField($field, (string) $value);
        }

        return $this;
    }

    /**
     * @param  \Manzadey\SBuilderXmlSoap\Field|\Closure|string  $field
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

    public function getField(string $name) : Field|false
    {
        foreach ($this->fields as $field) {
            if($field->getName() === $name) {
                return $field;
            }
        }

        return false;
    }
}
