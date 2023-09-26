<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

use JetBrains\PhpStorm\NoReturn;

trait HasDump
{
    #[NoReturn]
    public function dd() : void
    {
        dd($this);
    }
}
