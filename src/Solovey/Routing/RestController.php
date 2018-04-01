<?php
/**
 * | -----------------------------
 * | Created by expexes on 29.11.17/23:05.
 * | Site: teslex.tech
 * | ------------------------------
 * | RestController.php
 * | ---
 */

namespace Solovey\Routing;

abstract class RestController
{

	/**
	 * @param $o
	 * @return string
	 */
	public function x($o)
	{
		header("Content-Type: application/json");

		$encoded = json_encode($o);
		echo $encoded;

		return $encoded;
	}
}