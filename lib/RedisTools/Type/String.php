<?php
/**
 * Manages the functionality of simple Redis string types.
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
	 * ATTENTION:
	 * Keep in mind that string operations are byte base, 
	 * so operations on utf-8 string will not deliver the expected 
	 * characters.
	 * 
	 * @return int - false if key is of wrong type
	 */
	public function getLength()
	{
		return $this->getRedis()->strlen($this->getKey());
	}
	
	/**
	 * appends a string to the string currently saved in key
	 * 
	 * @param string $string
	 * @return int - the length of the new string in bytes 
	 */
	public function append( $string )
	{
		return $this->getRedis()->append($this->getKey(), $string);
	}
	
	/**
	 * returns a part of the string stored at key. 
	 * 
	 * Substrings start at $startIndex (zero based) and ends with 
	 * $endIndex (defaults to end of string). Empty keys return 
	 * an empty string. 
	 * 
	 * ATTENTION:
	 * Keep in mind that string operations are byte base, 
	 * so operations on utf-8 string will not deliver the expected 
	 * characters.
	 * 
	 * @param int $startIndex
	 * @param int $endIndex
	 * @return string 
	 */
	public function getSubstring( $startIndex, $endIndex = -1 )
	{
		return $this->getRedis()->getRange($this->getKey(), $startIndex, $endIndex);
	}
	
	/**
	 * sets a part of the string stored at key. 
	 * 
	 * Substring starts at $startIndex (default to first position) 
	 * and ends at the length of $string. Empty keys are set to the  
	 * substring. Every offset given in start string and not already
	 * filled with characters is filled with null values.
	 * 
	 * ATTENTION:
	 * Keep in mind that string operations are byte base, 
	 * so operations on utf-8 string will not deliver the expected 
	 * characters.
	 * 
	 * @param string $startIndex
	 * @param int $endIndex
	 * @return int - the new length of the string 
	 */
	public function setSubsting( $string, $startIndex = 0 )
	{
		return $this->getRedis()->setRange($this->getKey(), $startIndex, $string);
	}
	
}