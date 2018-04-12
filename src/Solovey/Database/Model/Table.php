<?php
/**
 * | -----------------------------
 * | Created by exp on 4/12/18/8:28 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | Table.php
 * | ---
 */

namespace Solovey\Database\Model;


interface Table
{
	/**
	 * @return string
	 */
	static function getTable();

	/**
	 * @return string
	 */
	static function getKey();
}