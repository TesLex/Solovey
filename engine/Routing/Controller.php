<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:05.
 * | Site: teslex.tech
 * | ------------------------------
 * | Controller.phpp
 * | ---
 */

namespace Routing;

use http\Exception;

abstract class Controller
{

	protected $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function render($template, array $vars = array())
	{
		$root = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR;

		$templatePath = $root . $template;

		if (!is_file($templatePath)) {
			throw new \InvalidArgumentException(sprintf('Template "%s" not found in "%s"', $template, $templatePath));
		}

		extract($vars);

		ob_start();
		ob_implicit_flush(0);

		try {
			require($templatePath);
		} catch (Exception $e) {
			ob_end_clean();
			throw $e;
		}

		return ob_get_clean();
	}

	public function e404()
	{
		echo "404";
	}

}