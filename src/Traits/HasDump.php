<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Traits;

use JetBrains\PhpStorm\NoReturn;

/**
 * @mixin \Manzadey\SbuilderXmlSoap\Category|\Manzadey\SbuilderXmlSoap\Element|\Manzadey\SbuilderXmlSoap\Field|\Manzadey\SbuilderXmlSoap\Plugin|\Manzadey\SbuilderXmlSoap\Plugins
 */
trait HasDump
{
    #[NoReturn]
    public function dd() : void
    {
        dd($this);
    }
}
