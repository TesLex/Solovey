<?php
/**
 * | -----------------------------
 * | Created by exp on 4/14/18/3:21 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | Pagination.php
 * | ---
 */

namespace Solovey\Database\Methods;


use Solovey\Database\Database;
use function a2o;
use function array_push;
use function ceil;
use function criteriaToSQL;
use function r;

class Pagination
{
	private $className = null;
	private $table = null;
	private $keys = [];
	private $perPage = null;
	private $criteria = [];

	/**
	 * Pagination constructor.
	 * @param string $className
	 * @param int $perPage
	 * @param array $criteria
	 */
	public function __construct($className, int $perPage = 10, array $criteria = [])
	{
		$this->className = $className;
		$this->perPage = $perPage;
		$this->criteria = $criteria;

		$this->table = Crud::normalizeByClass($this->className)['table'];
		$this->keys = Crud::normalizeByClass($this->className)['data']['keys'];
	}

	/**
	 * @return int
	 */
	function count()
	{
		$query = "SELECT Count(*) FROM $this->table";
		$critQL = criteriaToSQL($this->criteria);

		if (empty($this->criteria))
			return ceil(Database::query($query)->execute()->fetchColumn() / $this->perPage);
		else
			return ceil(Database::query("$query WHERE {$critQL['query']}")->data($critQL['data'])->execute()->fetchColumn() / $this->perPage);
	}

	/**
	 * @param int $page
	 * @param array $fields
	 * @return array
	 */
	function page(int $page, $fields = [])
	{
		$offset = ($page - 1) * $this->perPage;

		foreach ($fields as $index => $field)
			if (!in_array($field, $this->keys))
				unset($fields[$index]);

		$fields = empty($fields) ? '*' : implode(',', $fields);

		$query = "SELECT $fields FROM $this->table";
		$limits = "LIMIT $this->perPage OFFSET $offset";

		$critQL = criteriaToSQL($this->criteria);

		r("$query WHERE {$critQL['query']} $limits");

		if (empty($this->criteria))
			$result = Database::query("$query $limits")->execute()->fetchAll();
		else
			$result = Database::query("$query WHERE {$critQL['query']} $limits")->data($critQL['data'])->execute()->fetchAll();

		$all = [];

		foreach ($result as $res) {
			array_push($all, a2o($res, $this->className));
		}

		return $all;
	}
}