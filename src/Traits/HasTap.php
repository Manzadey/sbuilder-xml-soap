<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

use Closure;

trait HasTap
{
    public function tap(Closure|callable $closure) : static
    {
        $closure($this);

        return $this;
    }
}
