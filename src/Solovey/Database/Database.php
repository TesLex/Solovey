<?php

namespace Solovey\Database;

use PDO;
use PDOException;
use Solovey\Database\Methods\Query;

class Database
{

	public static $pdo = null;

	/**
	 * Database constructor.
	 * @param array $conf
	 */
	public function __construct($conf)
	{
		self::init($conf);
	}


	/**
	 * @param array $conf
	 */
	public static function init($conf)
	{
		$driver = $conf['driver'];
		$host = $conf['host'];
		$port = $conf['port'];
		$name = $conf['name'];
		$user = $conf['user'];
		$password = $conf['password'];

		$dsn = "$driver:host=$host;dbname=$name;port=$port" . (($driver === 'mysql') ? 'charset=utf8;' : '');
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		try {
			self::$pdo = new PDO($dsn, $user, $password, $opt);
		} catch (PDOException $e) {
			throw $e;
		}
	}

	/**
	 * @param $query
	 * @return Query
	 */
	public static function query($query)
	{
		return new Query($query);
	}
}