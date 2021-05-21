# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

# Zend Framework 2.2 Console Helper Module ([Debian 6 Backport](https://github.com/bazzline/zf_console_helper))

[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/zf_console_helper_debian_6_backport.svg)](https://packagist.org/packages/net_bazzline/zf_console_helper_debian_6_backport)

This is a backport of the [zf console helper](https://github.com/bazzline/zf_console_helper) for [zend framework 2.2](http://framework.zend.com/manual/2.2/en/index.html) (latest version working with debian 6 supported php version).

# Notes

* limit zend framework 2 library to version 2.2.\*
* the public method "\ZfConsoleHelperDebian6Backport\Controller\Console\AbstractConsoleController::getConsole()" is extended to act as a factory method if no console is set
* "\Zend\Console\Console::getInstance()" is called as fallback

The versioneye status is (which is obviously outdated):
[![dependencies](https://www.versioneye.com/user/projects/5443ffba53acfa668400005f/badge.svg?style=flat)](https://www.versioneye.com/user/projects/5443ffba53acfa668400005f)

Downloads:
[![Downloads this Month](https://img.shields.io/packagist/dm/net_bazzline/zf_console_helper_debian_6_backport.svg)](https://packagist.org/packages/net_bazzline/zf_console_helper_debian_6_backport)

It is also available at [openhub.net](http://www.openhub.net/p/719928).

Check out the [demo environment](https://github.com/bazzline/zf_demo_environment/tree/debian_6_backport) if you want to see it in action.

# Useful links

Take a look to the original [readme](https://github.com/bazzline/zf_console_helper/blob/master/README.md).
Take a look to the original [example and usage](https://github.com/bazzline/zf_console_helper#example--usage) section.
Take a look to the original [factory notes](https://github.com/bazzline/zf_console_helper/blob/master/src/ZfConsoleHelper/Controller/Console/AbstractConsoleControllerFactory.php) section.

# Install

## By Hand

    mkdir -p vendor/net_bazzline/zf_console_helper_debian_6_backport
    cd vendor/net_bazzline/zf_console_helper_debian_6_backport
    git clone https://github.com/bazzline/zf_console_helper_debian_6_backport

## With [Packagist](https://packagist.org/packages/net_bazzline/zf_console_helper_debian_6_backport)

    "net_bazzline/zf_console_helper_debian_6_backport": "dev-master"

# API

[API](http://bazzline.net/446645fe05ffa37417502d0af503701961746c9d/index.html) available at [bazzline.net](http://www.bazzline.net/)

# History

* upcomming
    * @todo
* [1.2.0](https://github.com/bazzline/zf_console_helper_debian_6_backport/tree/1.2.0) - released at 01.08.2015
    * moved documentation to [bazzline.net](https://bazzline.net)
    * moved form old namespace "ZfConsoleHelper" to new namespace "ZfConsoleHelperDebian6Backport"
    * removed code duplication by adding 
* [1.1.0](https://github.com/bazzline/zf_console_helper_debian_6_backport/tree/1.1.0) - released at 04.06.2015
    * added [AbstractConsoleControllerFactory](https://github.com/bazzline/zf_console_helper_debian_6_backport/blob/master/src/ZfConsoleHelper/Controller/Console/AbstractConsoleControllerFactory.php)
* [1.0.2](https://github.com/bazzline/zf_console_helper_debian_6_backport/tree/1.0.1) - released at 08.02.2015
    * removed dependecy to apigen
* [1.0.1](https://github.com/bazzline/zf_console_helper_debian_6_backport/tree/1.0.1) - released at 08.02.2015
    * updated dependencies
* [1.0.0](https://github.com/bazzline/zf_console_helper_debian_6_backport/tree/1.0.0) - released at 20.10.2014
    * initial release
