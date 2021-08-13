<?php

namespace Manzadey\SbuilderXmlSoap\v1\Extensions;

trait DeleteAttributeable
{
    /**
     * @return $this
     */
    public function delete()
    {
        $this->attributes['delete'] = 'delete';

        return $this;
    }
}
