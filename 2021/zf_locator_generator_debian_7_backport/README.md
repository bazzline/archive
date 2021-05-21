# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

# Locator Generator Component ([Debian 7 Backport](https://github.com/bazzline/zf_locator_generator)) Module for Zend Framework 2.4.*

This free as in freedom module should easy up the usage of the [locator generator component](https://github.com/bazzline/php_component_locator_generator) in the [zend framework 2](http://framework.zend.com/) in a zend framework 2 application.

This is a virtual package working as a backport of the [zf console helper](https://github.com/bazzline/zf_locator_generator) for [zend framework 2.4](http://framework.zend.com/manual/2.4/en/index.html) (latest version working with debian 7 supported php version).

# Backport for Zend Framework 2.2 / Debian 6

There is a [backport](https://github.com/bazzline/zf_locator_generator_debian_6_backport) available for debian 6 and its zend framework 2.2 limiting php version.

# Example

```shell
# generate one locator
php public/index.php net_bazzline locator generate <locator_name>

# generate all available locators
php public/index.php net_bazzline locator generate

# list all available locators
php public/index.php net_bazzline locator list
```

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/zf_locator_generator_debian_7_backport
cd vendor/net_bazzline/zf_locator_generator_debian_7_backport
git clone https://github.com/bazzline/zf_locator_generator_debian_7_backport
```

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_locator_generator_debian_7_backport)

```
"net_bazzline/zf_locator_generator_debian_7_backport": "dev-master"
```

# Usage

* adapt your application.config.php and add “ZfLocatorGenerator” into the “modules” section

```php
<?php
return array(
    'modules' => array(
        'Application',
        'NetBazzlineZfLocatorGenerator'
    ),
//...
```

* use zflocatorgenerator.global.php.dist as base
* copy this file into your config/autoload directory
* open this file and adapt it to your needs
* depending on the locator configuration, add it as invokable or by using a factory to your service manager configuration

# History

* upcomming
    * @todo
* [1.1.3](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.1.3) - released at 18.11.2015
    * updated dependency
* [1.1.2](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.1.2) - released at 13.09.2015
    * updated dependency
* [1.1.1](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.1.1) - released at 29.07.2015
    * added install section into readme
    * added example section into readme
    * added usage section into readme
* [1.1.0](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.1.0) - released at 12.07.2015
    * moved to virtual package
    * updated dependency
* [1.0.2](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.0.0) - released at 07.07.2015
    * updated dependency
* [1.0.1](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.0.0) - released at 04.07.2015
    * fixed broken links
    * removed dead code in unit test
    * updated dependency
* [1.0.0](https://github.com/bazzline/zf_locator_generator_debian_7_backport/tree/1.0.0) - released at 05.06.2015
    * initial release from [zf locator generator version 1.4.0](https://github.com/bazzline/zf_locator_generator/tree/1.4.0)
