<?php
/**
 * Set
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
 * @since 06.04.2011
 */
namespace RedisTools\Type;

class Set extends \RedisTools\Core\Dataconstruct
	implements \Countable
{
	
	/**
	 * adds a value to this Set
	 * 
	 * @param string $value
	 * @return boolean - true on insert false if value already in set
	 */
	public function addValue( $value )
	{
		return $this->getRedis()->sAdd($this->getKey(), $value);
	}
	
	/**
	 * removes a value from this Set
	 * 
	 * @param string $value
	 * @return boolean - true if key was deleted false if key was not in set 
	 */
	public function deleteValue( $value )
	{
		return $this->getRedis()->sRemove($this->getKey(), $value);
	}
	
	/**
	 * Determine wether the given value is present in this Set
	 * 
	 * @param string $value
	 * @return boolean 
	 */
	public function contains( $value )
	{
		return $this->getRedis()->sContains($this->getKey(), $value);
	}
	
	/**
	 * Returns the number of elements contained in this Set.
	 * 
	 * @return int - the number of elements 
	 */
	public function count()
	{
		return $this->getRedis()->sSize($this->getKey());
	}
	
	/**
	 * Returns and removes a random member of this Set
	 * 
	 * @return string - the value, false if key does not exist 
	 */
	public function pop()
	{
		return $this->getRedis()->sPop($this->getKey());
	}
	
	/**
	 * Moves the given $value from this Set to the given $set.
	 * 
	 * Returns true on success. Returns false if the given value
	 * is not present in this Set.
	 * 
	 * @param string $value
	 * @param Set $set
	 * @return boolean - success 
	 */
	public function moveValueToSet( $value, Set $set )
	{
		return $this->getRedis()->sMove($this->getKey(), $set->getKey(), $value);
	}
	
	/**
	 * Returns all values contained in this Set in random order.
	 * 
	 * @return array
	 */
	public function getValues()
	{
		return $this->getRedis()->sMembers($this->getKey());
	}
	
	/**
	 * Returns all values present in this Set but not present in any other
	 * given $sets as either an array or as a new Set with values stored in
	 * $resultKey.
	 * 
	 * Data stored in $resultKey will be overwritten. If no Set is present
	 * in the $sets array, all values contained in this Set will be returned.
	 * 
	 * @param Set | array $sets
	 * @param boolean $storeResult
	 * @param string $resultKey
	 * @return Set | array | boolean
	 */
	public function getDiff( $sets = array(), $storeResult = false, $resultKey = null )
	{
		$setKeys = array( $this->getKey() );
		
		if(  is_array( $sets ))
		{
			foreach ($sets as $setToCompare)
			{
				if($setToCompare instanceof Set)
				{
					$setKeys[] = $setToCompare->getKey();
				}
			}
		}
		else if($sets instanceof Set)
		{
			$setKeys[]= $sets->getKey();
		}
		
		if($storeResult)
		{
			$this->validateKey($resultKey);
			array_unshift($setKeys, $resultKey);
			
			$result = call_user_func_array(
				array($this->getRedis(), 'sDiffStore'), 
				$setKeys
			);
			
			if( $result !== false )
			{
				$result = new Set($resultKey, $this->getRedis());
			}
			
			return $result;
		}
		
		return call_user_func_array(
			array($this->getRedis(), 'sDiff'), 
			$setKeys
		);
	}
	
}