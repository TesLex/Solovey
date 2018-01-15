<?php

namespace Solovey\Service\I;


use Solovey\Account\AbstractUser;

interface UserService
{
	/**
	 * @return mixed
	 */
	static function logout();

	/**
	 * @param $username
	 * @param $password
	 * @return mixed
	 */
	function login($username, $password);

	/**
	 * @param AbstractUser $user
	 * @return mixed
	 */
	function register(AbstractUser $user);

	/**
	 * @param $id
	 * @return mixed
	 */
	function remove($id);
}