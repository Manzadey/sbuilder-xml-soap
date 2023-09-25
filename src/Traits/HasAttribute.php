<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

trait HasAttribute
{
    private array $attributes = [];

    /**
     * @return array<string, string>
     */
    public function getAttributes() : array
    {
        return $this->attributes;
    }

    /**
     * @param  string  $name
     * @param  string  $value
     *
     * @return $this
     */
    public function addAttribute(string $name, string $value) : static
    {
        $this->attributes[$name] = $value;

        return $this;
    }

    /**
     * @param  string  $name
     *
     * @return string|null
     */
    public function getAttribute(string $name) : ?string
    {
        return $this->attributes[$name] ?? null;
    }

    /**
     * @param  string  $name
     *
     * @return bool
     */
    public function hasAttribute(string $name) : bool
    {
        return isset($this->attributes[$name]);
    }
}
