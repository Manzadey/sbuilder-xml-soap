<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Traits;

use Closure;

trait HasWhen
{
    public function when(bool $value, Closure $closure) : static
    {
        if($value) {
            return $closure($this);
        }

        return $this;
    }
}
