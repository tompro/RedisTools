<?php
namespace RedisTools\Db;

class FieldDummy extends Field
{
	/**
	 * Template method to be implemented by descending classes
	 * to perform further db operations eg. deleting indexes and
	 * lookup tables
	 *
	 * @return boolean - success
	 */
	function onDelete()
	{
		return true;
	}

	/**
	 * Template method to be implemented by descending classes
	 * to perform further db operations eg. updating indexes and lookup tables
	 *
	 * @return boolean - success
	 */
	public function onSave()
	{
		return true;
	}

}
