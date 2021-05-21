# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

# Locator Generator Component  ([Debian 6 Backport](https://github.com/bazzline/zf_locator_generator)) Module for Zend Framework 2.2

This repository is marked as "orphaned" and will be no longer maintained.

This module should easy up the usage of the [locator generator component](https://github.com/bazzline/php_component_locator_generator) in the [zend framework 2](http://framework.zend.com/) in a zend framework 2 application.

This is a backport of the [zf console helper](https://github.com/bazzline/zf_locator_generator) for [zend framework 2.2](http://framework.zend.com/manual/2.2/en/index.html) (latest version working with debian 6 supported php version).

It is based on the [skeleton zf2 module](https://github.com/zendframework/ZendSkeletonModule) and [phly_contact](https://github.com/weierophinney/phly_contact).
Thanks also to the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/zf_locator_generator_debian_6_backport.png?branch=master)](http://travis-ci.org/bazzline/zf_locator_generator_debian_6_backport)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/zf_locator_generator_debian_6_backport.svg)](https://packagist.org/packages/net_bazzline/zf_locator_generator_debian_6_backport)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator_debian_6_backport/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator_debian_6_backport/) | [![build status](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator_debian_6_backport/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_locator_generator_debian_6_backport/)

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/54456d2ce5a8f016a2000007/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54456d2ce5a8f016a2000007)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_locator_generator_debian_6_backport.svg)](https://packagist.org/packages/net_bazzline/zf_locator_generator_debian_6_backport)

It is also available at [openhub.net](http://www.openhub.net/p/719929).

Check out the [demo environment](https://github.com/bazzline/zf_demo_environment/tree/debian_6_backport) if you want to see it in action.


# Backport for Zend Framework 2.4 / Debian 7

There is a [backport](https://github.com/bazzline/zf_locator_generator_debian_7_backport) available for debian 7 and its zend framework 2.4 limiting php version.


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

    mkdir -p vendor/net_bazzline/zf_locator_generator_debian_6_backport
    cd vendor/net_bazzline/zf_locator_generator_debian_6_backport
    git clone https://github.com/bazzline/zf_locator_generator_debian_6_backport

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_locator_generator_debian_6_backport)

    "net_bazzline/zf_locator_generator_debian_6_backport": "dev-master"

# Usage

* adapt your application.config.php and add “ZfLocatorGenerator” into the “modules” section

```php
<?php
return array(
    'modules' => array(
        'Application',
        'ZfLocatorGenerator'
    ),
    //...
```

* use zflocatorgenerator.global.php.dist as base
* copy this file into your config/autoload directory
* open this file and adapt it to your needs
* depending on the locator configuration, add it as invokable or by using a factory to your service manager configuration

# API

[API](http://bazzline.net/30839c871671cee9d6a3b221adabdf4375181c7e/index.html) available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
    * removed tests to run it only on php 5.3 and 5.3.3
* [1.3.3](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.3.3) - released at 13.09.2015
    * updated dependency
* [1.3.2](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.3.2) - released at 07.07.2015
    * updated dependency
* [1.3.1](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.3.1) - released at 04.07.2015
    * moved documentation to [bazzline.net](http://www.bazzline.net)
    * updated dependency
* [1.3.0](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.3.0) - released at 05.06.2015
    * implemented usage of the [IndexControllerFactory](https://github.com/bazzline/zf_locator_generator_debian_76backport/blob/master/src/ZfLocatorGenerator/Controller/Console/IndexControllerFactory.php)
    * removed not working code coverage
    * updated dependencies ([locator generator version 2.0.0](https://github.com/bazzline/php_component_locator_generator))
    * removed document section
    * updated dependencies
* [1.2.2](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.2.1) - released at 08.02.2015
    * updated dependencies
* [1.2.1](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.2.1) - released at 08.02.2015
    * removed dependency from apigen
* [1.2.0](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.2.0) - released at 08.02.2015
    * added factory for controller creation
    * added migration
    * update dependencies
* [1.1.0](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.1.0) - released at 22.12.2014
    * updated php_component_locator_generator to version 1.3.0
* [1.0.0](https://github.com/bazzline/zf_locator_generator_debian_6_backport/tree/1.0.0) - released at 20.10.2014
    * initial release

