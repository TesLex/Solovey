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
	 * @param $controller
	 */
	public static function GET($name, $pattern, $controller)
	{
		self::$gets[$name] = array(
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param $controller
	 */
	public static function POST($name, $pattern, $controller)
	{
		self::$posts[$name] = array(
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param $controller
	 */
	public static function PUT($name, $pattern, $controller)
	{
		self::$puts[$name] = array(
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param $controller
	 */
	public static function DELETE($name, $pattern, $controller)
	{
		self::$deletes[$name] = array(
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	/**
	 * @param $name
	 * @param $pattern
	 * @param $controller
	 */
	public static function ANY($name, $pattern, $controller)
	{
		self::$anys[$name] = array(
			'name' => $name,
			'pattern' => $pattern,
			'controller' => $controller
		);
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
			$pattern = $as['pattern'];

			$pattern = preg_replace('/{([a-zA-Z0-9]+)}/i', '(.+)', $pattern);

			$pattern = preg_replace('/{([a-zA-Z0-9]+)\((.+)\)}/i', '(\2)', $pattern);

			if (preg_match("#^$pattern$#i", $uri, $matches)) {
				foreach ($matches as $k => $match)
					if (substr($match, strlen($match) - 1, strlen($match)) === '/')
						$matches[$k] = substr($match, 0, strlen($match) - 1);

				self::$route = array(
					'route' => $as,
					'matches' => $matches,
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

		if ($s === '/' || $s === '\\') {
			$uri = substr($uri, 0, strlen($uri) - 1);

			self::removeSlashes($uri);
		}

		return $uri;
	}

}