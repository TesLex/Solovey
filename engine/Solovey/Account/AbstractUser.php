<?php

namespace Solovey\Account;

abstract class AbstractUser
{
	public $username;

	public $password;

	/**
	 * AbstractUser constructor.
	 * @param $email
	 * @param $password
	 */
	public function __construct($email, $password)
	{
		$this->password = $password;
		$this->username = $email;
	}
}