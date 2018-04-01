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

use Solovey\Classes\SError;
use Solovey\Classes\SRError;
use Solovey\Routing\Router;

require "utils.php";

try {

	spl_autoload_register(function ($class) {
		$path = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';

		if (is_file($path)) {
			require_once $path;
		}
	}, true);

// Have access??
	if (startsWith($_SERVER['REQUEST_URI'], '/app/') ||
		startsWith($_SERVER['REQUEST_URI'], '/engine/') ||
		startsWith($_SERVER['REQUEST_URI'], '/pages/') ||
		$_SERVER['REQUEST_URI'] === '/app' ||
		$_SERVER['REQUEST_URI'] === '/engine' ||
		$_SERVER['REQUEST_URI'] === '/pages'
	) {
		header("HTTP/1.1 403 Forbidden");

		return new SError('Forbidden', 'Access denied', 403);
	}

// Load application
	require_once $_SERVER['DOCUMENT_ROOT'] . "/app/start.php";

// Use .htaccess???
	if (startsWith($_SERVER['REQUEST_URI'], '/public') || startsWith($_SERVER['REQUEST_URI'], '/static')) {
		header("Content-type: " . get_mime_type($_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI']));
		readfile($_SERVER['SCRIPT_FILENAME']);

		return false;
	}

// Match route
	$route = Router::match($_SERVER['REQUEST_URI'], GET_METHOD());

	if (!($route)) {
		if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			if (is_file($_SERVER['DOCUMENT_ROOT'] . '/pages/error.php')) {
				return new SRError('NOT FOUND', 'Page not found!', 404);
			} else {
				echo 404;
			}
		} else {
			return new SError('NOT FOUND', 'Page not found!', 404);
		}
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
	return new SError($e->getMessage(), $e->getTraceAsString(), $e->getCode());
}