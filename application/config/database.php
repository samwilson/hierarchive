<?php
global $db_config;
return array
	(
	'default' => array
		(
		'type' => 'PDO',
		'connection' => array(
			'dsn' => 'mysql:host='.$db_config['hostname'].';dbname='.$db_config['database'],
			'username' => $db_config['username'],
			'password' => $db_config['password'],
			'persistent' => FALSE,
		),
		'table_prefix' => '',
		'charset' => 'utf8',
		'caching' => FALSE,
	)
);