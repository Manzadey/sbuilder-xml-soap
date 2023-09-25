<?php

declare(strict_types=1);

use Manzadey\SBuilderXmlSoap\Traits\HasAttribute;
use PHPUnit\Framework\TestCase;

class HasAttributeTraitTest extends TestCase
{
    use HasAttribute;

    public function testReturnAttributes() : void
    {
        $this->assertIsArray($this->getAttributes());
    }

    public function testAddAttribute() : void
    {
        $this->assertFalse($this->hasAttribute('test_key'));
        $this->assertNull($this->getAttribute('test_key'));
        $this->addAttribute('test_key', 'test_value');
        $this->assertTrue($this->hasAttribute('test_key'));
        $this->assertSame('test_value', $this->getAttribute('test_key'));

        $this->assertCount(1, $this->getAttributes());
    }
}
