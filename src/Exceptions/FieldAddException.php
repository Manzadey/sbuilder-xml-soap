<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SbuilderXmlSoap\Field;

class FieldAddException extends LogicException
{
    protected $message = 'Add only `' . Field::class . '` to fields array!';
}
