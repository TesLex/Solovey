<?php
/**
 * | -----------------------------
 * | Created by exp on 1/27/18/6:47 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | AuthMiddleware.php
 * | ---
 */

namespace Middleware;


use Solovey\Middleware\Middleware;

class AppMiddleware implements Middleware
{

	function index()
	{
		echo "THIS TEXT FROM MIDDLEWARE!!1! <br>";
	}
}