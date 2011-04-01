<?php
/**
 * Manages functionality of Redis List types
 *  
 * @author Thomas Profelt <office@protom.eu>
 * @since 30.03.2011
 */
namespace RedisTools\Type;

class ArrayList extends \RedisTools\Core\Dataconstruct
	implements \Countable, \Iterator
{
	/**
	 * key for internal iterator
	 * @var int
	 */
	protected $index = 0;
	
	/**
	 * Adds a value to this ArrayList.
	 * 
	 * Per default the value is inserted at the end of the list (position at length).
	 * If $toHead is set to true the value is inserted as the first element of the
	 * List. Per default if the list does not already exist it is created on push.
	 * Setting $createNonExisting to false prevents this behaviour and only pushes
	 * elements to the list if it already exists.
	 * 
	 * @param string $value
	 * @param boolean $toHead - wether to push to the top of the list
	 * @param boolean $createNonExisting - wether to create the list if not already existing
	 * @return int - the new length of list or, false on error 
	 */
	public function push( $value, $toHead = false, $createNonExisting = true )
	{
		if($createNonExisting)
		{
			if($toHead)
			{
				return $this->getRedis()->lPush($this->getKey(), $value);
			}
			return $this->getRedis()->rPush($this->getKey(), $value);
		}
		
		if($toHead)
		{
			return $this->getRedis()->lPushx( $this->getKey(), $value );
		}
		return $this->getRedis()->rPushx( $this->getKey(), $value );
	}
	
	/**
	 * returns and removes the last element of the ArrayList
	 * 
	 * @return string - false if ArrayList is empty
	 */
	public function pop()
	{
		return $this->getRedis()->rPop($this->getKey());
	}
	
	/**
	 * returns and removes the first element of the ArrayList
	 * 
	 * @return string - false if ArrayList is empty
	 */
	public function shift()
	{
		return $this->getRedis()->lPop($this->getKey());
	}
	
	/**
	 * returns a part of this ArrayList as an array.
	 * Result starting at $startIndex (inclusive)
	 * and ending with $endIndex (inclusive). Returns element to end of list
	 * if end index is higher than the length of the list.
	 * 
	 * @param int $startIndex
	 * @param int $endIndex
	 * @return array 
	 */
	public function slice( $startIndex, $endIndex = -1 )
	{
		return $this->getRedis()->lRange(
			$this->getKey(), $startIndex, $endIndex
		);
	}

	/**
	 * returns the value stored at position $index
	 * 
	 * @param int $index
	 * @return string - false if $index is empty 
	 */
	public function getValueAt( $index )
	{
		return $this->getRedis()->lGet( $this->getKey(), $index );
	}
	
	/**
	 * sets the list at index $index to value $value
	 * 
	 * @param int $index
	 * @param string $value
	 * @return boolean - success (false if no list or index out of range)
	 */
	public function setValueAt( $index, $value )
	{
		return $this->getRedis()->lSet( $this->getKey(), $index, $value );
	}
	
	/**
	 * inserts a new $value before the first occurence of an existing $listValue.
	 * 
	 * Does not insert a value if the list does not exist or the $listValue is
	 * not already present.
	 * 
	 * @param string $listValue
	 * @param string $value
	 * @return int - the number of elements now in the list, -1 $listValue not present, 0 error eg list not existing
	 */
	public function insertBeforeValue( $listValue, $value )
	{
		return $this->getRedis()->lInsert($this->getKey(), 
			\RedisTools::BEFORE, 
			$listValue, 
			$value
		);
	}
	
	/**
	 * inserts a new $value after the first occurence of an existing $listValue.
	 * 
	 * Does not insert a value if the list does not exist or the $listValue is
	 * not already present.
	 * 
	 * @param string $listValue
	 * @param string $value
	 * @return int - the number of elements now in the list, -1 $listValue not present, 0 error eg list not existing
	 */
	public function insertAfterValue( $listValue, $value )
	{
		return $this->getRedis()->lInsert($this->getKey(), 
			\RedisTools::AFTER, 
			$listValue, 
			$value
		);
	}
	
	/**
	 * trims all values of the list wich indexes are not contained within the
	 * range between (inclusive) $startIndex and $endIndex
	 * 
	 * @param int $startIndex
	 * @param int $endIndex
	 * @return boolean - success 
	 */
	public function trim( $startIndex, $endIndex = -1 )
	{
		return $this->getRedis()->lTrim( $this->getKey(),
			$startIndex, $endIndex 
		);
	}
	
	/**
	 * remove the first $count entries with value $value from this ArrayList.
	 * 
	 * Removes all entries with value $value if count = 0. Starts from the
	 * end of the list if $count is negative
	 * 
	 * @param string $value
	 * @param int $count
	 * @return int - number of items remove, false on error 
	 */
	public function removeValues( $value, $count = 0 )
	{
		return $this->getRedis()->lRem( $this->getKey(), $value, $count );
	}
	
	/**
	 * Removes the first count occurences of the value element from the list. 
	 * If count is zero, all the matching elements are removed. 
	 * If count is negative, elements are removed from tail to head.
	 * 
	 * @param type $key
	 * @param type $vaule
	 * @param type $count
	 * @return int | boolean false - the number of elements removed or false if key is no list
	 */
	//public function lRem( $key, $vaule, $count ){}


	/**
	 * returns the number of elements in this ArrayList
	 * 
	 * @return int
	 */
	public function count()
	{
		return $this->getRedis()->lLen($this->getKey());
	}
	
	/**
	 * get current iterator value
	 * 
	 * @return string
	 */
	public function current()
	{
		return $this->getValueAt( $this->index );
	}

	/**
	 * get curent iterator key
	 * 
	 * @return int
	 */
	public function key()
	{
		return $this->index;
	}

	/**
	 * increment iterator index
	 */
	public function next()
	{
		$this->index++;
	}

	/**
	 * resets iterator index
	 */
	public function rewind()
	{
		$this->index = 0;
	}

	/**
	 * determine wether iterator will get a next element
	 * 
	 * @return boolean
	 */
	public function valid()
	{
		return $this->getValueAt($this->index) !== false;
	}
	
}
