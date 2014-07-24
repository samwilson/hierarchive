<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'public_dir' => DOCROOT.'media/<uid>/kohana/<filepath>',
	'cache'      => Kohana::$environment === Kohana::PRODUCTION,
	'uid'        => Hierarchive::$version,
);
