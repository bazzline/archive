# Status

Since 2020-09-28, this repository is moved to "archived status". Contact me if you are interessted in it.

# Command Line Generator Module for Zend Framework 2

This free as in freedom module should easy up the usage of the [cli readline component](https://github.com/bazzline/php_component_cli_readline) in the [zend framework 2](http://framework.zend.com/) in a zend framework 2 application.
It includes furthermore a command line controller to generate the needed configuration as well as to generate the command line script which enables autocompletion in your zend framework 2 console application.

The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/zf_cli_generator.png?branch=master)](http://travis-ci.org/bazzline/zf_cli_generator)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/zf_cli_generator.svg)](https://packagist.org/packages/net_bazzline/zf_cli_generator)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/zf_cli_generator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/zf_cli_generator/)

The versioneye status is:
[![dependencies](https://www.versioneye.com/user/projects/55a17b956663370013000182/badge.svg?style=flat)](https://www.versioneye.com/user/projects/55a17b956663370013000182)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_cli_generator.svg)](https://packagist.org/packages/net_bazzline/zf_cli_generator)

It is also available at [openhub.net](http://www.openhub.net/p/zf_cli_generator).

Check out the [demo environment](https://github.com/bazzline/zf_demo_environment) if you want to see it in action.

The current change log can be found [here](https://github.com/bazzline/zf_cli_generator/blob/master/CHANGELOG.md).

# Example

```shell
# generate configuration
php public/index.php net_bazzline cli_generator configuration

# generate cli script
php public/index.php net_bazzline cli_generator cli
```

# Install

## By Hand

    mkdir -p vendor/net_bazzline/zf_cli_generator
    @todo
    cd vendor/net_bazzline/zf_cli_generator
    git clone https://github.com/bazzline/zf_cli_generator

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_cli_generator)

    "net_bazzline/zf_cli_generator": "dev-master"

# Usage

* adapt your application.config.php and add “NetBazzlineZfCliGenerator” into the “modules” section

```php
<?php
return array(
    'modules' => array(
        'Application',
        'NetBazzlineZfCliGenerator'
    ),
    //...
```

* use zfcligenerator.global.php.dist as base
* copy this file into your config/autoload directory
* open this file and adapt it to your needs

# API

[API](http://www.bazzline.net/14f1398174a6525e4801cceab6b7800e5485b911/index.html) is available at [bazzline.net](http://www.bazzline.net).

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it. [Donate something](https://gratipay.com/~stevleibelt) if you love it :-].
