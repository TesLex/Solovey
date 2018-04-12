<?php
/**
 * | -----------------------------
 * | Created by exp on 4/12/18/8:50 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | SoloveyException.php
 * | ---
 */

namespace Solovey\Exception;


use Exception;

class SoloveyException extends Exception
{

	public function __construct($message, $code = 0, Exception $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}

}