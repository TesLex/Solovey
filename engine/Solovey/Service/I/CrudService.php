<?php

namespace Solovey\Service\I;


interface CrudService
{
	/**
	 * @param $object
	 * @return mixed
	 */
	function add($object);

	/**
	 * @param $object
	 * @return mixed
	 */
	function get($object);

	/**
	 * @param $object
	 * @return mixed
	 */
	function update($object);

	/**
	 * @param $object
	 * @return mixed
	 */
	function remove($object);
}