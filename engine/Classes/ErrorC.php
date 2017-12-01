<?php
/**
 * | -----------------------------
 * | Created by expexes on 30.11.17/21:26.
 * | Site: teslex.tech
 * | ------------------------------
 * | ErrorC.php
 * | ---
 */

class ErrorC
{
	public $code = 0;

	public $message = "";

	public function __construct($code, $message)
	{
		$this->code = $code;
		$this->message = $message;
	}
}