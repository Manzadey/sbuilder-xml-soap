<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap;

use Closure;
use DOMDocument;
use Manzadey\SbuilderXmlSoap\Exceptions\PluginsArrayException;
use SoapClient;

final class Plugins
{
    /**
     * @var \DOMDocument
     */
    readonly private DOMDocument $xml;

    /**
     * @var array<int, \Manzadey\SbuilderXmlSoap\Plugin>
     */
    private array $plugins = [];

    public function __construct()
    {
        $this->xml = $this->createXml();
    }

    /**
     * @return \DOMDocument
     */
    private function createXml() : DOMDocument
    {
        $xml               = new DOMDocument('1.0', 'utf-8');
        $xml->formatOutput = true;

        return $xml;
    }

    /**
     * @param  string  $id
     *
     * @return \Manzadey\SbuilderXmlSoap\Plugin
     */
    public function newPlugin(string $id) : Plugin
    {
        return new Plugin($id);
    }

    /**
     * @param  \Manzadey\SbuilderXmlSoap\Plugin|\Closure  $plugin
     *
     * @return $this
     */
    public function addPlugin(Plugin|Closure $plugin) : Plugins
    {
        if($plugin instanceof Closure) {
            $plugin = $plugin($this);

            if($plugin instanceof Plugin === false) {
                throw new PluginsArrayException;
            }
        }

        $this->plugins[] = $plugin;

        return $this;
    }

    /**
     * @return array<int, Plugin>
     */
    public function getPlugins() : array
    {
        return $this->plugins;
    }

    /**
     * @throws \DOMException
     */
    private function generate() : void
    {
        $sbPlugins = $this->xml()
            ->createElement('sb_plugins');

        foreach ($this->plugins as $plugin) {
            $sbPlugins->appendChild(
                $plugin->xml($this->xml())
            );
        }

        $this->xml()
            ->appendChild($sbPlugins);
    }

    /**
     * @return DOMDocument
     */
    public function xml() : DOMDocument
    {
        return $this->xml;
    }

    /**
     * @throws \DOMException
     */
    public function save() : false|string
    {
        $this->generate();

        return $this->xml()->saveXML();
    }

    /**
     * @throws \SoapFault
     * @throws \DOMException
     */
    public function upload(string $url, string $token)
    {
        return (new SoapClient($url))
            ->plPluginsAdd($token, $this->save());
    }
}
