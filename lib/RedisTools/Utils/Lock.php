<?php
/**
 * a simple locking mechanism to block operations to be executed in paralell
 * by multiple processes
 * 
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
 * @since 25.03.2011
 * @version 1.0
 */
namespace RedisTools\Utils;

class Lock extends \RedisTools\Core\Dataconstruct
{
	
	/**
	 * returns wether the lock is granted or not
	 * 
	 * @return boolean
	 */
	public function getLock( $ttl = null )
	{
		$result = $this->getRedis()->setnx( $this->getKey(), 1 );
		if($result && $ttl !== null)
		{
			$this->expireAt(\time() + $ttl);
		}
		return $result;
	}
	
	/**
	 * release the lock so other processes can get it
	 * 
	 * @return boolean
	 */
	public function releaseLock()
	{
		return $this->delete();
	}
	
}