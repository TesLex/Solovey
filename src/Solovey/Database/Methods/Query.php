<?php
/**
 * | -----------------------------
 * | Created by exp on 4/1/18/8:21 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | Query.php
 * | ---
 */

namespace Solovey\Database\Methods;


use Solovey\Database\Database;

class Query
{

	private $query = '';
	private $data = [];

	/**
	 * Query constructor.
	 * @param string $query
	 */
	public function __construct($query)
	{
		$this->query = $query;
	}

	/**
	 * @param array $data
	 * @return $this
	 */
	public function data($data)
	{
		$this->data = $data;
		return $this;
	}

	/**
	 * @return \PDOStatement
	 */
	public function execute()
	{
		$stmt = null;
		$pdo = Database::getPdo();

		$stmt = $pdo->prepare($this->query);
		$stmt->execute($this->data);

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