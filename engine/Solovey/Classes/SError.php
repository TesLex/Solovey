<?php

namespace Solovey\Classes;

class SError
{
	public $code = 0;

	public $title = "";

	public $message = "";

	public $solution = "";

	/**
	 * SError constructor.
	 * @param $title
	 * @param $message
	 * @param $code
	 * @param string $solution
	 */
	public function __construct($title, $message, $code = 0, $solution = "")
	{
		$this->code = $code;
		$this->message = $message;
		$this->solution = $solution;
		$this->title = $title;

		http_response_code($this->code);

		render("{$_SERVER['DOCUMENT_ROOT']}/pages/error", [
			'code' => $this->code,
			'description' => $this->message,
			'solution' => $this->solution,
			'title' => $this->title
		]);
	}
}