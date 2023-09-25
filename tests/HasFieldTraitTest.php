<?php

declare(strict_types=1);

use Manzadey\SBuilderXmlSoap\Element;
use Manzadey\SBuilderXmlSoap\Exceptions\FieldAddException;
use Manzadey\SBuilderXmlSoap\Exceptions\FieldsArrayException;
use Manzadey\SBuilderXmlSoap\Field;
use Manzadey\SBuilderXmlSoap\Traits\HasField;
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

    public function testGetField() : void
    {
        $this->addField('p_title', 'test');
        $this->assertCount(1, $this->getFields());

        $this->addField('user_f_1', '12345');
        $this->assertCount(2, $this->getFields());

        $this->assertInstanceOf(Field::class, $this->getField('p_title'));
        $this->assertInstanceOf(Field::class, $this->getField('user_f_1'));
        $this->assertFalse($this->getField('p_active'));
    }

    public function testAddNewFields() : void
    {
        $this->addNewFields([
            'p_title'  => 'test',
            'user_f_1' => '12345',
            'user_f_3' => 12345,
            'user_f_4' => 124.45
        ]);

        $this->assertCount(4, $this->getFields());

        $this->expectException(InvalidArgumentException::class);
        $this->addNewFields([
            'user_f_5' => [
                'value1',
                'value2',
            ],
        ]);

        $this->expectException(InvalidArgumentException::class);
        $this->addNewFields([
            'user_f_5' => new stdClass(),
        ]);
    }
}
