<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/22:59.
 * | Site: teslex.tech
 * | ------------------------------
 * | bootstrap.php
 * | ---
 */

ini_set('display_errors', 'on');
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
	$path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

	if (is_file($path)) {
		require $path;
		return;
	}

	throw new \LogicException(sprintf('Class "%s" not found in "%s"', $class, $path));
});

include $_SERVER['DOCUMENT_ROOT'] . '/app/router.php';