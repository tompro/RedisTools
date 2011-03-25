<?php
/**
 * manages the functionality of simple key-value types
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 * @version 1.0
 */
namespace RedisTools;

class Key extends Core\Dataconstruct
{
	
	/**
	 * set a simple string $value into this Key
	 * the optional $ttl lets this Key expire after
	 * $ttl seconds
	 * 
	 * @param string $value
	 * @param int $ttl - the time to live in seconds
	 * @return boolean - success of operation
	 */
	public function set( $value, $ttl = null )
	{
		if( $ttl === null )
		{
			return $this->getRedis()->set( 
				$this->getKey(), 
				$value 
			);
		}
		
		return $this->getRedis()->setex( 
			$this->getKey(), 
			$ttl, 
			$value 
		);
	}
	
	/**
	 * returns the string value stored in a key
	 * 
	 * @return string | boolean false if key does not exists
	 */
	public function get()
	{
		return $this->getRedis()->get( $this->getKey() );
	}
	
	/**
	 * deletes this key and value
	 * 
	 * @return boolean - success
	 */
	public function delete()
	{
		return $this->getRedis()->delete( $this->getKey() );
	}
	
	/**
	 * returns the remaining time to live of this key in 
	 * seconds. Returns -1 if key has no expire date
	 * 
	 * @return int - the remaining time to live in seconds 
	 */
	public function ttl()
	{
		return $this->getRedis()->ttl( $this->getKey() );
	}
	
	/**
	 * determine wether this key already exists
	 * @return boolean
	 */
	public function exists()
	{
		return $this->getRedis()->exists( $this->getKey() );
	}
	
	/**
	 * sets a new $value to the key if the key does not exist
	 * 
	 * @param string $value
	 * @return boolean - success 
	 */
	public function setIfNotExists( $value )
	{
		return $this->getRedis()->setnx( 
			$this->getKey(), $value );
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
	
}