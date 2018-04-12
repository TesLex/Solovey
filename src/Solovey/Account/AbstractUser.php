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

	/**
	 * @return mixed
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * @param mixed $username
	 */
	public function setUsername($username)
	{
		$this->username = $username;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param mixed $password
	 */
	public function setPassword($password)
	{
		$this->password = $password;
	}

}