<?php

namespace Solovey\Account;

abstract class AbstractUser
{
	public $username;

	public $password;

	/**
	 * AbstractUser constructor.
	 * @param $username
	 * @param $password
	 */
	public function __construct($username, $password)
	{
		$this->password = $password;
		$this->username = $username;
	}
}