<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Traits;

use Closure;

trait HasWhen
{
    public function when(bool $value, Closure $closureTrue, Closure $closureFalse = null) : static
    {
        if($value) {
            return $closureTrue($this);
        }

        if($closureFalse !== null) {
            return $closureFalse($this);
        }

        return $this;
    }
}
