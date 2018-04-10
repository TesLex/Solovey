<?php

namespace Solovey\Routing;

use function preg_match;
use function preg_match_all;

class Router
{

	public static $route = array();
	protected static $gets = array();
	protected static $posts = array();
	protected static $puts = array();
	protected static $deletes = array();
	protected static $anys = array();

	protected static $groups = array();


	/**
	 * @param $name
	 * @param $pattern
	 * @param $controllers
	 * @param array $middleware | in dev
	 */
	public static function GROUP($name, $pattern, $controllers, $middleware = [])
	{
		foreach ($controllers as $method => $controller) {
			if ($method = 0)
				$method = 'GET';

			$c_name = $name . '_' . $controller[0];
			$c_pattern = $pattern . $controller[1];
			$c_controller = $controller[2];
			$c_mid = $controller[3];

			if ($method == 'GET') {
				self::GET($c_name, $c_pattern, $c_controller, $c_mid);
			} elseif ($method == 'POST') {
				self::POST($c_name, $c_pattern, $c_controller, $c_mid);
			} elseif ($method == 'PUT') {
				self::PUT($c_name, $c_pattern, $c_controller, $c_mid);
			} elseif ($method == 'DELETE') {
				self::DELETE($c_name, $c_pattern, $c_controller, $c_mid);
			} else {
				self::ANY($c_name, $c_pattern, $c_controller, $c_mid);;
			}
		}
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param array $controller
	 * @param array|null $middleware
	 */
	public static function GET($name, $pattern, $controller = [], $middleware = [])
	{
		$action = 'index';
		$controllerX = $controller;

		if (!is_callable($controller)) {
			$controllerX = isset($controller['class']) ? $controller['class'] : $controller[0];
			$action = isset($controller['action']) ? $controller['action'] : isset($controller[1]) ? $controller[1] : 'index';
		}

		self::$gets[$name] = [
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controllerX,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param array $controller
	 * @param array|null $middleware
	 */
	public static function POST($name, $pattern, $controller = [], $middleware = [])
	{
		$action = 'index';
		$controllerX = $controller;

		if (!is_callable($controller)) {
			$controllerX = isset($controller['class']) ? $controller['class'] : $controller[0];
			$action = isset($controller['action']) ? $controller['action'] : isset($controller[1]) ? $controller[1] : 'index';
		}

		self::$posts[$name] = [
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controllerX,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param array $controller
	 * @param array|null $middleware
	 */
	public static function PUT($name, $pattern, $controller = [], $middleware = [])
	{
		$action = 'index';
		$controllerX = $controller;

		if (!is_callable($controller)) {
			$controllerX = isset($controller['class']) ? $controller['class'] : $controller[0];
			$action = isset($controller['action']) ? $controller['action'] : isset($controller[1]) ? $controller[1] : 'index';
		}

		self::$puts[$name] = [
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controllerX,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param array $controller
	 * @param array|null $middleware
	 */
	public static function DELETE($name, $pattern, $controller = [], $middleware = [])
	{
		$action = 'index';
		$controllerX = $controller;

		if (!is_callable($controller)) {
			$controllerX = isset($controller['class']) ? $controller['class'] : $controller[0];
			$action = isset($controller['action']) ? $controller['action'] : isset($controller[1]) ? $controller[1] : 'index';
		}

		self::$deletes[$name] = [
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controllerX,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param array $controller
	 * @param array|null $middleware
	 */
	public static function ANY($name, $pattern, $controller = [], $middleware = [])
	{
		self::GET($name, $pattern, $controller, $middleware);
		self::POST($name, $pattern, $controller, $middleware);
		self::PUT($name, $pattern, $controller, $middleware);
		self::DELETE($name, $pattern, $controller, $middleware);

		/* TODO: доробити це по-людськи */

		$action = 'index';
		$controllerX = $controller;

		if (!is_callable($controller)) {
			$controllerX = isset($controller['class']) ? $controller['class'] : $controller[0];
			$action = isset($controller['action']) ? $controller['action'] : isset($controller[1]) ? $controller[1] : 'index';
		}

		self::$anys[$name] = [
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controllerX,
			'action' => $action,
			'middleware' => $middleware
		];
	}

	public static function check($uri, $method)
	{
		if ($method == 'GET') {
			return self::match(self::$gets, $uri, $method);
		} elseif ($method == 'POST') {
			return self::match(self::$posts, $uri, $method);
		} elseif ($method == 'PUT') {
			return self::match(self::$puts, $uri, $method);
		} elseif ($method == 'DELETE') {
			return self::match(self::$deletes, $uri, $method);
		} else {
			return self::match(self::$anys, $uri, $method);
		}
	}

	/**
	 * @param array $routes
	 * @param $uri
	 * @param $method
	 * @return array|bool
	 */
	public static function match(array $routes, $uri, $method)
	{

		$uri = preg_replace('/([\/]+)/i', '/', trim(strtok($uri, '?'), '/'));

		$s_uri = explode("/", $uri);
		if (sizeof($s_uri) === 1 && $s_uri[0] === "")
			unset($s_uri[0]);

		foreach ($routes as $route) {
			$m_pattern = trim($route['pattern'], '/');
			$pattern = preg_replace('/{([a-zA-Z0-9]+)}/i', '(\w+)', $m_pattern);
			$pattern = preg_replace('/{([a-zA-Z0-9]+):(\(.+\))}/i', '\2', $pattern);
			$pattern = preg_replace('/{(\(.+\))}/i', '\1', $pattern);

			$s_pattern = explode("/", $pattern);

			if (sizeof($s_pattern) === 1 && $s_pattern[0] === "")
				unset($s_pattern[0]);

			if (sizeof($s_uri) === sizeof($s_pattern)) {
				$data = [];

				$is_good = true;

				for ($i = 0; $i < sizeof($s_uri); $i++) {
					if (preg_match("/^{$s_pattern[$i]}$/i", $s_uri[$i], $match)) {
						if (preg_match_all("/([!\(.+\)]|[!\[.+\]])/i", $s_pattern[$i]) && isset($match[0]))
							array_push($data, $match[0]);
					} else {
						$is_good = false;
						break;
					}
				}

				if ($is_good) {
					self::$route = [
						'route' => $route,
						'matches' => $data,
						'query' => $GLOBALS['_' . $method]
					];

					return self::$route;
				}
			}
		}

		return false;

	}
}