<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SBuilderXmlSoap\Field;

class FieldsArrayException extends LogicException
{
    protected $message = 'The closure should return an instance of the class `' . Field::class . '`';
}
