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
	 * Wether this object has been saved to Redis or not
	 * 
	 * @var boolean
	 */
	private $isPersistent;
	
	/**
	 * Wether this object has been saved to Redis or not
	 * 
	 * @var boolean
	 */
	private $isLoaded = false;
	
	/**
	 * @var \RedisTools\Type\Hash 
	 */
	private $hash;
	
	/**
	 * @return \RedisTools\Type\Hash
	 */
	protected function getHash()
	{
		if($this->hash === null)
		{
			$this->hash = new \RedisTools\Type\Hash(
				$this->key, $this->redis
			);
		}
		return $this->hash;
	}
	
	/**
	 * Sets the unique Redis key for this value object and initializes
	 * all RedisTools properties. If a key has been set before on this 
	 * object all properties are reinitialized.
	 * 
	 * @param string $key 
	 */
	public function setKey( $key )
	{
		if($key !== null && $key !== $this->key)
		{
			parent::setKey( $key );
			$this->getHash()->setKey($key);
			$this->initRedisProperties();
		}
	}
	
	/**
	 * @param \Redis $redis 
	 */
	public function setRedis( $redis )
	{
		if($redis !== null)
		{
			parent::setRedis( $redis );
			$this->getHash()->setRedis($redis);
		}
	}

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
	 * Constructs a RedisTools ValueObject that can define RedisTools properties
	 * via annotated internal class properties.
	 * 
	 * @param Core\Key $key
	 * @param \Redis $redis
	 * @param Utils\Reflection $reflector 
	 */
	public function __construct($key = null, $redis = null )
	{
		parent::__construct($key, $redis);
	}

	/**
	 * initalizes all RedisToolsProperties 
	 */
	private function initRedisProperties()
	{
		/* @var $property Utils\Reflection\Property */
		foreach($this->getRedisToolsProperties() as $key => $property)
		{
			if($property->isDbField())
			{
				$this->$key = $property->getDbFieldClass();
			}
		}
		$this->isLoaded = false;
	}
	
	/**
	 * Sets the value of RedisDbField property $name to $value
	 * @param string $name
	 * @param string $value 
	 */
	public function set( $name, $value )
	{
		if(property_exists( $this, $name))
		{
			if($this->$name instanceof Field)
			{
				$this->$name->setValue($value);
				return $this;
			}
			$this->$name = $value;
			return $this;
		}
		
		throw new \RedisTools\Exception(
			"Given Property Name: '$name' is no property of this class."
		);
	}
	
	/**
	 * Returns the value of a RedisProperty defined with $name
	 * 
	 * @param type $name
	 * @return type 
	 */
	public function get( $name )
	{
		$this->load();
		if(property_exists( $this, $name))
		{
			if($this->$name instanceof Field)
			{
				return $this->$name->getValue();
			}
			return $this->$name;
		}
		
		throw new \RedisTools\Exception(
			"Given Property Name: '$name' is no property of this class."
		);
	}
	
	/**
	 * Returns an array of property names that should be
	 * loaded from the basic hash object.
	 * 
	 * @return array 
	 */
	protected function getLoadProperties()
	{
		$result = array();
		foreach($this->getRedisToolsProperties() as $property)
		{
			$result[] = $property->getName();
		}
		return $result;
	}
	
    /**
     * Returns all properties of this value object that have been
     * changend and have not been saved so far. The resulting array has
     * the fields names as key and the property object as its value. 
     *
     * Exammple: array('myPropertyName' => [Field object])
     *
     * @return array
     */
	protected function getSaveProperties()
	{
		$result = array();
		/* @var $key Field */
		foreach($this->getRedisToolsProperties() as $key => $property)
		{
			if($this->$key->isModified())
			{
				$result[$this->$key->getName()] = $this->$key;
			}
		}
		return $result;
	}

	protected function load()
	{
		if( ! $this->isLoaded )
		{
			$values = $this->getHash()->getMulti(
				$this->getLoadProperties()
			);

			/* @var $key Field */
			foreach( $values as $key => $value )
			{
				if($value)
				{
					$this->$key->setValue($value, false);
				}
			}
		}
		$this->isLoaded = true;
	}
	
	public function save()
	{
		/* @var $properties Field */
		$properties = $this->getSaveProperties();
		$toSave = array();
		
		/* @var $property Field */
		foreach($properties as $property)
		{
			if($property->onSave() && $property->hasObjectValue())
			{
				$toSave[$property->getName()] = $property->getValue();
			}
		}

		if($this->getHash()->setMulti($toSave))
		{
			foreach($toSave as $key => $value)
			{
				$properties[$key]->setModified(false);
			}
		}
		
		$this->setIsPersistent(true);
	}
	
	/**
	 * Wether this object has unsaved RedisProperties or not
	 * 
	 * @return boolean
	 */
	public function isSaved()
	{
		if($this->isPersistent())
		{
			return ( count($this->getSaveProperties()) === 0); 
		}
		return false;
	}
	
	/**
	 * Determine wether this object has been saved to db already.
	 * Nevertheless this value does not indicate that the currently
	 * set values are all in sync with the database. To determine that
	 * you have to call <code>ValueObject::isSaved()</code>.
	 * 
	 * @return boolean
	 */
	public function isPersistent()
	{
		if($this->isPersistent === null)
		{
			try 
			{
				$this->setIsPersistent(
					$this->getHash()->exists()
				);
			}
			catch ( \RedisTools\Exception $e )
			{
				return false;
			}
		}
		
		return $this->isPersistent;
	}

	/**
	 * @param boolean $boolean 
	 */
	protected function setIsPersistent( $boolean )
	{
		$this->isPersistent = $boolean;
	}
	
	

}