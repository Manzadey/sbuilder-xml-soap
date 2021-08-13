<?php

namespace Manzadey\SbuilderXmlSoap\v1;

use DOMDocument;
use Manzadey\SbuilderXmlSoap\v1\Extensions\Attributeable;
use Manzadey\SbuilderXmlSoap\v1\Extensions\Categoryable;

/**
 * Class Plugin
 *
 * @package Manzadey\SbuilderXmlSoap\v1
 */
class Plugin
{
    use Attributeable;
    use Categoryable;

    const NAME = 'sb_plugin';

    /**
     * @var \DOMElement|false
     */
    private $DOMElement;

    /**
     * @var \DOMDocument
     */
    private $xml;

    /**
     * @var string[]
     */
    private $attributes;

    /**
     * @var \Manzadey\SbuilderXmlSoap\v1\Category[]
     */
    private $categories = [];

    /**
     * Plugin constructor.
     *
     * @param \DOMDocument $xml
     * @param string|int   $plugin Иидентификатор модуля, для которого загружаем элементы
     * @param array        $attributes
     */
    public function __construct(DOMDocument $xml, $plugin, $attributes = [])
    {
        $this->xml        = $xml;
        $this->DOMElement = $this->xml->createElement(self::NAME);
        $this->attributes = $attributes;
        is_int($plugin) ? $this->attributes['p_id'] = "pl_plugin_{$plugin}" : $this->attributes['p_id'] = $plugin;
    }

    /**
     * @param string $plugin
     */
    public function setPlugin($plugin)
    {
        $this->DOMElement = $plugin;
    }

    /**
     * @return \DOMElement|false
     */
    public function getPlugin()
    {
        $this->setUpAttributes();
        $this->setUpCategories();

        return $this->DOMElement;
    }
}
