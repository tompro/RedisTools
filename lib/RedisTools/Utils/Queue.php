<?php
/**
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
 * @since 01.04.2011
 */
namespace RedisTools\Utils;
use \RedisTools\Type as Type;
use \RedisTools\Core as Core;

class Queue extends Core\Key
{
	/**
	 * the list to be used for this queue
	 * 
	 * @var \RedisTools\Type\ArrayList
	 */
	private $arrayList;
	
	/**
	 * @return Type\ArrayList
	 */
	public function getArrayList()
	{
		if($this->arrayList === null)
		{
			$this->arrayList = new Type\ArrayList( $this->getKey() );
		}
		return $this->arrayList;
	}
	
	/**
	 * @param Type\ArrayList $arrayList 
	 */
	public function setArrayList( Type\ArrayList $arrayList )
	{
		$this->arrayList = $arrayList;
	}

	/**
	 * adds a message string/object/array to this Queue
	 * 
	 * @param mixed $message
	 * @return int - number of messages in this Queue 
	 */
	public function addMessage( $message )
	{
		if($message === null){
			$this->throwException(
				'Invalid argument. Queue message can not be null.'
			);}
		
		return $this->getArrayList()->push( 
			$this->serializeMessage( $message )
		);
	}
	
	/**
	 * fetches and removes a message from this Queue
	 * 
	 * @return mixed - string or StdObject 
	 */
	public function fetchMessage()
	{
		return $this->unserializeMessage( 
			$this->getArrayList()->shift() 
		);
	}
	
	/**
	 * serializes a message to string
	 * 
	 * @param string $message
	 * @return mixed
	 */
	protected function serializeMessage( $message )
	{
		return json_encode( $message );
	}
	
	/**
	 * deserializes a message to an object
	 * 
	 * @param string $message
	 * @return mixed
	 */
	protected function unserializeMessage( $message )
	{
		return json_decode( $message );
	}
}
