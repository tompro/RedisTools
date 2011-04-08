<?php

/**
 * Inflection
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
namespace RedisTools\Utils;

class Reflection
{
	
	protected $object;
	
	/**
	 * @var \ReflectionClass
	 */
	protected $reflector;
	
	/**
	 *
	 * @return \ReflectionClass
	 */
	public function getReflector() 
	{
		if($this->reflector === null)
		{
			$this->reflector = new \ReflectionClass( $this->getObject() );
			
		}
		return $this->reflector;
	}
		
	public function getObject()
	{
		if(is_object($this->object) )
		{
			return $this->object;
		}
		
		throw new \RedisTools\Exception(
			'RedisTools reflection needs an object to be set before accessing inflection methods.'
		);
	}

	public function setObject( $object )
	{
		$this->object = $object;
	}
	
	public function __construct( $object = null )
	{
		$this->setObject($object);
	}
	
	public function getRedisToolsProperties()
	{
		return $this->filterRedisToolsProperties();
	}
	
	protected function filterRedisToolsProperties()
	{
		$result = array();
		
		foreach($this->getReflector()->getProperties() as $property)
		{
			$doc = $property->getDocComment();
			if(strstr($doc, 'RedisToolsDbField'))
			{
				$result[] = $property;
			}
			
		}
		
		return $result;
	}
	
	


}