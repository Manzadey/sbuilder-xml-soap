<?php

declare(strict_types=1);

use Manzadey\SbuilderXmlSoap\Element;
use Manzadey\SbuilderXmlSoap\Exceptions\FieldAddException;
use Manzadey\SbuilderXmlSoap\Exceptions\FieldsArrayException;
use Manzadey\SbuilderXmlSoap\Field;
use Manzadey\SbuilderXmlSoap\Traits\HasField;
use PHPUnit\Framework\TestCase;

class HasFieldTraitTest extends TestCase
{
    use HasField;

    public function testReturnFields() : void
    {
        $this->assertIsArray($this->getFields());
    }

    public function testAddFields() : void
    {
        $this->addField('p_title', 'test');
        $this->assertCount(1, $this->getFields());

        $this->addField('user_f_1', '12345');
        $this->assertCount(2, $this->getFields());

        $this->addField('p_active', '1');
        $this->assertCount(3, $this->getFields());

        foreach ($this->getFields() as $field) {
            $this->assertInstanceOf(Field::class, $field);
        }
    }

    public function testFieldAddException() : void
    {
        $this->expectException(FieldAddException::class);
        $this->addField('p_active');
    }

    public function testFieldsArrayException() : void
    {
        $this->expectException(FieldsArrayException::class);

        $this->addField(
            static fn() => new Element
        );
    }
}