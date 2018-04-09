<?php
/**
 * | -----------------------------
 * | Created by exp on 4/10/18/12:16 AM.
 * | Site: teslex.tech
 * | ------------------------------
 * | Solovey.php
 * | ---
 */


namespace Solovey;

class Solovey
{

	public static $catchClojure = null;

	public static function catch($callback)
	{
		self::$catchClojure = $callback;
	}

}