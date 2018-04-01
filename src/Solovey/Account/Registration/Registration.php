<?php

namespace Solovey\Account\Registration;

use Solovey\Account\AbstractUser;

interface Registration
{
	/**
	 * @param AbstractUser $user
	 * @return AbstractUser
	 */
	function register(AbstractUser $user);
}