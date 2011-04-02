<?php
/**
 * OrderedList
 * 
 * Can contain multiple string values which are kept ordered by the float 
 * order value assigned to the string value. Every value can only be present
 * once in this list type. The value also acts as a unique identifier for
 * this list.
 * 
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
 * @since 02.04.2011
 */
namespace RedisTools\Type;

class OrderedList extends \RedisTools\Core\Dataconstruct
	implements \Countable, \Iterator
{
	
	protected $index = 0;


	/**
	 * returns the number of elements in this OrderedList
	 * 
	 * @return int
	 */
	public function count()
	{
		return $this->getRedis()->zSize( $this->getKey() );
	}
	
	/**
	 * adds a value to this OrderedList with an optional $orderValue assigned
	 * 
	 * @param string $value
	 * @param float $orderValue
	 * @return int - number of values inserted 
	 */
	public function addValue( $value, $orderValue = 0 )
	{
		return $this->getRedis()->zAdd( 
			$this->getKey(), 
			$orderValue, 
			$value 
		);
	}
	
	/**
	 * Returns the currently assigned orderValue of a $value.
	 * 
	 * @param string $value
	 * @return float 
	 */
	public function getOrderValue( $value )
	{
		return $this->getRedis()->zScore($this->getKey(), $value);
	}
	
	/**
	 * Increments the orderValue of $value by $incrementValue, adds
	 * $value to this OrderedList if it is not already existing
	 * 
	 * @param string $value
	 * @param float $incrementValue
	 * @return float - the new order value 
	 */
	public function incrementOrderValue( $value, $incrementValue = 1 )
	{
		return $this->getRedis()->zIncrBy(
			$this->getKey(), 
			$incrementValue, 
			$value
		);
	}
	
	/**
	 * deletes a $value from this OrderedList
	 * 
	 * @param string $value
	 * @return int  - number of elements deleted
	 */
	public function deleteValue( $value )
	{
		return $this->getRedis()->zDelete( 
			$this->getKey(), 
			$value
		);
	}
	
	/**
	 * Return multiple values of this list in different order.
	 * 
	 * The maximum result length can be set via $limit. $offset is the number
	 * of elements to be skipped from the beginning. $order can either be 
	 * RedisTools::ASC or RedisTools::DESC and set wether to return results
	 * with ascending or descending orderValues.
	 * 
	 * @param int $limit
	 * @param int $offset
	 * @param int $order
	 * @param boolean $withOrderValues
	 * @return array
	 */
	public function getValues($limit = 0, $offset = 0, $order = \RedisTools::DESC, $withOrderValues = false )
	{
		if($limit === 0)
		{
			$limit = -1;
		}
		else
		{
			$limit = $offset + ($limit-1);
		}
		
		if($order === \RedisTools::ASC)
		{
			return $this->getRedis()->zRange(
				$this->getKey(), 
				$offset, 
				$limit, 
				$withOrderValues
			);
		}
		
		return $this->getRedis()->zRevRange(
			$this->getKey(), 
			$offset, 
			$limit, 
			$withOrderValues
		);
	}
	
	/**
	 * iterator interface
	 * 
	 * @return float
	 */
	public function current()
	{
		$result = $this->getValues(
			1, $this->index, 
			\RedisTools::DESC,
			true
		);
		return current($result);
	}

	/**
	 * iterator interface
	 * 
	 * @return string
	 */
	public function key()
	{
		$result = $this->getValues(
			1, $this->index
		);
		
		return $result[0];
	}

	/**
	 * iterator interface
	 */
	public function next()
	{
		$this->index++;
	}

	/**
	 * iterator interface
	 */
	public function rewind()
	{
		$this->index = 0;
	}

	/**
	 * iterator interface
	 * @return boolean
	 */
	public function valid()
	{
		return count($this->getValues(1, $this->index)) > 0;
	}

	/**
	 * TODO: implement:
	 * 
	 *  - zRank, zRevRank
	 *  - zRemRangeByRank, zDeleteRangeByRank
	 *  - zRemRangeByScore, zDeleteRangeByScore
	 *  - zCount
	 *  - zRangeByScore, zRevRangeByScore
	 * 
	 *  - zInter
	 *  - zUnion
	 * 
	 * 
	 */
	
	
}