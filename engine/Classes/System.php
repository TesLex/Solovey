<?php
/**
 * | -----------------------------
 * | Created by expexes on 01.12.17/20:11.
 * | Site: teslex.tech
 * | ------------------------------
 * | System.php
 * | ---
 */

namespace Classes;


class System
{
	public static function debug($s)
	{
		echo('<pre>');
		var_dump($s);
		echo('</pre>');
	}
}