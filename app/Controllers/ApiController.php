<?php
/**
 * | -----------------------------
 * | Created by exp on 1/17/18/5:15 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | ApiController.php
 * | ---
 */

namespace Controllers;


use Solovey\Routing\RestController;

class ApiController extends RestController
{

	private $users = [
		[
			'id' => 1,
			'username' => 'expexes',
			'img' => 'expexes.png',
		],
		[
			'id' => 2,
			'username' => 'agr',
			'img' => 'agr.png',
		],
		[
			'id' => 3,
			'username' => 'undrfined',
			'img' => 'undrfined.png',
		],
	];

	/**
	 * @param int $id
	 */
	public function index(int $id)
	{
		//
	}

	public function user($id)
	{
		$this->x($this->getUserById($id));
	}

	private function getUserById(int $id)
	{
		foreach ($this->users as $user)
			if ($user['id'] === $id)
				return $user;

		return [];
	}

	public function users()
	{
		$this->x($this->getUsers());
	}

	private function getUsers()
	{
		return $this->users;
	}
}