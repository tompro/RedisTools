<?php
/**
 * Manages functionality of Redis List types
 *  
 * @author Thomas Profelt <office@protom.eu>
 * @since 30.03.2011
 */
namespace RedisTools\Type;

class ArrayList extends \RedisTools\Core\Dataconstruct
{
	
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
	
	public function pop()
	{
		return $this->getRedis()->rPop($this->getKey());
	}
	
	public function shift()
	{
		return $this->getRedis()->lPop($this->getKey());
	}


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
	 * Adds the string value to the head (left) of the list. 
	 * Creates the list if the key didn't exist. 
	 * If the key exists and is not a list, false is returned.
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	//public function lPush( $key, $value ){}
	
	/**
	 * Adds the string value to the end (right) of the list. 
	 * Creates the list if the key didn't exist. 
	 * If the key exists and is not a list, false is returned.
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	//public function rPush( $key, $value ){}
	
	/**
	 * Adds the string value to the head (left) of the list only if the list already exists. 
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	//public function lPushx( $key, $value ){}
	
	/**
	 * Adds the string value to the end (right) of the list only if the list already exists. 
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	//public function rPushx( $key, $value ){}
	
	/**
	 * returns and removes the first element of the list
	 * 
	 * @param string $key
	 * @return string 
	 */
	//public function lPop( $key ){}
	
	/**
	 * returns and removes the last element of the list
	 * 
	 * @param string $key
	 * @return string
	 */
	//public function rPop( $key ){}
	
	/**
	 * If at least one of the lists $keys contains at least one element, 
	 * the element will be popped from the head of the list and returned. 
	 * Il all the list identified by the keys passed in arguments are empty, 
	 * blPop will block during the specified timeout until an element is 
	 * pushed to one of those lists. This element will be popped.
	 * 
	 * Example: blPop(array('list1', 'list2'), 10){}
	 * 
	 * @param type $keys - array of keys identifying a list
	 * @param type $timeout - seconds to wait for an element
	 * @return array - array('listname', 'elementvalue'){} 
	 */
	//public function blPop( $keys, $timeout ){}
	
	/**
	 * If at least one of the lists $keys contains at least one element, 
	 * the element will be popped from the end of the list and returned. 
	 * Il all the list identified by the keys passed in arguments are empty, 
	 * brPop will block during the specified timeout until an element is 
	 * pushed to one of those lists. This element will be popped.
	 * 
	 * Example: brPop(array('list1', 'list2'), 10){}
	 * 
	 * @param type $keys - array of keys identifying a list
	 * @param type $timeout - seconds to wait for an element
	 * @return array - array('listname', 'elementvalue'){} 
	 */
	//public function brPop( $keys, $timeout ){}
	
	
	
	/**
	 * Returns the specified elements of the list stored at the specified key 
	 * in the range from $start to $end. start and stop are interpretated as indices: 
	 *  0 the first element
	 *  1 the second ... 
	 * -1 the last element
	 * 
	 * @param string $key
	 * @param int $start
	 * @param int $end
	 * @return array - the values 
	 */
	//public function lRange( $key, $start, $end ){}
	
	/**
	 * trims an existing list so that it will contain only a specified range of elements
	 * 
	 * @param string $key
	 * @param int $start
	 * @param int $end
	 * @return boolean success false if $key is no list 
	 */
	//public function lTrim( $key, $start, $end ){}
	
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
	 * Insert value in the list before or after the $pivot value. 
	 * The parameter options specify the position of the insert (before or after). 
	 * If the list didn't exists, or the pivot didn't exist, the value is not inserted (returns -1).
	 * 
	 * @param string $key
	 * @param int $position - TH_Redis::BEFORE | TH_Redis::AFTER
	 * @param string $pivot - Value after which the new value should be inserted
	 * @param string $value - The value to be inserted
	 * @return int the number of elements now in the list, -1 if pivot not exists, 0 if not inserted 
	 */
	//public function lInsert( $key, $position, $pivot, $value ){}
}
