# SBuilder XML SOAP generator

Пакет представляет из себя простое API для генерации и выгрузки данных в формате XML в CMS SBuilder.

## Пример:
```xml
<?xml version="1.0" encoding="utf-8"?>
<sb_plugins>
    <sb_plugin p_id="pl_plugin_14">
        <sb_cat c_id="1400" c_ext_id="" c_p_id="">
            <sb_field name="cat_title">Раздел 1</sb_field>
            <sb_field name="user_f_17">Наполнение для поля user_f_17</sb_field>
            <sb_field name="user_f_19">Наполнение для поля user_f_19</sb_field>
            <sb_elem e_id="" e_ext_id="">
                <sb_field name="p_title">Элемент 1</sb_field>
                <sb_field name="p_price1">10000</sb_field>
                <sb_field name="p_active">1</sb_field>
                <sb_field name="user_f_18">Наполнение для поля user_f_18</sb_field>
                <sb_field ext_id="true" name="user_f_4">4</sb_field>
            </sb_elem>
            <sb_cat c_id="" c_ext_id="" c_p_id="">
                <sb_field name="cat_title">Подраздел раздела 1</sb_field>
                <sb_field name="user_f_17">Наполнение для поля user_f_17</sb_field>
                <sb_field name="user_f_19">Наполнение для поля user_f_19</sb_field>
                <sb_elem e_id="" e_ext_id="">
                    <sb_field name="p_title">Элемент 2</sb_field>
                    <sb_field name="p_price1">20000</sb_field>
                    <sb_field name="p_active">1</sb_field>
                    <sb_field name="user_f_18">Наполнение для поля user_f_18</sb_field>
                    <sb_field ext_id="true" name="user_f_4">5</sb_field>
                </sb_elem>
            </sb_cat>
        </sb_cat>
    </sb_plugin>
    <sb_plugin p_id="pl_sprav">
        <sb_cat c_id="" c_ext_id="" c_p_id="">
            <sb_field name="cat_title">Цвета</sb_field>
            <sb_field name="show_prop1">1</sb_field>
            <sb_field name="show_prop2">0</sb_field>
            <sb_field name="show_prop3">0</sb_field>
            <sb_elem e_id="" e_ext_id="4">
                <sb_field name="p_title">Красный</sb_field>
                <sb_field name="s_prop_1">red</sb_field>
            </sb_elem>
            <sb_elem e_id="" e_ext_id="5">
                <sb_field name="p_title">Зеленый</sb_field>
                <sb_field name="s_prop_1">green</sb_field>
            </sb_elem>
        </sb_cat>
    </sb_plugin>
</sb_plugins>
```

```php
use Manzadey\SbuilderXmlSoap\Category;
use Manzadey\SbuilderXmlSoap\Element;
use Manzadey\SbuilderXmlSoap\Field;
use Manzadey\SbuilderXmlSoap\Plugin;
use Manzadey\SbuilderXmlSoap\Plugins;
use Manzadey\SbuilderXmlSoap\Sprav;


$plugins = new Plugins;

$plugins->addNewPlugin(14, static function(Plugin $plugin) {
        return $plugin->addNewCategory(static function(Category $category) {
            return $category
                ->setId(1400)
                ->addColumnTitle('Раздел 1')
                ->addColumnUserF(17, 'Наполнение для поля user_f_17')
                ->addColumnUserF(19, 'Наполнение для поля user_f_19')
                ->addNewElement(static function(Element $element) {
                    return $element
                        ->addColumnTitle('Элемент 1')
                        ->addColumnField('p_price1', 10000)
                        ->addColumnActive(1)
                        ->addColumnUserF(18, 'Наполнение для поля user_f_18')
                        ->addNewField(4, static function(Field $field) {
                            return $field->isExtId()->userF(4);
                        });
                })->addNewCategory(static function(Category $category) {
                    return $category
                        ->addColumnTitle('Подраздел раздела 1')
                        ->addColumnUserF(17, 'Наполнение для поля user_f_17')
                        ->addColumnUserF(19, 'Наполнение для поля user_f_19')
                        ->addNewElement(static function(Element $element) {
                            return $element
                                ->addColumnTitle('Элемент 2')
                                ->addColumnField('p_price1', 20000)
                                ->addColumnActive(1)
                                ->addColumnUserF(18, 'Наполнение для поля user_f_18')
                                ->addNewField(5, static function(Field $field) {
                                    return $field->isExtId()->name(4);
                                });
                        });
                });
        });
    })->addNewSprav(static function(Sprav $sprav) {
        return $sprav->addNewCategory(static function(Category $category) {
            return $category
                ->addColumnTitle('Цвета')
                ->addColumnField('show_prop1', 1)
                ->addColumnField('show_prop2', 0)
                ->addColumnField('show_prop3', 0)
                ->addNewElement(static function(Element $element) {
                    return $element
                        ->addColumnTitle('Красный')
                        ->addColumnField('s_prop_1', 'red')
                        ->addColumnField('s_ext_id', 4);
                })->addNewElement(static function(Element $element) {
                    return $element
                        ->addColumnTitle('Зеленый')
                        ->addColumnField('s_prop_1', 'green')
                        ->addColumnField('s_ext_id', 4);
                });
        });
    });

echo $plugins->save(); // XML
```

Выгрузка в WSDL:
```php
use Manzadey\SbuilderXmlSoap\Plugins;

$plugins = new Plugins;

// code..

$plugins->upload('https://test.ru/cms/admin/soap.php?wsdl', '9c06c094a959dedbe84e52a95b7ebfbe'); // \Manzadey\SbuilderXmlSoap\Result


```
