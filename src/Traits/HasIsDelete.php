<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap\Traits;

/**
 * @mixin \Manzadey\SbuilderXmlSoap\Traits\HasAttribute
 */
trait HasIsDelete
{
    /**
     * @return $this
     */
    public function delete() : static
    {
        $this->addAttribute('delete', 'delete');

        return $this;
    }

    public function isDelete() : bool
    {
        return $this->getAttribute('delete') === 'delete';
    }
}
