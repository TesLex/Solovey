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
	 * @param $method
	 * @return array|bool
	 */
	public static function match($uri, $method)
	{
		if ($method == 'GET') {
			return self::m(self::$gets, $uri, $method);
		} elseif ($method == 'POST') {
			return self::m(self::$posts, $uri, $method);
		} elseif ($method == 'PUT') {
			return self::m(self::$puts, $uri, $method);
		} elseif ($method == 'DELETE') {
			return self::m(self::$deletes, $uri, $method);
		} else {
			return self::m(self::$anys, $uri, $method);
		}
	}

	/**
	 * @param $a
	 * @param $uri
	 * @param $method
	 * @return array|bool
	 */
	private static function m($a, $uri, $method)
	{
		$uri = strtok($uri, '?');
		$uri = self::removeSlashes($uri);

		foreach ($a as $as) {
			$main_pattern = self::removeSlashes($as['pattern']);

			$pattern = preg_replace('/{([a-zA-Z0-9]+)}/i', '(.+)', $main_pattern);

			$pattern = preg_replace('/{(.+)\((.+)\)}/i', '(\2)', $pattern);

			if (preg_match("#^$pattern$#i", $uri, $matches)) {

				$matches_normal = [];

				array_shift($matches);

				preg_match_all('/{(.+)}/i', $main_pattern, $found);

				foreach ($matches as $k => $match) {
					$matches_normal[$found[1][$k]] = $match;
				}

				self::$route = array(
					'route' => $as,
					'matches' => $matches_normal,
					'query' => $GLOBALS['_' . $method]
				);

				return self::$route;
			}
		}

		return false;
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
}