<?php

/**
 * Core functions for Redis key handling
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
 * @since 04.04.2011
 */
namespace RedisTools\Core;

class Key
{
	
	/**
	 * @var string
	 */
	protected $key;
	
	/**
	 * @var \Redis
	 */
	protected $redis;

	/**
	 * @param string $key
	 * @param mixed $redis - the connected redis instance
	 */
	public function __construct( $key = null, $redis = null )
	{
		$this->setKey($key);
		$this->setRedis( $redis );
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
	
}