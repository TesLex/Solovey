<?php

namespace Solovey\Account\Authorization;


use Solovey\Account\AbstractUser;

class AuthorizationService implements Authorization
{
	/**
	 * @param $username
	 * @param $password
	 * @return AbstractUser
	 */
	function authorize($username, $password)
	{
		// TODO: Implement authorize() method.
	}

	/**
	 * @return mixed
	 */
	function after()
	{
		// TODO: Implement after() method.
	}
}