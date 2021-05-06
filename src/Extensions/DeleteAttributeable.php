<?php

namespace Manzadey\SbuilderXmlSoap\Extensions;

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
