<?php
/**
 * UniqueIdentifier
 * 
 * Copyright (c) 2011 Thomas Profelt
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 12.04.2011
 */

namespace RedisTools\Db\Field;
use RedisTools\Db;

class UniqueIdentifier extends Db\Field
{
	/**
	 * @var \RedisTools\Type\Hash
	 */
	protected $lookupTable;

	/**
	 * Deletes the mapping between this unique identifier and the ValueObjects key
	 *
	 * @return boolean - success
	 */
	function onDelete()
	{
		return $this->getLookupTable()->deleteKey($this->getValue());
	}

	/**
	 * Inserts the mapping between the value of this unique identifier and the ValueObjects key
	 *
	 * @return boolean - success
	 */
	public function onSave()
	{
		$value = $this->getValue();
		if(!empty( $value ))
		{
			return $this->getLookupTable()->set(
				 $this->getValue(),
				 $this->getValueObject()->getKey()
			 ) > 0;
		}
		return false;
	}

	/**
	 * Sets the lookup table instance
	 *
	 * @param \RedisTools\Type\Hash $lookupTable
	 * @return void
	 */
	public function setLookupTable($lookupTable)
	{
		$this->lookupTable = $lookupTable;
	}

	/**
	 * Returns the lookup table to be used for mapping unique identifiers
	 *
	 * @return \RedisTools\Type\Hash
	 */
	public function getLookupTable()
	{
		if($this->lookupTable === null)
		{
			$this->lookupTable = new \RedisTools\Type\Hash(
				$this->getLookupTableKey(),
				$this->getValueObject()->getRedis()
			);
		}
		return $this->lookupTable;
	}

	/**
	 * Returns the generated Redis key for the LookupTable
	 *
	 * @return string
	 */
	protected function getLookupTableKey()
	{
		$key = $this->getValueObject()->getKey();
		$name = $this->getName();

		if($key != '' && $name != '')
		{
			return md5($this->getValueObject()->getKey() . $this->getName());
		}

		throw new \RedisTools\Exception("Could not generate key for lookup table because key '$key' and/or name '$name' are empty.");
	}


}