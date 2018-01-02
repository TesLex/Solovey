<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:05.
 * | Site: teslex.tech
 * | ------------------------------
 * | Controller.phpp
 * | ---
 */

namespace Solovey\Routing;

use http\Exception;

abstract class Controller
{
	/**
	 * @param $template
	 * @param array $vars
	 * @throws \Exception
	 */
	protected function render($template, array $vars = array())
	{
		$root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'pages' . DIRECTORY_SEPARATOR;

		$templatePath = $root . $template . '.php';

		if (!is_file($templatePath)) {
			throw new \InvalidArgumentException(sprintf('Template "%s" not found in "%s"', $template, $templatePath));
		}

		extract(array('route' => Router::$route));
		extract($vars);

		try {
			require $templatePath;
		} catch (Exception $e) {
			throw $e;
		}
	}

}