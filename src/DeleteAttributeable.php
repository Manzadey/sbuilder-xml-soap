<?php

namespace Manzadey\SbuilderXmlSoap;

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
