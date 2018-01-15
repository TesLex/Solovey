<?php

namespace Solovey\Database\Methods;


use Exception;
use Solovey\Database\Database;

class Select
{

	private $query = "SELECT ";
	private $data = [];
	private $separator = ',';
	private $transactional = false;

	/**
	 * Select constructor.
	 * @param $what
	 */
	public function __construct($what)
	{
		$what = implode(', ', $what);
		$this->query .= ("$what ");
		$this->separator = Database::$separator;
	}

	/**
	 * @param array ...$from
	 * @return $this
	 */
	public function from(...$from)
	{
		$from = implode(', ', $from);

		$this->query .= ("FROM $from ");
		return $this;
	}

	/**
	 * @return $this
	 */
	public function fand()
	{
		$this->query .= 'AND ';
		return $this;
	}

	public function fas(string $as)
	{
		$this->query .= ("AS $as ");
		return $this;
	}

	/**
	 * @param array $where
	 * @return $this
	 */
	public function where(array $where)
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

		$this->query .= ("WHERE $w ");

		return $this;
	}

	/**
	 * @param array ...$by
	 * @return $this
	 */
	public function order(...$by)
	{
		$by = implode(', ', $by);

		$this->query .= ("ORDER BY $by ");
		return $this;
	}

	/**
	 * @param array ...$by
	 * @return $this
	 */
	public function group(...$by)
	{
		$by = implode(', ', $by);

		$this->query .= ("GROUP BY $by ");
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
	public function transactional() {
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
}