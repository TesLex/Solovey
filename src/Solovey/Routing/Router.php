<?php

namespace Solovey\Routing;

use ReflectionClass;
use function call_user_func_array;
use function in_array;
use function is_callable;
use function preg_match;
use function preg_match_all;

class Router
{

	public static $route = array();
	public static $GETS = array();
	public static $POSTS = array();
	public static $PUTS = array();
	public static $DELETES = array();
	public static $ANYS = array();

	public static $GROUPS = array();

	public static $methods = ['GET', 'POST', 'PUT', 'DELETE', 'ANY'];

	/**
	 * @param $name
	 * @param $pattern
	 * @param $controllers
	 * @param array $middleware | in dev
	 */
	public static function GROUP($name, $pattern, array $controllers, $middleware = [])
	{
		foreach ($controllers as $index => $controller) {
			if (!in_array($index, self::$methods)) {
				self::GET("$name-$index", "$pattern/$index", $controller, $middleware);
			} else {
				foreach ($controller as $indexX => $control) {
					call_user_func_array([Router::class, $index], ["$name-$indexX", "$pattern/$indexX", $control, $middleware]);
				}
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

		self::$GETS[$name] = [
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

		self::$ANYS[$name] = [
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

		self::$POSTS[$name] = [
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

		self::$PUTS[$name] = [
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

		self::$DELETES[$name] = [
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
	public static function check($uri, $method)
	{
		if (in_array($method, self::$methods)) {
			return self::match(self::readVal($method . "S"), $uri, $method);
		} else {
			return self::match(self::$ANYS, $uri, $method);
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
			$m_pattern = preg_replace('/([\/]+)/i', '/', trim(strtok($route['pattern'], '?'), '/'));
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

	private static function readVal($val)
	{
		$c = new ReflectionClass(Router::class);
		return $c->getStaticPropertyValue($val);
	}
}