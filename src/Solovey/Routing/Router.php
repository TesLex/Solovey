<?php

namespace Solovey\Routing;

class Router
{

	public static $route = array();
	protected static $gets = array();
	protected static $posts = array();
	protected static $puts = array();
	protected static $deletes = array();
	protected static $anys = array();

	protected static $groups = array();

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

	/**
	 * @param $uri
	 * @return bool|string
	 */
	private static function removeSlashes($uri)
	{
		if (strlen($uri) < 2) {
			return $uri;
		}

		$s = substr($uri, strlen($uri) - 1, strlen($uri));
		$sx = substr($uri, 0, 1);

		if ($s === '/' || $s === '\\') {
			$uri = substr($uri, 0, strlen($uri) - 1);

			$uri = self::removeSlashes($uri);
		} else if ($sx === '/' || $sx === '\\') {
			$uri = substr($uri, 1, strlen($uri));

			$uri = self::removeSlashes($uri);
		}

		return $uri;
	}

	public static function match($uri, $method)
	{
		if ($method == 'GET') {
			return self::check(self::$gets, $uri, $method);
		} elseif ($method == 'POST') {
			return self::check(self::$posts, $uri, $method);
		} elseif ($method == 'PUT') {
			return self::check(self::$puts, $uri, $method);
		} elseif ($method == 'DELETE') {
			return self::check(self::$deletes, $uri, $method);
		} else {
			return self::check(self::$anys, $uri, $method);
		}
	}

	/**
	 * @param $all
	 * @param $uri
	 * @param $method
	 * @return array|bool
	 * @internal param $a
	 */
	public static function check($all, $uri, $method)
	{

		$uri = preg_replace("#([\/]+)#i", '/', self::removeSlashes(strtok($uri, '?')));

		foreach ($all as $route) {
			$c_pattern = self::removeSlashes($route['pattern']);

			$pattern = preg_replace('/{([a-zA-Z0-9]+)}/i', '(.+)', $c_pattern);
			$pattern = preg_replace('/{(.+)\((.+)\)}/i', '(\2)', $pattern);
			$pattern = preg_replace('/{\((.+)\)}/i', '(\1)', $pattern);

			if (preg_match("#^$pattern$#i", $uri, $matches)) {
				$data = [];
				array_shift($matches);
				preg_match_all('/{([a-zA-Z0-9]+)(}|\()/i', $c_pattern, $found);

				foreach ($matches as $k => $match) {
					$data[$found[1][$k]] = $match;
				}

				self::$route = [
						'route' => $route,
						'matches' => $data,
						'query' => $GLOBALS['_' . $method]
				];

				return self::$route;
			}
		}

		return false;
	}
}