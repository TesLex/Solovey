<?php
/**
 * | -----------------------------
 * | Created by expexes on 30.11.17/22:20.
 * | Site: teslex.tech
 * | ------------------------------
 * | TestController.php
 * | ---
 */

class TestController extends \Routing\RestController
{
	public function test()
	{
		$this->render(array(
			'test' => 'ok'
		));
	}
}