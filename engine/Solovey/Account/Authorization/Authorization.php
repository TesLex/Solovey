<?php

namespace Solovey\Account\Authorization;

use Solovey\Account\AbstractUser;

interface Authorization
{

	/**
	 * @param $username
	 * @param $password
	 * @return AbstractUser
	 */
	function authorize($username, $password);

	/**
	 * @return mixed
	 */
	function after();

}