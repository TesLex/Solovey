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
	public static function debug(...$s)
	{
		echo('<pre>');
        foreach ($s as $item) {
            var_dump($item);
		}
		echo('</pre>');
	}

	public static function CC(...$c)
	{
        foreach ($c as $item) {
            require $_SERVER['DOCUMENT_ROOT'] . '/app/Controllers/' . $item . '.php';
	    }
	}
}