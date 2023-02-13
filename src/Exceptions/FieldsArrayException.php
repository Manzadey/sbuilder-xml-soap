<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SbuilderXmlSoap\Field;

class FieldsArrayException extends LogicException
{
    protected $message = 'The closure should return an instance of the class `' . Field::class . '`';
}
