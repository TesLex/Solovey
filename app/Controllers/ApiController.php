<?php
/**
 * | -----------------------------
 * | Created by expexes on 30.11.17/1:17.
 * | Site: teslex.tech
 * | ------------------------------
 * | ApiController.php
 * | ---
 */

use Routing\RestController;

class ApiController extends RestController
{
	public function main()
	{
		$this->x(new User('EXP'));
	}

	public function e404()
	{
		$this->x("404");
	}
}

class User
{
	public $user = '';

	public function __construct($user)
	{
		$this->user = $user;
	}
}