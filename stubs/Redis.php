<?php
/**
 * Redis.php method stub
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 */
class Redis
{

	/**
	 * Connects to a Redis instance
	 * 
	 * @param string $host
	 * @param int $port
	 * @param float $timeout 
	 */
	public function connect( $host, $port=null, $timeout=null ){}
	
	/**
	 * Connects to a Redis instance
	 * 
	 * @param string $host
	 * @param int $port
	 * @param float $timeout 
	 */
	public function open( $host, $port=null, $timeout=null ){}
	
	/**
	 * Connects to a Redis instance or reuse a connection already established
	 * 
	 * @param string $host
	 * @param int $port
	 * @param float $timeout 
	 */
	public function pconnect( $host, $port=null, $timeout=null ){}
	
	/**
	 * Connects to a Redis instance or reuse a connection already established
	 * 
	 * @param string $host
	 * @param int $port
	 * @param float $timeout 
	 */
	public function popen( $host, $port=null, $timeout=null ){}

	/**
	 * test if connection to redis is OK
	 * @return string - '+PONG' on success
	 */
	public function ping(){}
	
	/**
	 * !!! NOT IMPLEMENTED IN PHP REDIS !!!
	 * sets redis global options
	 * 
	 * @param int $name
	 * @param string $value
	 * @return boolean
	 */
	public function setOption($name, $value){}
	
	/**
	 * !!! NOT IMPLEMENTED IN PHP REDIS !!!
	 * returns a redis global option
	 * 
	 * @param type $name 
	 */
	public function getOption($name){}
	
	/**
	 * returns the data of a single key as string. Returns false if key does not exist
	 * 
	 * @param string $key
	 * @return string | boolean 
	 */
	public function get( $key ){}
	
	/**
	 * sets the key $key to the string value $value
	 * 
	 * @param string $key
	 * @param string $value
	 * @return boolean success
	 */
	public function set( $key, $value ){}
	
	/**
	 * deletes one $key or multiple array($key1, $key2) keys from redis
	 * 
	 * @param string|array $key
	 * @return int - number of keys deleted
	 */
	public function delete( $key ){}
	
	/**
	 * set a key $key to value $value for $ttl seconds
	 * 
	 * @param string $key
	 * @param int $ttl - validity in seconds
	 * @param string $value
	 * @return boolean - success 
	 */
	public function setex( $key, $ttl, $value ){}
	
	/**
	 * sets the key $key to string value $value if $key does not already exist
	 * 
	 * @param string $key
	 * @param string $value
	 * @return boolean success 
	 */
	public function setnx( $key, $value){}
	
	/**
	 * sets Redis into multi command (transactional) mode
	 * all subsequent commands are attached to the existing command and executed 
	 * all in one when TH_Redis::exec() is called. After that TH_Redis continues 
	 * to work in normal mode again. Call TH_Redis::discard() to reset redis into 
	 * normal mode and abort all attached commands.
	 * 
	 * @return TH_Redis 
	 */
	public function multi(){}
	
	/**
	 * flushes all keys of the current redis database
	 * 
	 * @return boolean - always true
	 */
	public function flushDB(){}
	
	/**
	 * returns the values of multiple redis keys as an array
	 * (false is returned if a given key does not exists) 
	 * example: $keys: array('k1', 'k2') -> result: array('v1', false)
	 * 
	 * @param array $keys
	 * @return array 
	 */
	public function getMultiple( $keys ){}
	
	/**
	 * sets an expire date for a given redis key
	 * 
	 * @param type $key - the redis key to expire
	 * @param int $timestamp - the expire date a unix timestamp
	 * @return boolean - success
	 */
	public function expireAt( $key, $timestamp ){}
	
	/**
	 * returns the remaining time to live in seconds for a key
	 * 
	 * @param string $key - the Redis key
	 * @return int - the time to live in seconds
	 */
	public function ttl( $key ){}
	
	/**
	 * determine wether the given key already exists in redis db
	 * 
	 * @param string $key
	 * @return boolean
	 */
	public function exists( $key ){}
	
	/**
	 * returns the length of the ordered list with key $key
	 * 
	 * @param string $key 
	 * @return int
	 */
	public function zSize( $key ){}
	
	/**
	 * returns the score of a member in a sorted set
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int
	 */
	public function zScore( $key, $value ){}
	
	/**
	 * adds a value 
	 * 
	 * @param string $key
	 * @param double $score
	 * @param strring $value
	 * @return int - number of affected rows 
	 */
	public function zAdd( $key, $score, $value ){}
	
	/**
	 * returns a range of ordered elements for a given key
	 * result format: array('value1', 'vaule2') or array('value1' -> 1, 'value2' -> 2)
	 * if $withScores is set to true
	 * 
	 * @param string $key - the Redis key of the ordered list
	 * @param int $start - the start index of the range (zero based: first element = 0)
	 * @param int $end - the end index of the range (last element = -1)
	 * @param boolean $withScores - wether to return the score (order value) of the elements as well
	 * @return array
	 */
	public function zRange( $key, $start, $end, $withScores = false ){}
	
	/**
	 * returns a range of ordered elements for a given key in reverse order
	 * result format: array('value2', 'vaule1') or array('value2' -> 2, 'value1' -> 1)
	 * if $withScores is set to true
	 * 
	 * ATTENTION: This call changes in later versions of phpredis plugin
	 * 
	 * @param string $key - the Redis key of the ordered list
	 * @param int $start - the start index of the range (zero based: first element = 0)
	 * @param int $end - the end index of the range (last element = -1)
	 * @param boolean $withScores - wether to return the score (order value) of the elements as well
	 * @return array
	 */
	public function zRevRange( $key, $start, $end, $withScores = false ){}
	
	/**
	 * increments the order value of a specific element in the ordered list
	 * the element is identified by its value
	 *
	 * @param string $key - the Redis key of the ordered list
	 * @param double $orderValue - the value to be added to current order value
	 * @param string $itemValue - the value of the field to be incremented
	 * @return int - the new order value
	 */
	public function zIncrBy( $key, $orderValue, $itemValue ){}
	
	/**
	 * removes a item form an ordered list
	 * 
	 * @param string $key
	 * @param string $itemValue
	 * @return int - 1 = success, 0 = failure
	 */
	public function zDelete( $key, $itemValue ){}
	
	/**
	 * sets a value $value to the hash stored at $key on position $hashKey
	 * 
	 * @param string $key
	 * @param string $hashKey
	 * @param mixed string|int $value
	 * @return int 1: success created, 0: success replaced, false: error 
	 */
	public function hSet( $key, $hashKey, $value ){}
	
	/**
	 * sets a value $value to the hash stored at $key on position $hashKey 
	 * only if the value is not already present
	 * 
	 * @param string $key
	 * @param string $hashKey
	 * @param mixed string|int $value
	 * @return boolean success (false if error or already present)
	 */
	public function hSetNx( $key, $hashKey, $value ){}
	
	/**
	 * Gets a value from the hash $key stored at $hashKey.
	 * 
	 * @param string $key
	 * @param string $hashKey
	 * @return mixed | false 		- <code>false</code> if the key does not exist
	 */
	public function hGet( $key, $hashKey ){}
	
	/**
	 * returns the number of items in hash stored at $key
	 * 
	 * @param string $key
	 * @return int
	 */
	public function hLen( $key ){}
	
	/**
	 * Removes a value from the hash $key on position $hashKey
	 * 
	 * @param string $key
	 * @param string $hashKey
	 * @return boolean success 
	 */
	public function hDel( $key, $hashKey ){}
	
	/**
	 * returns all hashKeys of hash at $key
	 * 
	 * @param string $key
	 * @return array false on error
	 */
	public function hKeys( $key ){}
	
	/**
	 * returns all values from the hash on key $key
	 * 
	 * @param string $key
	 * @return array
	 */
	public function hVals( $key ){}
	
	/**
	 * returns all entries of the hash stored at $key
	 * 
	 * @param string $key
	 * @return array
	 */
	public function hGetAll( $key ){}
	
	/**
	 * Verify if the specified value at $hashKey exists in hash $key
	 * 
	 * @param string $key
	 * @param string $hashKey
	 * @return boolean 
	 */
	public function hExists( $key, $hashKey ){}
	
	/**
	 * Increments the value of a member $hashKey from a hash at $key by a given amount
	 * 
	 * @param type $key
	 * @param type $hashKey
	 * @param int $incrementValue
	 * @return int the new value
	 */
	public function hIncrBy( $key, $hashKey, $incrementValue ){}
	
	/**
	 * sets multiple key value pairs at once into hash on key $key
	 * usage: hMset('rediskey', array('key1' => 'val1', 'key2' => 'val2') ){}
	 * 
	 * @param string $key
	 * @param array $values
	 * @return boolean success
	 */
	public function hMset( $key, $values ){}
	
	/**
	 * returns an array of values stored on position $hashKeys in the form
	 * hMget('key', array('k1', 'k2')) => array('k1' => 'v1', 'k2' => false)
	 * 
	 * @param string $key
	 * @param array $hashKeys
	 * @return array
	 */
	public function hMGet( $key, $hashKeys ){}
	
	
	/**
	 * Adds the string value to the head (left) of the list. 
	 * Creates the list if the key didn't exist. 
	 * If the key exists and is not a list, false is returned.
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	public function lPush( $key, $value ){}
	
	/**
	 * Adds the string value to the end (right) of the list. 
	 * Creates the list if the key didn't exist. 
	 * If the key exists and is not a list, false is returned.
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	public function rPush( $key, $value ){}
	
	/**
	 * Adds the string value to the head (left) of the list only if the list already exists. 
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	public function lPushx( $key, $value ){}
	
	/**
	 * Adds the string value to the end (right) of the list only if the list already exists. 
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int | boolean false - new length of list or false on error 
	 */
	public function rPushx( $key, $value ){}
	
	/**
	 * returns and removes the first element of the list
	 * 
	 * @param string $key
	 * @return string 
	 */
	public function lPop( $key ){}
	
	/**
	 * returns and removes the last element of the list
	 * 
	 * @param string $key
	 * @return string
	 */
	public function rPop( $key ){}
	
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
	public function blPop( $keys, $timeout ){}
	
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
	public function brPop( $keys, $timeout ){}
	
	/**
	 * Returns the size of a list identified by $key
	 * 
	 * @param string $key
	 * @return int | boolean false - the lenght of the list or false if list does not exist 
	 */
	public function lSize( $key ){}
	
	/**
	 * Return the specified element of the list stored at the specified $index. 
	 *  0 the first element
	 *  1 the second ... 
	 * -1 the last element
	 * 
	 * @param string $key
	 * @param int $index 
	 * @return string - the value stored a position $index
	 */
	public function lGet( $key, $index ){}
	
	/**
	 * sets the list at index $index to value $value
	 * 
	 * @param string $key
	 * @param int $index
	 * @param string $value
	 * @return boolean - success (false if no list or index out of range)
	 */
	public function lSet( $key, $index, $value ){}
	
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
	public function lRange( $key, $start, $end ){}
	
	/**
	 * trims an existing list so that it will contain only a specified range of elements
	 * 
	 * @param string $key
	 * @param int $start
	 * @param int $end
	 * @return boolean success false if $key is no list 
	 */
	public function lTrim( $key, $start, $end ){}
	
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
	public function lRem( $key, $vaule, $count ){}
	
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
	public function lInsert( $key, $position, $pivot, $value ){}


}
