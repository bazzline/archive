# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

I still like the idea but there is currently no use case to develop it anymore.

# Readline Component for PHP

This project aims to deliver an easy to use and free as in freedom php compontent for dealing with unix console readline and autocomplete php scripts.


The build status of the current master branch is tracked by Travis CI:
[![Build Status](https://travis-ci.org/bazzline/php_component_cli_readline.png?branch=master)](http://travis-ci.org/bazzline/php_component_cli_readline)
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_cli_readline.svg)](https://packagist.org/packages/net_bazzline/php_component_cli_readline)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/) | [![build status](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/badges/build.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_cli_readline/)

The versioneye status is:
[![Dependency Status](https://www.versioneye.com/user/projects/565b5ecdc34a65000f00000d/badge.svg?style=flat)](https://www.versioneye.com/user/projects/565b5ecdc34a65000f00000d)

Take a look on [openhub.net](https://openhub.net/p/php_component_cli_readline).

The current change log can be found [here](https://github.com/bazzline/php_component_cli_readline/blob/master/CHANGELOG.md).

# Benefits

* autocomplete support
* readline support
* configuration as array
    * set array with possible autocomplete options
    * bind actions to specific autocomplete options
    * supports function, closures and objects as autocomplete target
* easy up php's [readline](https://secure.php.net/manual/en/book.readline.php) implementation as seen [here](https://github.com/stevleibelt/examples/blob/master/php/cli/readline.php)
* works with PHP 5.3 and above

# Usage

* take a look to the [basic example](https://github.com/bazzline/php_component_cli_readline/blob/master/example/basic)

```php
use Net\Bazzline\Component\Cli\Readline\ManagerFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$factory    = new ManagerFactory();
$manager    = $factory->create();
$myClass    = new MyClass();    //assuming a class "MyClass" exists

$manager->setConfiguration(
    array(
        'git' => array(
            'add' => function ($files) {
                if (!is_null($files)) {
                    passthru('/usr/bin/env git add ' . implode(' ', $files));
                }
            },
            'commit' => function ($message) {
                if (is_null($message)) {
                    passthru('/usr/bin/env git commit');
                } else {
                    passthru('/usr/bin/env git commit -m "' . (string) $message . '"');
                }
            }
        ),
        'info' => 'phpinfo',
        'my' => array(
            'function_one' => array($myClass, 'one'),   //assuming MyClass has a method "one"
            'function_two' => array($myClass, 'two')    //assuming MyClass has a method "two"
        )
    )
);
$manager->setPrompt(': ');
$manager->run();
```

The example above would result into the following possible autocompletion cases.

* no word
    * git
    * info
    * my
* first word is git
    * add
    * commit
* first word is my
    * function_one
    * function_two

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_cli_readline
cd vendor/net_bazzline/php_component_cli_readline
git clone https://github.com/bazzline/php_component_cli_readline .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_cli_readline)

```
composer require net_bazzline/php_component_cli_readline:dev-master
```

# API

[API](http://www.bazzline.net/a34444c53af6abb71b3de88f7ee355f13220bf36/index.html) is available at [bazzline.net](http://www.bazzline.net).

# Other Great Components

* [hoa\Readline](https://github.com/hoaproject/Console/blob/master/Readline/Readline.php)
* [php-readline-react](https://github.com/clue/php-readline-react/blob/master/src/Readline.php)

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if you use it :-D.
