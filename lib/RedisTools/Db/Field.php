<?php
/**
 * Base class for all sorts of db object fields
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
 * @since 12.04.2011
 */
namespace RedisTools\Db;

class Field
{
	/**
	 * name of this field
	 * 
	 * @var string
	 */
	protected $name;
	
	/**
	 * value of this field
	 * 
	 * @var string
	 */
	protected $value;
	
	/**
	 * wether this field has changed
	 * 
	 * @var boolean
	 */
	protected $isModified;

	/**
	 * Returns the name of this field
	 * 
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * Sets the name of this field
	 * 
	 * @param string $name 
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * Returns the value of this field
	 * 
	 * @return string
	 */
	public function getValue()
	{
		return $this->value;
	}

	/**
	 * Sets the value of this field
	 * 
	 * @param string $value 
	 */
	public function setValue( $value, $modified = true )
	{
		if( $this->value != $value )
		{
			$this->value = $value;
			$this->setModified($modified);
		}
	}
	
	/**setIsModified
	 * Returns wether this field has been modified
	 * 
	 * @return boolean
	 */
	public function isModified()
	{
		return $this->isModified;
	}

	/**
	 * Sets wether this field has been modified
	 * 
	 * @param boolean $boolean 
	 */
	public function setModified( $boolean )
	{
		$this->isModified = $boolean;
	}

				
	/**
	 * @param string $name
	 * @param string $value 
	 */
	public function __construct( $name = null, $value = null, $modified = false )
	{
		$this->setName($name, $modified);
		$this->setValue($value, $modified);
	}


}