<?php
/**
 * RedisTools ValueObject can define RedisTools properties
 * via annotated internal class properties. Those properties are converted to
 * according RedisTools DB fields. 
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
 * @since 08.04.2011
 */
namespace RedisTools\Db;
use RedisTools\Utils;
use RedisTools\Core;
use RedisTools\Type;

class ValueObject extends Core\Key
{
	
	/**
	 * contains Redis Property descriptions for all
	 * instances of RedisTools ValueObjects and decending
	 * classes for reflection caching.
	 * 
	 * @var array
	 */
	private static $reflectionData = array();
	
	/**
	 * @var Utils\Reflection
	 */
	private $reflector;
	
	/**
	 * @var Type\Hash
	 */
	private $hash;


	/**
	 * @return Utils\Reflection
	 */
	public function getReflector()
	{
		if($this->reflector === null)
		{
			$this->reflector = new Utils\Reflection($this);
		}
		return $this->reflector;
	}
	
	/**
	 * @param Utils\Reflection $reflector 
	 */
	public function setReflector( $reflector )
	{
		$this->reflector = $reflector;
	}
	
	/**
	 * returns the RedisTools properties of this class
	 * 
	 * @return array
	 */
	protected function getRedisToolsProperties()
	{
		$class = get_class($this);
		if( ! isset(self::$reflectionData[$class]))
		{
			self::$reflectionData[$class] = $this->getReflector()->getRedisToolsProperties();
		}
		return self::$reflectionData[$class];
	}
	
	/**
	 * @return Type\Hash
	 */
	public function getHash()
	{
		return $this->hash;
	}
	
	/**
	 * @param Type\Hash $hash 
	 */
	public function setHash( $hash )
	{
		$this->hash = $hash;
	}
		
	/**
	 * Constructs a RedisTools ValueObject that can define RedisTools properties
	 * via annotated internal class properties.
	 * 
	 * @param Core\Key $key
	 * @param \Redis $redis
	 * @param Utils\Reflection $reflector 
	 */
	public function __construct($key = null, $redis = null, $reflector = null )
	{
		parent::__construct($key, $redis);
		$this->setReflector($reflector);
	}
	
	/**
	 * sets redis property values
	 * 
	 * @param string $name
	 * @param mixed $value 
	 */
	public function __set( $name, $value )
	{
		
	}
	
	/**
	 * returns redis property values
	 * 
	 * @param String $name 
	 */
	public function __get( $name )
	{
		
	}
	
	protected function load()
	{
		$values = $this->getHash()->getMulti( $this->getFields() );
		$this->populateValues($values);
	}
	
	protected function getFields()
	{
		$result = array();
		foreach($this->getReflector()->getRedisToolsProperties() as $property)
		{
			$result[] = $property->getName();
		}
		return $result;
	}
	
	protected function populateValues( $values )
	{
		foreach($values as $key => $value)
		{
			$this->$key = $value;
		}
	}

	public function save()
	{
		$values = array();
		foreach ($this->getRedisToolsProperties() as $property)
		{
			$name = $property->getName();
			$values[$name] = $this->$name;
		}
		
		$this->getHash()->setMulti($values);
	}
}