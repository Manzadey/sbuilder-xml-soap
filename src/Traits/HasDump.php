<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap\Traits;

use JetBrains\PhpStorm\NoReturn;

/**
 * @mixin \Manzadey\SBuilderXmlSoap\Category|\Manzadey\SBuilderXmlSoap\Element|\Manzadey\SBuilderXmlSoap\Field|\Manzadey\SBuilderXmlSoap\Plugin|\Manzadey\SBuilderXmlSoap\Plugins
 */
trait HasDump
{
    #[NoReturn]
    public function dd() : void
    {
        dd($this);
    }
}
