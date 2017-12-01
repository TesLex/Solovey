<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:01.
 * | Site: teslex.tech
 * | ------------------------------
 * | Utils.php
 * | ---
 */

function stopAndRedirect($url)
{
	header('Location: ' . $url);

	$content = sprintf(
		'<!DOCTYPE html><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><meta http-equiv="refresh" content="1;url=%1$s" /><title>Redirecting to %1$s</title></head><body>Redirecting to <a href="%1$s">%1$s</a>.</body></html>',
		htmlspecialchars($url, ENT_QUOTES, 'UTF-8')
	);

	echo $content;

	exit;
}


function _GET($key)
{
	return isset($_GET[$key]) ? $_GET[$key] : null;
}

function _POST($key)
{
	return isset($_POST[$key]) ? $_POST[$key] : null;
}

function IS_POST()
{
	return $_SERVER['REQUEST_METHOD'] == 'POST';
}

function GET_METHOD()
{
	$method =  $_SERVER['REQUEST_METHOD'];

	if(IS_POST()){
		if(isset($_SERVER['X-HTTP-METHOD-OVERRIDE'])){
			$method = strtoupper($_SERVER['X-HTTP-METHOD-OVERRIDE']);
		}
	}

	return $method;
}

function _e($str)
{
	return htmlspecialchars($str, ENT_QUOTES, 'UTF-8');
}

function _d($str, $default)
{
	return $str ? _e($str) : _e($default);
}

function dd($value)
{
	var_dump($value);
	die();
}

function IS_HTTPS()
{
	return isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
}

function GET_HTTP_HOST()
{
	$host = IS_HTTPS() ? 'https://' : 'http://';
	$host .= GET_HOST();
	return $host;
}

function GET_HOST()
{
	$host = $_SERVER['HTTP_HOST'];

	$host = strtolower(preg_replace('/:\d+$/', '', trim($host)));

	if ($host && !preg_match('/^\[?(?:[a-zA-Z0-9-:\]_]+\.?)+$/', $host)) {
		throw new \UnexpectedValueException(sprintf('Invalid Host "%s"', $host));
	}

	return $host;
}

function GET_PATH_INFO($baseUrl = null)
{
	static $pathInfo;

	if (!$pathInfo) {
		$pathInfo = $_SERVER['REQUEST_URI'];

		if (!$pathInfo) {
			$pathInfo = '/';
		}

		$schemeAndHttpHost = IS_HTTPS() ? 'https://' : 'http://';
		$schemeAndHttpHost .= $_SERVER['HTTP_HOST'];

		if (strpos($pathInfo, $schemeAndHttpHost) === 0) {
			$pathInfo = substr($pathInfo, strlen($schemeAndHttpHost));
		}

		if ($pos = strpos($pathInfo, '?')) {
			$pathInfo = substr($pathInfo, 0, $pos);
		}

		if (null != $baseUrl) {
			$pathInfo = substr($pathInfo, strlen($pathInfo));
		}

		if (!$pathInfo) {
			$pathInfo = '/';
		}
	}

	return $pathInfo;
}