<?php
/**
 * | -----------------------------
 * | Created by expexes on 30.11.17/22:20.
 * | Site: teslex.tech
 * | ------------------------------
 * | TestController.php
 * | ---
 */

use Routing\RestController;

class TestController extends RestController
{
	public function test($p, $x)
	{
		$this->x($p, $x);
	}

    public function just()
    {
        echo 'OK';
    }
}