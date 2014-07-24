<?php

defined('SYSPATH') or die('No direct script access.');

// -- Environment setup --------------------------------------------------------
// Composer autoload
require 'vendor/autoload.php';

// Load the core Kohana class
require SYSPATH . 'classes/Kohana/Core' . EXT;

if (is_file(APPPATH . 'classes/Kohana' . EXT))
{
	// Application extends the core
	require APPPATH . 'classes/Kohana' . EXT;
} else
{
	// Load empty core extension
	require SYSPATH . 'classes/Kohana' . EXT;
}

/**
 * Set the default time zone.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/timezones
 */
date_default_timezone_set('Australia/Perth');

/**
 * Set the default locale.
 *
 * @link http://kohanaframework.org/guide/using.configuration
 * @link http://www.php.net/manual/function.setlocale
 */
setlocale(LC_ALL, 'en_US.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @link http://kohanaframework.org/guide/using.autoloading
 * @link http://www.php.net/manual/function.spl-autoload-register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Optionally, you can enable a compatibility auto-loader for use with
 * older modules that have not been updated for PSR-0.
 *
 * It is recommended to not enable this unless absolutely necessary.
 */
//spl_autoload_register(array('Kohana', 'auto_load_lowercase'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @link http://www.php.net/manual/function.spl-autoload-call
 * @link http://www.php.net/manual/var.configuration#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

// -- Configuration and initialization -----------------------------------------

/**
 * Set the default language
 */
I18n::lang('en-us');

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 *
 * Note: If you supply an invalid environment name, a PHP warning will be thrown
 * saying "Couldn't find constant Kohana::<INVALID_ENV_NAME>"
 */
Kohana::$environment = Kohana::PRODUCTION;
if (isset($_SERVER['KOHANA_ENV']))
{
	Kohana::$environment = constant('Kohana::' . strtoupper($_SERVER['KOHANA_ENV']));
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - integer  cache_life  lifetime, in seconds, of items cached              60
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 * - boolean  expose      set the X-Powered-By header                        FALSE
 */
Kohana::init(array(
	'base_url' => '/hierarchive/',
	'cache_dir' => DOCROOT . 'tmp/cache',
	'index_file' => '',
));

/*
 * Try to create log directory.
 */
$log_dir = DOCROOT . 'tmp/logs';
if (!file_exists($log_dir))
{
	// Create directory, after the precedent of Kohana_Core::init();
	mkdir($log_dir, 0755, TRUE);
	chmod($log_dir, 0755);
}
// Attach the file write to logging. Multiple writers are supported.
Kohana::$log->attach(new Log_File($log_dir));
unset($log_dir);

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Config_File);

Cookie::$salt = $cookie_salt;

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth' => MODPATH . 'auth',
	'database' => MODPATH . 'database',
	'storage' => DOCROOT.'/vendor/morgan/kohana-storage',
	'media' => DOCROOT.'/vendor/zeelot/kohana-media',
	'image' => MODPATH . 'image',
));

Route::set('category', 'c<id>(/<action>)', array(
	'id' => '[0-9]+',
	'action' => '(view|edit)',
))->defaults(array(
	'controller' => 'categories',
	'action' => 'view',
));
Route::set('file', '<id>(/<action>)', array(
	'id' => '[0-9]+',
	'action' => '(view|edit)',
))->defaults(array(
	'controller' => 'files',
	'action' => 'view',
));
Route::set('render', '<id>(/<size>)(.<ext>)', array(
	'id' => '[0-9]+',
	'size' => '('.Model_File::SIZE_ICON.'|'.Model_File::SIZE_THUMB.'|'.Model_File::SIZE_SMALL.'|'.Model_File::SIZE_LARGE.'|'.Model_File::SIZE_ORIGINAL.')',
))->defaults(array(
	'controller' => 'files',
	'action' => 'render',
	'ext' => '',
	'size' => 'original',
));
Route::set('default', '(<controller>(/<action>(/<id>)))')
->defaults(array(
	'controller' => 'categories',
	'action' => 'index',
));
