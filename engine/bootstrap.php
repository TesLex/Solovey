<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/22:59.
 * | Site: teslex.tech
 * | ------------------------------
 * | bootstrap.php
 * | ---
 */

session_start();

use Solovey\Routing\Router;

require "utils.php";

// Load Solovey
spl_autoload_register(function ($class) {
	$path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
	if (is_file($path)) {
		require $path;
	}
});

// Load application
require_all($_SERVER['DOCUMENT_ROOT'] . "/app");

// Match route
$route = Router::match($_SERVER['REQUEST_URI'], GET_METHOD());

if (!($route)) {
	if (is_file($_SERVER['DOCUMENT_ROOT'] . '/pages/404.php')) {
		echo file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/pages/404.php');
	} else {
		echo 404;
	}
} else {
	$matches = $route['matches'];
	$query = $route['query'];

	list($class, $action) = explode(':', $route['route']['controller'], 2);

	if ($matches != null) {
		array_shift($matches);
		call_user_func_array(array(new $class(), $action), $matches);
	} else {
		call_user_func(array(new $class(), $action));
	}
}