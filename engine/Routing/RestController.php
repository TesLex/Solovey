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

abstract class RestController
{

	protected $router;

	public function __construct(Router $router)
	{
		$this->router = $router;
	}

	public function render($o)
	{
		$encoded = json_encode($o);
		echo $encoded;

		return $encoded;
	}

	public function e404()
	{
		echo self::render(array(
			"code" => 404,
			"message" => "NOT FOUND"
		));
	}

}