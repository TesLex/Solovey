<?php
/**
 * | -----------------------------
 * | Created by exp on 4/10/18/12:46 AM.
 * | Site: teslex.tech
 * | ------------------------------
 * | RouteException.php
 * | ---
 */

namespace Solovey\Exception;


use Exception;

class RouteException extends Exception
{

	public function __construct($message, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}