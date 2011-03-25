<?php
/**
 * Basic Redis function common for all Redis data constructs
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
	 * that are provide by the 
	 * <ahref="https://github.com/nicolasff/phpredis">phpredis plugin</a>
	 * 
	 * @param mixed $redis 
	 */
	public function setRedis( $redis )
	{
		$this->redis = $redis;
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
	 * determine wether this key already exists
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
	public function ttl()
	{
		return $this->getRedis()->ttl( $this->getKey() );
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
