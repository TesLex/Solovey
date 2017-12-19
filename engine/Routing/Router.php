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

    public static $route = array();

    public static function GET($name, $pattern, $controller)
    {
        self::$gets[$name] = array(
            'pattern' => $pattern,
            'controller' => $controller
        );
    }

    public static function POST($name, $pattern, $controller)
    {
        self::$posts[$name] = array(
            'pattern' => $pattern,
            'controller' => $controller
        );
    }

    public static function PUT($name, $pattern, $controller)
    {
        self::$puts[$name] = array(
            'pattern' => $pattern,
            'controller' => $controller,
            'method' => 'PUT',
        );
    }

    public static function DELETE($name, $pattern, $controller)
    {
        self::$deletes[$name] = array(
            'pattern' => $pattern,
            'controller' => $controller
        );
    }

    public static function ANY($name, $pattern, $controller)
    {
        self::$anys[$name] = array(
            'pattern' => $pattern,
            'controller' => $controller
        );
    }

    public static function match($uri, $method)
    {
        if ($method == 'GET') {
            return self::m(self::$gets, $uri);
        } elseif ($method == 'POST') {
            return self::m(self::$posts, $uri);
        } elseif ($method == 'PUT') {
            return self::m(self::$puts, $uri);
        } elseif ($method == 'DELETE') {
            return self::m(self::$deletes, $uri);
        } else {
            return self::m(self::$anys, $uri);
        }
    }

    private static function m($a, $uri)
    {
        $uri = strtok($uri, '?');
        foreach ($a as $as) {
            $pattern = $as['pattern'];

            $pattern = preg_replace('/{([a-zA-Z]+)}/i', '(.+)', $pattern);

            if (preg_match("#^$pattern$#i", $uri, $matches)) {
                $route = array(
                    'route' => $as,
                    'matches' => $matches,
                    'query' => $_SERVER['QUERY_STRING']
                );

                return $route;
            }
        }

        return false;
    }

}