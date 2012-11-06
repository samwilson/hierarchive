<?php

return array
	(
	'default' => array
		(
		'type' => 'MySQL',
		'connection' => array(
			'hostname' => DB_HOST,
			'database' => DB_NAME,
			'username' => DB_USER,
			'password' => DB_PASS,
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset' => 'utf8',
		'caching' => FALSE,
	)
);