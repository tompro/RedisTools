<?php
/**
 * manages the functionality of simple Redis string types
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 * @version 1.0
 */
namespace RedisTools\Type;

class String extends \RedisTools\Core\Dataconstruct
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
	public function setValue( $value, $ttl = null )
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
	public function getValue()
	{
		return $this->getRedis()->get( $this->getKey() );
	}
	
	/**
	 * set a new value to this key and returns the old value
	 * 
	 * @param string $value
	 * @return string - false if key is empty 
	 */
	public function getSetValue( $value )
	{
		return $this->getRedis()->getSet($this->getKey(), $value);
	}

	/**
	 * sets a new $value to the key if the key does not exist
	 * 
	 * @param string $value
	 * @return boolean - success 
	 */
	public function setValueIfNotExists( $value )
	{
		return $this->getRedis()->setnx( 
			$this->getKey(), $value );
	}
	
	/**
	 * returns the length of the keys content in bytes
	 * 
	 * @return int - false if key is of wrong type
	 */
	public function getByteLength()
	{
		return $this->getRedis()->strlen($this->getKey());
	}
	
	/**
	 * TODO: implement methods:
	 * 
	 * - append
	 * - getRange (substring)
	 * - setRange (stringreplace)
	 */
	
	
}