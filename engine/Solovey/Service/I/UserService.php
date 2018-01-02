<?php

namespace Solovey\Service\I;


use Solovey\Account\AbstractUser;

interface UserService
{
	/**
	 * UserService constructor.
	 * @param AbstractUser $user
	 */
	function __construct(AbstractUser $user);

	/**
	 * @return mixed
	 */
	static function logout();

	/**
	 * @return mixed
	 */
	function login();

	/**
	 * @return mixed
	 */
	function register();

	/**
	 * @return mixed
	 */
	function remove();
}