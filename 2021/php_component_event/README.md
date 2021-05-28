# PLEASE NOTE, THIS PROJECT IS NO LONGER BEING MAINTAINED

I still like the idea but there is currently no use case to develop it anymore.

# PHP Event Component

This free as in freedom project aims to deliver a generic, clean and immutable php event component.

The build status of the current master branch is tracked by Travis CI:
[![Latest stable](https://img.shields.io/packagist/v/net_bazzline/php_component_event.svg)](https://packagist.org/packages/net_bazzline/php_component_event)

The scrutinizer status are:
[![code quality](https://scrutinizer-ci.com/g/bazzline/php_component_event/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/bazzline/php_component_event/)

Minimum PHP version is:
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%205.6-8892BF.svg?style=flat-square)](https://php.net/)

Take a look on [openhub.net](https://www.openhub.net/p/php_component_event).

# Install

## By Hand

```
mkdir -p vendor/net_bazzline/php_component_event
cd vendor/net_bazzline/php_component_event
git clone https://github.com/bazzline/php_component_event .
```

## With [Packagist](https://packagist.org/packages/net_bazzline/php_component_event)

```
composer require net_bazzline/php_component_event:dev-master
```

# Benefits

* zero dependencies
* immutable object
    * no propagation support out of the box
    * no intended support for changing the subject
* event contains
    * occurred at
    * name
    * source
    * subject - the event arguments or data (array|Collection)

# Terms

| Name | Description |
| --- | --- |
| occurred at | when did the event happen |
| name | the unique identifier for this event (I prefer human readable names instead of numbers as long as possible and I want to encourage you to do the same) |
| source | a unique identifier to track down the source where the event was created |
| subject | the event arguments or data, an array or an object like a collection |

# Thoughts

* whenever you are dealing with events, it is getting complicated quickly since your event is doing to much or carrying to much responsibility
* you can use `$event->name()` or `$event instanceof MyEvent` to listen only to a specific event
* instead of adding the option to stop the propagation, I would like to encourage you to follow a different way
    * create a generic event which fires your real event only under special circumstances (to move the propagation logic into an event)
    * create and fire an event which rejects your previous changes
* because of the not implemented support for stopping the propagation, we do not need priorities while dispatching (less complexity :-))

# Hints

* extend from `GenericEvent` to add your type hint for the phpdoc block of the `public method source()`
* use or extend the `GenericEventBuilder` to set your well defined event name, sources etc.

# Quotes

```
Using an event is one of the best indicator that your information has to leave the current domain boundraies.
Keep the event simple, the structure of data should be the contract you as emitter and the event listener have agreed on.
```
[source](http://www.php-professional.de/) - @todo

```
I treat an event like a taken statement.
Once articulated, you can not change it since it is emitited and transported by your preferred transmission medium to the receiver.

All you can do is to add explenations or improvments to your statement.
Worst but possible, if you figure out you where wrong, your only chance is to withdraw your statement.
But everything you emit (or say) is another statement (or event).
```
[source](http://www.php-professional.de/) - @todo

```
[...] I characterize the data on a Domain Event as immutable source data that captures what the event is about and mutable processing data that records what the system does in response to it. [...]
```
[source](http://www.martinfowler.com/eaaDev/DomainEvent.html)



# API

[API](https://bazzline.net/322d99c5ae6dc195ec6b2cd78988e264f5944559) is available at [bazzline.net](http://www.bazzline.net).

# History

* upcomming
    * @todo
        * updated some wording here and there
* [0.0.3](https://github.com/bazzline/php_component_event/tree/0.0.3) - released at 2017-01-28
    * updated minimum requirements to php 5.6
* [0.0.2](https://github.com/bazzline/php_component_event/tree/0.0.2) - released at 29.08.2016
    * added `GenericEventBuilder`
    * added type hint `DateTime` in class `GenericEvent`
* [0.0.1](https://github.com/bazzline/php_component_event/tree/0.0.1) - released at 21.08.2016

# links

* http://www.martinfowler.com/eaaDev/EventSourcing.html
* http://www.martinfowler.com/eaaDev/DomainEvent.html
* http://www.martinfowler.com/eaaDev/EventCollaboration.html
* http://www.martinfowler.com/eaaDev/AgreementDispatcher.html
* http://www.martinfowler.com/eaaDev/ParallelModel.html
* http://www.martinfowler.com/eaaDev/RetroactiveEvent.html
* http://www.martinfowler.com/eaaDev/

# Final Words

Star it if you like it :-). Add issues if you need it. Pull patches if you enjoy it. Write a blog entry if use it. Make a [donation](https://gratipay.com/~stevleibelt) if you love it :-].
