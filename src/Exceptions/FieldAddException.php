<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SBuilderXmlSoap\Field;

class FieldAddException extends LogicException
{
    protected $message = 'Add only `' . Field::class . '` to fields array!';
}
