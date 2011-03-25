<?php
/**
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 */
namespace PRTools\Core;

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
		
		throw new \PRTools\Exception(
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

	protected function validateKey( $key )
	{
		if ( ! is_string($key) ) 
		{ $this->throwException('Redis key must be a string!'); }
		
        if (!preg_match('~^[a-zA-Z0-9_]+$~D', $key)) 
		{ $this->throwException('Redis key should only consist of a-z A-Z 0-9 _'); }
		
		return $key;
	}
	
	/**
	 * throw a PRTools Exception with a message
	 * 
	 * @param string $message 
	 */
	protected function throwException( $message = 'An error occured in PRTools' )
	{
		throw new \PRTools\Exception( $message );
	}
	
}
