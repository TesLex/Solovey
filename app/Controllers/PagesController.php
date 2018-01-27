<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/8:54 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | PagesController.php
 * | ---
 */

namespace Controllers;


use Solovey\Routing\Controller;

class PagesController extends Controller
{

	public function usersPage()
	{
		$this->render('user/users');
	}

	public function userPage($id)
	{
		$this->render('user/user', [
			'id' => $id
		]);
	}

	public function midPage() {

		echo "<br>MIDDLEWARE TEST PAGE";
	}
}