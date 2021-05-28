# Status

Since 2020-09-28, this repository is moved to "archived status". Contact me if you are interessted in it.

# Zend Framework Kickstarter

The current change log can be found [here](CHANGELOG.md).

Smaller than the [skeleton application](https://github.com/zendframework/ZendSkeletonApplication).

With this script you can setup a zend framework application that comes with:
* configured and ready to use file logger (data/log/application.log), available via $container->get(\Zend\Log\Logger::class)
* ready to use command line and http router
* script to setup a new module in almost no time (bin/add_new_module.sh)

You can execute the script "create_application.sh" multiple times, even on already created applications.

## Example

```
#create the application
./create_application.sh /tmp/net_bazzline_kickstarter
#show me what you have done
if [[ -f /usr/bin/tree ]];
then
    tree /tmp/net_bazzline_kickstarter
else
    #output, output everywhere
    ls -R /tmp/net_bazzline_kickstarter
fi
```
