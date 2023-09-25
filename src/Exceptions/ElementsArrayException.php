<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SBuilderXmlSoap\Element;

class ElementsArrayException extends LogicException
{
    protected $message = 'The closure should return an instance of the class `' . Element::class . '`';
}
