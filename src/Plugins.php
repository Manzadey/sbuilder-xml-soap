<?php

declare(strict_types=1);

namespace Manzadey\SBuilderXmlSoap;

use Closure;
use DOMDocument;
use Manzadey\SBuilderXmlSoap\Exceptions\PluginsArrayException;
use Manzadey\SBuilderXmlSoap\Traits\HasDump;
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
     * @var array<int, \Manzadey\SBuilderXmlSoap\Plugin>
     */
    private array $plugins = [];

    private ?string $url = null;

    private ?string $token = null;

    public function __construct(
        private readonly array $options = [],
    )
    {
        $this->xml = $this->createDOMDocument();

        $this->setOptions($this->options);
    }

    public function setUrl(?string $url) : Plugins
    {
        $this->url = $url;

        return $this;
    }

    public function setToken(?string $token) : Plugins
    {
        $this->token = $token;

        return $this;
    }

    public function setOptions(?array $options) : Plugins
    {
        if(array_key_exists('url', $options)) {
            $this->setUrl($options['url']);
        }

        if(array_key_exists('token', $options)) {
            $this->setUrl($options['token']);
        }

        return $this;
    }

    /**
     * @return \DOMDocument
     */
    private function createDOMDocument() : DOMDocument
    {
        $xml                     = new DOMDocument('1.0', 'utf-8');
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput       = true;

        return $xml;
    }

    /**
     * @param  string  $id
     * @param  \Closure|callable|null  $callable
     *
     * @return \Manzadey\SBuilderXmlSoap\Plugins|\Manzadey\SBuilderXmlSoap\Plugin
     */
    public function newPlugin(string $id, Closure|callable $callable = null) : Plugins|Plugin
    {
        if(!is_null($callable)) {
            return $this->addPlugin(
                $callable($this->newPlugin($id))
            );
        }

        return new Plugin($id);
    }

    /**
     * @param  \Manzadey\SBuilderXmlSoap\Plugin|\Closure|callable  $plugin
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
    public function upload(string $url = null, string $token = null, array $options = [])
    {
        if(filter_var($url, FILTER_VALIDATE_URL)) {
            $this->setUrl($url);
        }

        if(is_string($token)) {
            $this->setToken($token);
        }

        if($options) {
            $this->setOptions($options);
        }

        return (new SoapClient($this->url, $this->options))
            ->plPluginsAdd($this->token, $this->save());
    }
}
