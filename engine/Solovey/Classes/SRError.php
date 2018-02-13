<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/7:49 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | SRError.php
 * | ---
 */

namespace Solovey\Classes;


class SRError extends SError
{
	/**
	 * SRError constructor.
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

		header("Content-Type: application/json");
		header("HTTP/1.1 $code $title");

		echo json_encode([
			'success' => false,
			'code' => $this->code,
			'description' => $this->message,
			'solution' => $this->solution
		]);

//		parent::__construct($code, $message, $solution);
	}
}