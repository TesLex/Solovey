<?php

namespace Solovey\Database\Methods;


use Exception;
use Solovey\Database\Database;

class Delete
{

	private $query = 'DELETE FROM ';
	private $data = [];
	private $separator = ',';
	private $transactional = false;

	/**
	 * Delete constructor.
	 * @param $from
	 */
	public function __construct($from)
	{
		$this->query .= "$from ";
		$this->separator = Database::$separator;
	}

	/**
	 * @param array $where
	 * @param bool $n
	 * @return $this
	 */
	public function where(array $where, $n = true)
	{
		$w = '';

		foreach ($where as $item => $value) {
			$sep = '=';
			if (preg_match('/[\s]+/i', $item, $match)) {
				$sep = '';
			}

			if (preg_match('/^solovey_database_unbind\((.+)\)$/i', $value, $match)) {
				$w .= "$item $sep $match[1] $this->separator ";
			} else {
				$w .= "$item $sep ? $this->separator ";
				array_push($this->data, $value);
			}
		}

		$w = substr($w, 0, strlen($w) - ($this->separator === ',' ? 2 : 5));

		$this->query .= ($n ? "WHERE $w " : "$w ");

		return $this;
	}

	/**
	 * @param $i
	 * @return $this
	 */
	public function i($i)
	{
		$this->query .= "$i ";
		return $this;
	}

	/**
	 * @return $this
	 */
	public function transactional()
	{
		$this->transactional = true;
		return $this;
	}

	/**
	 * @return \PDOStatement
	 */
	public function execute()
	{
		$stmt = null;

		if ($this->transactional) {
			try {
				Database::$pdo->beginTransaction();

				$stmt = Database::$pdo->prepare($this->query);
				$stmt->execute($this->data);

				Database::$pdo->commit();
			} catch (Exception $e) {
				Database::$pdo->rollBack();
				echo $e->getMessage();
			}
		} else {
			$stmt = Database::$pdo->prepare($this->query);
			$stmt->execute($this->data);
		}

		return $stmt;
	}

	/**
	 * @return string
	 */
	public function getQuery()
	{
		return $this->query;
	}

}