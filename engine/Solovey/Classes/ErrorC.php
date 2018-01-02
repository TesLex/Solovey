<?php

namespace Solovey\Classes;

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