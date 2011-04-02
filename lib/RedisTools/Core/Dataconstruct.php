<?php
/**
 * Basic Redis function common for all Redis data constructs
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
 * @since 24.03.2011
 */
namespace RedisTools\Core;

class Dataconstruct
{

	/**
	 * @var \Redis
	 */
	protected $redis;

	/**
	 * @var string
	 */
	protected $key;

	/**
	 * @param string $key
	 * @param mixed $redis - the connected redis instance
	 */
	public function __construct( $key = null, $redis = null )
	{
		$this->setKey( $key );
		$this->setRedis( $redis );
	}

	/**
	 * returns the key to identify a redis data construct
	 * 
	 * @param string $key 
	 */
	public function getKey()
	{
		return $this->validateKey($this->key);
	}

	/**
	 * sets the key that identifys a redis data construct
	 * 
	 * @param string $key 
	 */
	public function setKey( $key )
	{
		$this->key = $key;
	}
	
	/**
	 * returns the currently configured Redis instance
	 * 
	 * @return Redis
	 */
	public function getRedis()
	{
		If($this->redis !== null)
		{
			return $this->redis;
		}
		
		throw new \RedisTools\Exception(
			'No Redis instance provided!'
		);
	}

	/**
	 * the connected redis instance to be used
	 * the instance has to implement all functions
	 * that are provide by phpredis {@link https://github.com/nicolasff/phpredis}
	 * 
	 * @param mixed $redis 
	 */
	public function setRedis( $redis )
	{
		$this->redis = $redis;
	}
	
	/**
	 * deletes this dataconstruct from Redis
	 * 
	 * @return boolean - success
	 */
	public function delete()
	{
		return $this->getRedis()->delete( $this->getKey() );
	}
	
	
	/**
	 * determine wether a dataconstruct with the configured key already exists
	 * @return boolean
	 */
	public function exists()
	{
		return $this->getRedis()->exists( $this->getKey() );
	}
	
	/**
	 * returns the remaining time to live of this key in 
	 * seconds. Returns -1 if key has no expire date
	 * 
	 * @return int - the remaining time to live in seconds 
	 */
	public function getTtl()
	{
		return $this->getRedis()->ttl( $this->getKey() );
	}
	
	/**
	 * sets the remaining time to live in seconds for this dataconstruct
	 * 
	 * @param int $seconds
	 * @return boolean - success 
	 */
	public function setTtl( $seconds )
	{
		return $this->getRedis()->expire($this->getKey(), $seconds);
	}


	/**
	 * set an expiration date for this key.
	 * Accepts a unix timestamp. Returns false if key
	 * does not exist.
	 * 
	 * @param int $timestamp
	 * @return boolean - success 
	 */
	public function expireAt( $timestamp )
	{
		return $this->getRedis()->expireAt( 
			$this->getKey(), 
			$timestamp 
		);
	}
	
	/**
	 * returns the type of this dataconstruct
	 * 
	 * @return int - the type constant eg. Redis::REDIS_LIST
	 */
	public function getType()
	{
		return $this->getRedis()->type( $this->getKey() );
	}


	/**
	 * renames the key of this dataconstruct
	 * 
	 * @param string $newKey 
	 * @return boolean - success (also true on empty key)
	 */
	public function renameKey( $newKey )
	{
		$result = $this->getRedis()->renameKey($this->getKey(), $newKey);
		if($result)
		{
			$this->setKey($newKey);
		}
		return $result;
	}
	
	/**
	 * moves this dataconstruct to another database
	 * 
	 * @param int $db - the db to move to
	 * @return boolean - success
	 */
	public function moveToDb( $db )
	{
		return $this->getRedis()->move($this->getKey(), 1);
	}

	/**
	 * validates a given key
	 * 
	 * @param string $key
	 * @return string
	 */
	protected function validateKey( $key )
	{
		if ( ! is_string($key) ) 
		{ $this->throwException('Redis key must be a string!'); }
		
        if (!preg_match('~^[a-zA-Z0-9_]+$~D', $key)) 
		{ $this->throwException('Redis key should only consist of a-z A-Z 0-9 _'); }
		
		return $key;
	}
	
	/**
	 * throw a RedisTools Exception with a message
	 * 
	 * @param string $message 
	 */
	protected function throwException( $message = 'An error occured in RedisTools' )
	{
		throw new \RedisTools\Exception( $message );
	}
	
	/**
	 * renames the key of this dataconstruct only if the target key does not
	 * already exist.
	 * 
	 * @param string $newKey
	 * @return boolean - success
	 */
	public function renameKeyNx( $newKey )
	{
		$result = $this->getRedis()->renameNx( $this->getKey(), $newKey );
		if($result)
		{
			$this->setKey( $newKey );
		}
		return $result;
	}
}
