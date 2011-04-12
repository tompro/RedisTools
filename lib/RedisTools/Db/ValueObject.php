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

class ValueObject extends Core\Dataconstruct
{
	/**
	 * @var Utils\Reflection
	 */
	private $reflector;
	
	/**
	 * @return Utils\Reflection
	 */
	public function getReflector()
	{
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
	
}