<?php

namespace Solovey\Service;

use Solovey\Database\Database;

class DatabaseService extends Service
{
	public $db;

	/**
	 * DatabaseService constructor.
	 */
	public function __construct()
	{
		$this->db = new Database(
			DATABASE['host'],
			DATABASE['user'],
			DATABASE['name'],
			DATABASE['password']
		);
	}
}