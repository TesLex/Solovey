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

class Pagination
{
	private $className = null;
	private $table = null;
	private $keys = [];
	private $perPage = null;

	/**
	 * Pagination constructor.
	 * @param string $className
	 * @param $perPage
	 */
	public function __construct($className, $perPage)
	{
		$this->className = $className;
		$this->perPage = $perPage;

		$this->table = Crud::normalizeByClass($this->className)['table'];
		$this->keys = Crud::normalizeByClass($this->className)['data']['keys'];
	}

	/**
	 * @return int
	 */
	function count()
	{
		$query = "SELECT Count(*) FROM $this->table";

		return ceil(Database::query($query)->execute()->fetchColumn() / $this->perPage);
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

		$query = "SELECT $fields FROM $this->table LIMIT $this->perPage OFFSET $offset";
		$result = Database::query($query)->execute()->fetchAll();
		$all = [];

		foreach ($result as $res) {
			array_push($all, a2o($res, $this->className));
		}

		return $all;
	}

}