<?php
/**
 * @author add_new_module.sh/0.0.1
 * @since 18-09-09
 */

$basePath = realpath(__DIR__ . '/../../../../');
putenv('SYSTEM_ENVIRONMENT=unittest');
date_default_timezone_set('Europe/Berlin');

//setup autoloader
require_once $basePath . '/../vendor/autoload.php';
