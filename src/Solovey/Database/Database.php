<?php

namespace Solovey\Database;

use Exception;
use PDO;
use PDOException;
use Solovey\Database\Methods\Crud;
use Solovey\Database\Methods\Pagination;
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
	 * @param string $query
	 * @return Query
	 */
	public static function query($query)
	{
		return new Query($query);
	}


	/**
	 * @param string $className
	 * @return Crud
	 */
	public static function crud($className)
	{
		return new Crud($className);
	}


	/**
	 * @param string $className
	 * @param int $perPage
	 * @return Pagination
	 */
	public static function pagination($className, int $perPage)
	{
		return new Pagination($className, $perPage);
	}

	/**
	 * Start a transaction
	 */
	public static function startTransaction()
	{
		self::getPdo()->beginTransaction();
	}

	/**
	 * @return PDO
	 */
	public static function getPdo(): PDO
	{
		return self::$pdo;
	}

	/**
	 * Commit transaction changes
	 * @throws Exception
	 */
	public static function commitTransaction()
	{
		try {
			self::getPdo()->commit();
		} catch (Exception $e) {
			self::getPdo()->rollBack();
			throw $e;
		}
	}


}