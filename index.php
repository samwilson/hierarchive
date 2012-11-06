<?php

/**
 * Try to load the config file.
 * 
 * @see README.md
 */
$config_filename = 'config.php';
if (!file_exists($config_filename))
{
	$msg = "Unable to load configuration from $config_filename";
	trigger_error($msg, E_USER_ERROR);
	exit();
}
require_once('config.php');

/**
 * The default extension of resource files. If you change this, all resources
 * must be renamed to use the new extension.
 *
 * @link http://kohanaframework.org/guide/about.install#ext
 */
define('EXT', '.php');

error_reporting(E_ALL | E_STRICT);

// Set the full path to the docroot
define('DOCROOT', realpath(dirname(__FILE__)) . DIRECTORY_SEPARATOR);
// Define the absolute paths for configured directories
define('APPPATH', realpath('application') . DIRECTORY_SEPARATOR);
define('MODPATH', realpath('vendor/modules') . DIRECTORY_SEPARATOR);
define('SYSPATH', realpath('vendor/system') . DIRECTORY_SEPARATOR);
$skindir = "skins/$skin";
if (!file_exists($skindir))
{
	trigger_error("Unable to find skin '$skin'.", E_USER_ERROR);
	exit();
}
define('SKINPATH', realpath($skindir) . DIRECTORY_SEPARATOR);

/**
 * Define the start time of the application, used for profiling.
 */
if (!defined('KOHANA_START_TIME'))
{
	define('KOHANA_START_TIME', microtime(TRUE));
}

/**
 * Define the memory usage at the start of the application, used for profiling.
 */
if (!defined('KOHANA_START_MEMORY'))
{
	define('KOHANA_START_MEMORY', memory_get_usage());
}

// Bootstrap the application
require APPPATH . 'bootstrap' . EXT;

/**
 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
 * If no source is specified, the URI will be automatically detected.
 */
echo Request::factory(TRUE, array(), FALSE)
		->execute()
		->send_headers(TRUE)
		->body();

