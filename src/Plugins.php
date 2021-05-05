<?php

namespace Manzadey\SbuilderXmlSoap;

use DOMDocument;
use SoapClient;

class Plugins
{
    /**
     * @var \DOMDocument
     */
    private $xml;

    /**
     * @var \Manzadey\SbuilderXmlSoap\Plugin[]
     */
    private $plugins = [];

    /**
     * @var \DOMElement|\DOMNode|false
     */
    private $xmlPlugins;

    /**
     * @var string
     */
    protected $soapMethod = 'plPluginsAdd';

    public function __construct($version = '1.0', $encoding = 'utf-8')
    {
        $this->xml        = new DOMDocument($version, $encoding);
        $this->xmlPlugins = $this->xml->appendChild($this->xml->createElement('sb_plugins'));
        $this->setUp();
    }

    private function setUp()
    {
        $this->xml->formatOutput = true;
    }

    /**
     * @return \DOMDocument
     */
    public function getXml()
    {
        return $this->xml;
    }

    /**
     * @param \Manzadey\SbuilderXmlSoap\Plugin $plugin
     *
     * @return \Manzadey\SbuilderXmlSoap\Plugins
     */
    public function addPlugin(Plugin $plugin)
    {
        /* @var \Manzadey\SbuilderXmlSoap\Plugin $pluginItem */
        $plugins = [];
        foreach ($this->plugins as $pluginItem) {
            $plugins[] = $pluginItem->getAttribute('p_id');
        }

        if(count($plugins) > 0) {
            if(!in_array($plugin->getAttribute('p_id'), $plugins, true)) {
                $this->plugins[] = $plugin;
            }
        } else {
            $this->plugins[] = $plugin;
        }

        return $this;
    }

    /**
     * @param string $name
     * @param array  $attributes
     *
     * @return \Manzadey\SbuilderXmlSoap\Plugin
     */
    public function newPlugin($name, $attributes = [])
    {
        return new Plugin($this->getXml(), $name, $attributes);
    }

    public function newSprav($attributes = [])
    {
        return new Sprav($this->getXml(), $attributes);
    }

    private function savePluginsToXml()
    {
        foreach ($this->plugins as $plugin) {
            $this->xmlPlugins->appendChild($plugin->getPlugin());
        }
    }

    /**
     * @param null $filepath
     *
     * @return false|int|string
     */
    public function save($filepath = null)
    {
        $this->savePluginsToXml();

        if($filepath !== null) {
            return $this->xml->save($filepath);
        }

        return $this->xml->saveXML();
    }

    /**
     * @throws \SoapFault
     */
    public function upload($url, $token)
    {
        $this->savePluginsToXml();

        try {
            $result = (new SoapClient($url))->{$this->soapMethod}($token, $this->xml->saveXML());
        } catch (ErrorException $exception) {
            return $exception->getMessage();
        }

        return new Result($result);
    }

    /**
     * @param string $soapMethod
     */
    public function setSoapMethod($soapMethod)
    {
        $this->soapMethod = $soapMethod;
    }
}
