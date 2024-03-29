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
- Added method `\Manzadey\SBuilderXmlSoap\Plugins::pushPlugin`;
- Added method `\Manzadey\SBuilderXmlSoap\Category::pushElement`;


### Changes
 - Rename methods: 
- - `\Manzadey\SBuilderXmlSoap\Plugin::xml` to `\Manzadey\SBuilderXmlSoap\Plugin::getDOMElement`;
- - `\Manzadey\SBuilderXmlSoap\Category::xml` to `\Manzadey\SBuilderXmlSoap\Category::getDOMElement`;
- - `\Manzadey\SBuilderXmlSoap\Element::xml` to `\Manzadey\SBuilderXmlSoap\Element::getDOMElement`;
- - `\Manzadey\SBuilderXmlSoap\Field::xml` to `\Manzadey\SBuilderXmlSoap\Field::getDOMElement`;

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.5.2...v1.6.0)

## [1.6.1] - 2023-04-20

### Added
- Added `array $options = null` argument for `\Manzadey\SBuilderXmlSoap\Plugins::upload` method

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.6.0...v1.6.1)

## [1.7.0] - 2023-06-29

### Added
- Added `setUrl()`, `setToken()`, `setOptions()` methods argument for `\Manzadey\SBuilderXmlSoap\Plugins` class

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.6.1...v1.7.0)

## [1.8.0] - 2023-08-29

### Added
- Added `getField()` methods argument for `\Manzadey\SBuilderXmlSoap\Traits\HasField` trait

### Changes
- Update `createDOMDocument()` method from `\Manzadey\SBuilderXmlSoap\Plugins` class.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.7.0...v1.8.0)

## [1.9.0] - 2023-09-25

### Added
- Added `addNewFields(array $array)` methods argument for `\Manzadey\SBuilderXmlSoap\Traits\HasField` trait

### Changes
- Update constructor in `Manzadey\SBuilderXmlSoap\Category` and `Manzadey\SBuilderXmlSoap\Element` classes. Added `array $field = []` argument.

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.8.0...v1.9.0)

## [2.0.0] - 2023-09-25

### Changes
- Update namespace package from `Manzadey\SBuilderXmlSoap` to `Manzadey\SBuilderXmlSoap`

[See all comparing changes](https://github.com/Manzadey/sbuilder-xml-soap/compare/v1.9.0...v2.0.0)