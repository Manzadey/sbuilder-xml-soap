<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Exceptions;

use LogicException;
use Manzadey\SbuilderXmlSoap\Plugin;

class PluginsArrayException extends LogicException
{
    protected $message = 'The closure should return an instance of the class `' . Plugin::class . '`';
}
