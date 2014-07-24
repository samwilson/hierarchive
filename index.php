<?php
/**
 * This file is part of Hierarchive.
 * 
 * Hierarchive is free software: you can redistribute it and/or modify it under the terms of the GNU General Public
 * License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later
 * version.
 * 
 * Hierarchive is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied
 * warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU General Public License for more\
 * details.
 * 
 * You should have received a copy of the GNU General Public License along with Hierarchive.  If not,
 * see <http://www.gnu.org/licenses/>.
 */

/**
 * Try to load the config file.
 * 
 * @see README.md
 */
$config_filename = 'config.php';
if ( ! file_exists($config_filename))
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
define('MODPATH', realpath('modules') . DIRECTORY_SEPARATOR);
define('SYSPATH', realpath('vendor/kohana/core') . DIRECTORY_SEPARATOR);
//$skindir = "skins/".Hierarchive::$skin."/html";
//if (!file_exists($skindir))
//{
//	trigger_error("Unable to find skin '".Hierarchive::$skin."'.", E_USER_ERROR);
//	exit();
//}
//define('SKINPATH', realpath($skindir) . DIRECTORY_SEPARATOR);

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

if (PHP_SAPI == 'cli')
{
	/**
	 * Include the Unit Test module and leave the rest to PHPunit.
	 */
	if (substr(basename($_SERVER['PHP_SELF']), 0, 7) == 'phpunit')
	{
		// Disable output buffering
		if (($ob_len = ob_get_length()) !== FALSE)
		{
			// flush_end on an empty buffer causes headers to be sent. Only flush if needed.
			if ($ob_len > 0) ob_end_flush();
			else ob_end_clean();
		}
		Kohana::modules(Kohana::modules() + array('unittest' => MODPATH.'unittest'));
		return; // Execution will be continued by phpunit
	}

	/*
	 * Execute minion if this is a command line request.
	 */
	set_exception_handler(array('Minion_Exception', 'handler'));
	Minion_Task::factory(Minion_CLI::options())->execute();
} else
{
	/**
	 * Otherwise, execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::factory(TRUE, array(), FALSE)
		->execute()
		->send_headers(TRUE)
		->body();
}

