<?php

return array
	(
	'default' => array
		(
		'type' => 'MySQL',
		'connection' => array(
			'hostname' => Hierarchive::$db_hostname,
			'database' => Hierarchive::$db_database,
			'username' => Hierarchive::$db_username,
			'password' => Hierarchive::$db_password,
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset' => 'utf8',
		'caching' => FALSE,
	)
);