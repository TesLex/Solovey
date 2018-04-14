<?php
/**
 * | -----------------------------
 * | Created by exp on 4/12/18/8:41 PM.
 * | Site: teslex.tech
 * | ------------------------------
 * | Crud.php
 * | Default implementation of CrudService
 * | ---
 */

namespace Solovey\Database\Methods;


use Solovey\Database\Database;
use Solovey\Database\Model\Table;
use Solovey\Exception\SoloveyException;
use Solovey\Service\I\CrudService;

class Crud implements CrudService
{

	private $className = null;

	/**
	 * Crud constructor.
	 * @param $className
	 */
	public function __construct($className)
	{
		$this->className = $className;
	}

	/**
	 * @param Table $object
	 * @return bool|int
	 */
	function create($object)
	{
		$object = self::normalize($object);
		$wtf = implode(',', array_fill(0, count($object['data']['keys']), '?'));

		$table = $object['table'];
		$keys = implode(',', $object['data']['keys']);
		$values = $object['data']['values'];

		$query =
			"INSERT INTO {$table} ($keys) VALUES ($wtf)";

		$result = Database::query($query)->data($values)->execute();

		return $result ? Database::getPdo()->lastInsertId() : false;
	}

	/**
	 * @param Table $object
	 * @return array
	 * @throws SoloveyException
	 */
	public static function normalize(Table $object)
	{
		$clazz = get_class($object);

		if (!hasImplements($clazz, Table::class))
			throw new SoloveyException("Class $clazz has't implements Table.class.");

		$table = $object->getTable();
		$key = $object->getKey();

		$data = o2a($object);

		$keys = [];
		$values = [];

		foreach ($data as $item => $value) {
			if (is_null($value) || $item === 'id') {
				unset($data[$item]);
				continue;
			}

			array_push($keys, $item);
			array_push($values, $value);
		}

		return [
			'table' => $table,
			'key' => $key,
			'data' => [
				'keys' => $keys,
				'values' => $values
			]
		];

	}

	/**
	 * @param $object
	 * @return mixed
	 */
	function get($object)
	{
		$norm = self::normalizeByClass($this->className);
		$table = $norm['table'];
		$key = $norm['key'];

		$query = "SELECT * FROM $table WHERE $key = ?";
		$result = Database::query($query)->data([$object])->execute()->fetch();

		return $result ? a2o($result, $this->className) : false;
	}

	/**
	 * @param $clazz
	 * @return array
	 * @throws SoloveyException
	 */
	public static function normalizeByClass($clazz)
	{
		if (!hasImplements($clazz, Table::class))
			throw new SoloveyException("Class $clazz has't implements Table.class.");

		$table = call_user_func(array($clazz, 'getTable'));
		$key = call_user_func(array($clazz, 'getKey'));

		return [
			'table' => $table,
			'key' => $key
		];
	}

	/**
	 * @param $object
	 * @return mixed
	 */
	function update($object)
	{
		$object2a = o2a($object);
		$object = self::normalize($object);

		$table = $object['table'];
		$key = $object['key'];

		$buildX = [];

		for ($i = 0; $i < sizeof($object['data']['keys']); $i++)
			array_push($buildX, $object['data']['keys'][$i] . "= ?");

		$q = implode(',', $buildX);

		$data = $object['data']['values'];
		array_push($data, $object2a[$key]);


		$query =
			"UPDATE {$table} SET $q WHERE $key = ?";

		$result = Database::query($query)->data($data)->execute();

		return $result ? $object2a[$key] : false;
	}

	/**
	 * @param $object
	 * @return mixed
	 */
	function remove($object)
	{

		$norm = self::normalizeByClass($this->className);
		$table = $norm['table'];
		$key = $norm['key'];

		$query = "DELETE FROM $table WHERE $key = ?";
		$result = Database::query($query)->data([$object])->execute()->rowCount();

		return $result;
	}
}