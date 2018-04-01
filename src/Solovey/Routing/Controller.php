<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:05.
 * | Site: teslex.tech
 * | ------------------------------
 * | Controller.php
 * | ---
 */

namespace Solovey\Routing;

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

		render($root . $template, $vars);
	}
}