<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/22:59.
 * | Site: teslex.tech
 * | ------------------------------
 * | bootstrap.php
 * | ---
 */

use Routing\Router;

ini_set('display_errors', 'on');
error_reporting(E_ALL);

spl_autoload_register(function ($class) {
	$path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

	if (is_file($path)) {
		require $path;
	}
});


// Include custom routes
include $_SERVER['DOCUMENT_ROOT'] . '/app/router.php';

// Match route
$route = Router::match($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);

if (!($route)) {
	echo "404";
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