<?php
/**
 * | -----------------------------
 * | Created by exp on 1/25/18/8:46 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | AuthMiddleware.php
 * | ---
 */

namespace Solovey\Middleware;


interface AuthMiddleware
{

	function ifIsAuth();

}