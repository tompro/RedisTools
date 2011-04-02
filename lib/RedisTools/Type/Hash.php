<?php
/**
 * implements functions for Redis hash
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
 * @author Thomas Profelt <office@protom.eu>
 * @since 26.03.2011
 */
namespace RedisTools\Type;

class Hash extends \RedisTools\Core\Dataconstruct
	implements \Countable
{

	/**
	 * sets a single key/value pair into this hash
	 * 
	 * @param string $key
	 * @param string $value
	 * @return int - 1:success, 0:replaced existing value, false on error
	 */
	public function set( $key, $value )
	{
		return $this->getRedis()->hSet(
			$this->getKey(), 
			$key, 
			$value
		);
	}
	
	/**
	 * return the value stored at $key. Returns false if $key 
	 * or this hash do not exist.
	 * 
	 * @param string $key
	 * @return string 
	 */
	public function getValue( $key )
	{
		return $this->getRedis()->hGet( $this->getKey(), $key );
	}


	/**
	 * set a key value pair if key does not already exist
	 * 
	 * @param string $key
	 * @param stirng $value
	 * @return boolean - success
	 */
	public function setIfNotExists( $key, $value )
	{
		return $this->getRedis()->hSetNx( 
			$this->getKey(), 
			$key, 
			$value 
		);
	}

	/**
	 * returns the number of elements in this hash. 
	 * Returns 0 if hash does not exist
	 * 
	 * @return int
	 */
	public function count()
	{
		return $this->getRedis()->hLen($this->getKey());
	}
	
	/**
	 * deletes an e
	 * 
	 * @param type $key
	 * @return type 
	 */
	public function deleteKey( $key )
	{
		return $this->getRedis()->hDel( $this->getKey(), $key);
	}
	
	/**
	 * returns all keys in this hash as indexed array
	 * 
	 * @return array
	 */
	public function getKeys()
	{
		return $this->getRedis()->hKeys( $this->getKey() );
	}
	
	/**
	 * returns all values in this hash as indexed array
	 * 
	 * @return array
	 */
	public function getValues()
	{
		return $this->getRedis()->hVals( $this->getKey() );
	}
	
	/**
	 * returns all key value pairs in this hash as array.
	 * returns empty array if hash does not exists.
	 * 
	 * @return array
	 */
	public function getAll()
	{
		return $this->getRedis()->hGetAll( $this->getKey() );
	}
	
	/**
	 * determine wether $key is set within this hash
	 * 
	 * @param string $key
	 * @return boolean 
	 */
	public function keyExists( $key )
	{
		return $this->getRedis()->hExists( $this->getKey(), $key );
	}
	
	/**
	 * Increments the value of a $key in this hash by $incrementValue.
	 * Creates a new hash or key if $key or hash does not already exist.
	 * Returns false if value on $key is no integer. Returns the new
	 * field value otherwise.
	 * 
	 * @param string $key
	 * @param int $incrementValue
	 * @return int - the new value, false if existing value can not be incremented 
	 */
	public function incrementValue( $key, $incrementValue = 1 )
	{
		return $this->getRedis()->hIncrBy(
			$this->getKey(), 
			$key, 
			$incrementValue 
		);
	}
	
	/**
	 * returns multiple values from this hash. False for nonexisting keys
	 * Example: getMulti(array('key1', 'nonexistingkey')) => array('value1', false)
	 * 
	 * @param array $keys
	 * @return array - an array of key value pairs, false on error
	 */
	public function getMulti( $keys )
	{
		return $this->getRedis()->hMGet( $this->getKey(), $keys );
	}
	
	/**
	 * set multiple key value pairs into this hash
	 * 
	 * @param array $array
	 * @return boolean - success
	 */
	public function setMulti( $array )
	{
		return $this->getRedis()->hMset( $this->getKey(), $array);
	}
}
