# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

I still like the idea but there is currently no use case to develop it anymore.

# Zend Expressive Adapter For The Bazzline Template Engine for PHP

Provides [bazzline's template engine](https://github.com/bazzline/php_component_template) integration for [Expressive](https://github.com/zendframework/zend-expressive).


## Installation

Install this library using composer:

```bash
$ composer require net_bazzline/php_zend_expressive_template_adapter
```
We recommend using a dependency injection container, and typehint against
[container-interop](https://github.com/container-interop/container-interop). We
can recommend the following implementations:

- [zend-servicemanager](https://github.com/zendframework/zend-servicemanager):
  `composer require zendframework/zend-servicemanager`
- [pimple-interop](https://github.com/moufmouf/pimple-interop):
  `composer require mouf/pimple-interop`
- [Aura.Di](https://github.com/auraphp/Aura.Di)

## Configuration

```php
'templates' => [
    'paths' => [
        // namespace / path pairs
        //
        // Numeric namespaces imply the default/main namespace. Paths may be
        // strings or arrays of string paths to associate with the namespace.
    ],
],
```

## Factories

You can choose between two factories.
It depends on the template you want to use, the [FileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/FileBasedTemplate.php) or the [ComplexFileBasedTemplate](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/ComplexFileBasedTemplate.php).

## Documentation

See the [zend-expressive](https://github.com/zendframework/zend-expressive/blob/master/doc/book)
documentation tree, or browse online at http://zend-expressive.rtfd.org.


# History

* upcomming
    * @todo
        * add [CallableComplexFileBasedTemplateManager](https://github.com/bazzline/php_component_template/blob/master/source/Net/Bazzline/Component/Template/CallableComplexFileBasedTemplateManager.php) support
        * add unit tests
* [0.1.1](https://github.com/bazzline/php_zend_expressive_template_adapter/tree/0.1.0) - released at 19.08.2016
    * updated development dependency
* [0.1.0](https://github.com/bazzline/php_zend_expressive_template_adapter/tree/0.1.0) - released at 07.02.2016
    * initial plumber release 

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if use it. Make a [donation](https://gratipay.com/~stevleibelt) if you love it :-].
