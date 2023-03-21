<?php

declare(strict_types=1);

namespace Manzadey\SbuilderXmlSoap;

use Closure;
use DOMDocument;
use Manzadey\SbuilderXmlSoap\Exceptions\PluginsArrayException;
use Manzadey\SbuilderXmlSoap\Traits\HasDump;
use SoapClient;

final class Plugins
{
    use HasDump;

    /**
     * @var \DOMDocument
     */
    readonly private DOMDocument $xml;

    private bool $is_generate = false;

    /**
     * @var array<int, \Manzadey\SbuilderXmlSoap\Plugin>
     */
    private array $plugins = [];

    public function __construct()
    {
        $this->xml = $this->createDOMDocument();
    }

    /**
     * @return \DOMDocument
     */
    private function createDOMDocument() : DOMDocument
    {
        $xml               = new DOMDocument('1.0', 'utf-8');
        $xml->formatOutput = true;

        return $xml;
    }

    /**
     * @param  string  $id
     * @param  \Closure|callable|null  $callable
     *
     * @return \Manzadey\SbuilderXmlSoap\Plugins|\Manzadey\SbuilderXmlSoap\Plugin
     */
    public function newPlugin(string $id, Closure|callable $callable = null) : Plugins|Plugin
    {
        if(!is_null($callable)) {
            return $this->addPlugin($callable(new Plugin($id)));
        }

        return new Plugin($id);
    }

    /**
     * @param  \Manzadey\SbuilderXmlSoap\Plugin|\Closure|callable  $plugin
     *
     * @return $this
     */
    public function addPlugin(Plugin|Closure|callable $plugin) : Plugins
    {
        if($plugin instanceof Closure) {
            $plugin = $plugin($this);

            if($plugin instanceof Plugin === false) {
                throw new PluginsArrayException;
            }
        }

        $this->pushPlugin($plugin);

        return $this;
    }

    private function pushPlugin(Plugin $plugin) : void
    {
        $this->plugins[] = $plugin;
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
        $sbPlugins = $this->getDOMDocument()
            ->createElement('sb_plugins');

        foreach ($this->getPlugins() as $plugin) {
            $sbPlugins->appendChild(
                $plugin->getDOMElement($this->getDOMDocument())
            );
        }

        $this->getDOMDocument()->appendChild($sbPlugins);
    }

    public function getDOMDocument() : DOMDocument
    {
        return $this->xml;
    }

    /**
     * @throws \DOMException
     */
    public function save() : false|string
    {
        if(!$this->is_generate) {
            $this->is_generate = !$this->is_generate;

            $this->generate();
        }

        return $this->getDOMDocument()->saveXML();
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
