<?php

declare(strict_types=1);

use Manzadey\SbuilderXmlSoap\Exceptions\PluginsArrayException;
use Manzadey\SbuilderXmlSoap\Field;
use Manzadey\SbuilderXmlSoap\Plugin;
use Manzadey\SbuilderXmlSoap\Plugins;
use PHPUnit\Framework\TestCase;

class PluginsTest extends TestCase
{
    public function testAddPlugins() : void
    {
        $plugins = new Plugins;

        $plugins->addPlugin(new Plugin('pl_sprav'));
        $this->assertCount(1, $plugins->getPlugins());

        $plugins->addPlugin($plugins->newPlugin('pl_plugin_1'));
        $this->assertCount(2, $plugins->getPlugins());

        $plugins->addPlugin(
            static fn(Plugins $plugins) : Plugin => $plugins->newPlugin('pl_plugin_2')
        );

        $this->assertCount(3, $plugins->getPlugins());
    }

    public function testAddPluginException() : void
    {
        $this->expectException(PluginsArrayException::class);
        $this->expectExceptionMessage('The closure should return an instance of the class `' . Plugin::class . '`');

        (new Plugins)->addPlugin(
            static fn(Plugins $plugins) => (new Field('user_f_1', 'test value from user_f_1 field'))
        );
    }

    /**
     * @throws \DOMException
     */
    public function testXml() : void
    {
        $plugins = new Plugins;
        $xml     = $plugins->xml();

        $this->assertEquals(53, strlen($plugins->save()));
        $this->assertSame(1, $xml->getElementsByTagName('sb_plugins')->count());
    }
}
