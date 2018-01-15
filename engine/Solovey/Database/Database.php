<?php

namespace Solovey\Database;

use PDO;
use PDOException;
use Solovey\Database\Methods\Delete;
use Solovey\Database\Methods\Insert;
use Solovey\Database\Methods\Select;
use Solovey\Database\Methods\Update;

class Database
{

	public static $pdo;
	public static $separator = ',';
	private $host;
	private $user;
	private $name;
	private $password;

	/**
	 * Database constructor.
	 * @param $host
	 * @param int $port
	 * @param $user
	 * @param $name
	 * @param $password
	 * @param string $driver
	 */
	public function __construct($host, $port = 3306, $user, $name, $password, $driver = 'mysql')
	{
		$this->host = $host;
		$this->user = $user;
		$this->name = $name;
		$this->password = $password;

		$dsn = "$driver:host=$host;dbname=$name;port=$port" . (($driver === 'mysql') ? 'charset=utf8;' : '');
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		try {
			self::$pdo = new PDO($dsn, $user, $password, $opt);
		} catch (PDOException $e) {
			die('ERROR DATABASE CONNECTION: ' . $e->getMessage());
		}

		if ($driver === 'pgsql') self::$separator = 'AND';
	}

	/**
	 * @param array ...$what
	 * @return Select
	 */
	function select(...$what)
	{
		return new Select($what);
	}

	/**
	 * @param $where
	 * @return Insert
	 */
	function insert($where)
	{
		return new Insert($where);
	}

	/**
	 * @param $what
	 * @return Update
	 */
	function update($what)
	{
		return new Update($what);
	}

	/**
	 * @param $from
	 * @return Delete
	 */
	function delete($from)
	{
		return new Delete($from);
	}
}