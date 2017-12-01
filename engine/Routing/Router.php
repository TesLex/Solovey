<?php

namespace Routing;

use Classes\System;

class Router
{

	protected static $gets = array();
	protected static $posts = array();
	protected static $puts = array();
	protected static $deletes = array();
	protected static $anys = array();

	public static function get($name, $pattern, $controller)
	{
		self::$gets[$name] = array(
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	public static function post($name, $pattern, $controller)
	{
		self::$posts[$name] = array(
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	public static function put($name, $pattern, $controller)
	{
		self::$puts[$name] = array(
			'pattern' => $pattern,
			'controller' => $controller,
			'method' => 'PUT',
		);
	}

	public static function delete($name, $pattern, $controller)
	{
		self::$deletes[$name] = array(
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	public static function any($name, $pattern, $controller)
	{
		self::$anys[$name] = array(
			'pattern' => $pattern,
			'controller' => $controller
		);
	}

	public static function match($uri)
	{
		foreach (self::$gets as $route) {
			$pattern = $route['pattern'];
			if (preg_match("#$pattern#i", $uri, $matches)) {
				System::debug($route);
				return true;
			}
		}

		return false;

//		if ($R['REQUEST_METHOD'] == 'GET') {
//
//		} elseif ($R['REQUEST_METHOD'] == 'POST') {
//
//		} elseif ($R['REQUEST_METHOD'] == 'PUT') {
//
//		} elseif ($R['REQUEST_METHOD'] == 'DELETE') {
//
//		} elseif ($R['REQUEST_METHOD'] == 'ANY') {
//
//		}
	}

}