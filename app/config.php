<?php
/**
 * | -----------------------------
 * | Created by expexes on 30.11.17/20:56.
 * | Site: teslex.tech
 * | ------------------------------
 * | config.php
 * | Web application configuration file
 * | ---
 */

$ROUTER = array(
	'ignore' => array(
		'/public/',
		'/'
	)
);

$DB = array(
	'driver' => 'pgsql',
	'host' => 'localhost',
	'port' => '5524',
	'password' => ''
);