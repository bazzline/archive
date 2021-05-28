#!/usr/bin/env php
<?php
/**
 * @author create_application.sh/0.0.1
 * @since 18-09-09
 */

//setup autoloader
include __DIR__ . '/../vendor/autoload.php';

//setup and run zend framework application
$configuration = require __DIR__ . '/../config/application.config.php';
Zend\Mvc\Application::init($configuration)->run();
