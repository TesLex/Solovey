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

abstract class RestController
{
	/**
	 * @param $o
	 * @return string
	 */
	public function x($o)
	{
		$encoded = json_encode($o);
		echo $encoded;

		return $encoded;
	}

}