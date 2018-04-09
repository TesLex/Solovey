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

use Solovey\Exception\RouteException;
use Solovey\Routing\Router;
use Solovey\Solovey;

try {

	// Have access??
	if (startsWith($_SERVER['REQUEST_URI'], '/app/') ||
		startsWith($_SERVER['REQUEST_URI'], '/engine/') ||
		startsWith($_SERVER['REQUEST_URI'], '/pages/') ||
		$_SERVER['REQUEST_URI'] === '/app' ||
		$_SERVER['REQUEST_URI'] === '/engine' ||
		$_SERVER['REQUEST_URI'] === '/pages'
	) {
		throw new Exception('Access denied', 403);
	}

	// Default root route
	Router::GET('root', '/', function () {
		phpinfo();
	});

	// Load application
	require_once $_SERVER['DOCUMENT_ROOT'] . "/app/start.php";

	// Load static content
	if (startsWith($_SERVER['REQUEST_URI'], '/static/')) {
		header("Content-type: " . getMimeType($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']));
		readfile($_SERVER['SCRIPT_FILENAME']);

		return false;
	}

	// Match route
	$route = Router::check($_SERVER['REQUEST_URI'], GET_METHOD());

	if (!($route)) {
		throw new RouteException('Not Found', 404);
	} else {
		$matches = $route['matches'];
		$query = $route['query'];

		$controller = $route['route']['controller'];

		$action = $route['route']['action'];
		$middlewareList = $route['route']['middleware'];

		if (sizeof($route['route']['middleware']) > 0)
			foreach ($middlewareList as $middleware)
				call_user_func(array(new $middleware(), 'index'));

		if ($matches != null) {
			is_callable($controller) ? call_user_func_array($controller, $matches) : call_user_func_array(array(new $controller(), $action), $matches);
		} else {
			if (is_callable($controller))
				call_user_func($controller);
			else
				call_user_func(array(new $controller(), $action));
		}
	}
} catch (Exception $e) {
	$func = Solovey::$catchClojure;
	if (is_null($func)) {
		error($e->getMessage(), $e->getCode());
	} else {
		call_user_func_array($func, [$e->getMessage(), $e->getCode()]);
	}
}