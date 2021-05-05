<?php

namespace Manzadey\SbuilderXmlSoap;

use DOMDocument;

/**
 * Class Plugin
 *
 * @package Manzadey\SbuilderXmlSoap
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
     * @var \Manzadey\SbuilderXmlSoap\Category[]
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
     * @param string[] $attributes
     *
     * @return \Manzadey\SbuilderXmlSoap\Category
     */
    public function newCategory($attributes = ['c_id' => '', 'c_ext_id' => '', 'c_p_id' => ''])
    {
        return new Category($this->xml, $attributes);
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
