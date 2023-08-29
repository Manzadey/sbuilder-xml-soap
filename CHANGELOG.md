# Changelog

All notable changes to `manzadey/sbuilder-xml-soap` will be documented in this file.

## [1.0.0] - 2023-02-13

### Added
 - Release.


## [1.1.0] - 2023-02-13

### Added
- [Add](https://github.com/Manzadey/sbuilder-xml-soap/commit/a339b4d1b6ec4c0b7beb33ab905d49a64783677f) method `when()` for Category And Element class.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.0.0...v1.1.0)

## [1.1.1] - 2023-02-21

### Fixed
- [Fix](https://github.com/Manzadey/sbuilder-xml-soap/commit/cd963662793fb628983059c39f216de056ce5cd7) method `save()` from Plugins classes.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.1.0...v1.1.0)

## [1.2.0] - 2023-02-21

### Changes
- update method `when()`. [Add](https://github.com/Manzadey/sbuilder-xml-soap/commit/b005287a7f7de05af2802268980c933edc7df85e) Closure of false.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.1.0...v1.2.0)

## [1.3.0] - 2023-03-17

### Added
- [Add](https://github.com/Manzadey/sbuilder-xml-soap/commit/ef40542e58bd4e5ca8838d8a0239068bf0e0228a) method `tap()` for Element and Category classes.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.2.0...v1.3.0)

## [1.4.0] - 2023-03-17

### Added
- [Add](https://github.com/Manzadey/sbuilder-xml-soap/commit/d5fae84eec4449003e6312fc82d7794be133c966) method `dd()`.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.3.0...v1.4.0)

## [1.5.0 - 1.5.2] - 2023-03-20

### Added
- [Add](https://github.com/Manzadey/sbuilder-xml-soap/commit/d5fae84eec4449003e6312fc82d7794be133c966) method `dd()`.

### Changes
- Changing the names of methods for creating a DOM element and DOMDocument in classes;
- Set #2 parameter from method `newPlugin()` in Plugins class. Added type `callable`.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.4.0...v1.5.2)

## [1.6.0] - 2023-03-21

### Added
- Added method `\Manzadey\SbuilderXmlSoap\Plugins::pushPlugin`;
- Added method `\Manzadey\SbuilderXmlSoap\Category::pushElement`;


### Changes
 - Rename methods: 
- - `\Manzadey\SbuilderXmlSoap\Plugin::xml` to `\Manzadey\SbuilderXmlSoap\Plugin::getDOMElement`;
- - `\Manzadey\SbuilderXmlSoap\Category::xml` to `\Manzadey\SbuilderXmlSoap\Category::getDOMElement`;
- - `\Manzadey\SbuilderXmlSoap\Element::xml` to `\Manzadey\SbuilderXmlSoap\Element::getDOMElement`;
- - `\Manzadey\SbuilderXmlSoap\Field::xml` to `\Manzadey\SbuilderXmlSoap\Field::getDOMElement`;

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.5.2...v1.6.0)

## [1.6.1] - 2023-04-20

### Added
- Added `array $options = null` argument for `\Manzadey\SbuilderXmlSoap\Plugins::upload` method

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.6.0...v1.6.1)

## [1.7.0] - 2023-06-29

### Added
- Added `setUrl()`, `setToken()`, `setOptions()` methods argument for `\Manzadey\SbuilderXmlSoap\Plugins` class

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.6.1...v1.7.0)

## [1.8.0] - 2023-08-29

### Added
- Added `getField()` methods argument for `\Manzadey\SbuilderXmlSoap\Traits\HasField` trait

### Changes
- Update `createDOMDocument()` method from `\Manzadey\SbuilderXmlSoap\Plugins` class.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.7.0...v1.8.0)