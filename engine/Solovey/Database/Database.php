<?php

namespace Solovey\Database;

use PDO;
use PDOException;

class Database
{

	private $host;

	private $user;

	private $name;

	private $password;

	private $pdo;

	/**
	 * Database constructor.
	 * @param $host
	 * @param $user
	 * @param $name
	 * @param $password
	 */
	public function __construct($host, $user, $name, $password)
	{
		$this->host = $host;
		$this->user = $user;
		$this->name = $name;
		$this->password = $password;

		$dsn = "mysql:host=$host;dbname=$name;charset=utf8";
		$opt = [
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
			PDO::ATTR_EMULATE_PREPARES => false,
		];

		try {
			$this->pdo = new PDO($dsn, $user, $password, $opt);
		} catch (PDOException $e) {
			die('ERROR DATABASE CONNECTION: ' . $e->getMessage());
		}
	}

	/**
	 * @param $what
	 * @param $from
	 * @param array $where
	 * @param string $separator
	 * @return \PDOStatement
	 */
	function select($what, $from, $where = array(), $separator = '=')
	{
		$w = '';

		foreach ($where as $item => $value) {
			$w .= $item . ' ' . $separator . ' :' . $item . ', ';
		}

		$w = substr($w, 0, strlen($w) - 2);

		$query = 'SELECT ' . $what . ' FROM ' . $from . (sizeof($where) > 0 ? ' WHERE ' . $w : '');

		$stmt = $this->pdo->prepare($query);

		$stmt->execute($where);

		return $stmt;
	}

	/**
	 * @param $where
	 * @param array $what
	 * @return \PDOStatement
	 */
	function insert($where, $what = array())
	{
		$items = '';
		$values = '';

		foreach ($what as $item => $value) {
			$items .= $item . ', ';
			$values .= "'" . $value . "', ";
		}

		$items = substr($items, 0, strlen($items) - 2);
		$values = substr($values, 0, strlen($values) - 2);

		$query = "INSERT INTO $where ($items) VALUES ($values)";

		$stmt = $this->pdo->query($query);

		return $stmt;
	}

	/**
	 * @param $what
	 * @param array $set
	 * @param null $where
	 * @return \PDOStatement
	 */
	function update($what, $set = array(), $where = null)
	{
		$values = '';

		foreach ($set as $item => $value) {
			$values .= $item . ' = :' . $item . ', ';
		}

		$values = substr($values, 0, strlen($values) - 2);

		$query = 'UPDATE ' . $what . ' SET ' . $values . (isset($where) ? ' WHERE ' . $where : '');

		$stmt = $this->pdo->prepare($query);

		$stmt->execute($set);

		return $stmt;
	}

	/**
	 * @param $from
	 * @param array $where
	 * @return \PDOStatement
	 */
	function delete($from, $where = array())
	{
		$w = '';

		foreach ($where as $item => $value) {
			$w .= $item . ' = :' . $item . ', ';
		}

		$w = substr($w, 0, strlen($w) - 2);

		$query = 'DELETE FROM ' . $from . (sizeof($where) > 0 ? ' WHERE ' . $w : '');

		$stmt = $this->pdo->prepare($query);

		$stmt->execute($where);

		return $stmt;
	}

	/**
	 * @return PDO
	 */
	function getPdo()
	{
		return $this->pdo;
	}
}