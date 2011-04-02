<?php
/**
 * Manages Bitmaps stored in Redis keys
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
 * @author Thomas Profelt <office@protom.eu>
 * @since 28.03.2011
 */
namespace RedisTools\Type;

class Bitmap extends \RedisTools\Core\Dataconstruct
{
	
	/**
	 * sets a $bit (0 or 1) a position $index, fills up
	 * all unset values before $index with 0
	 * 
	 * @param int $index
	 * @param int $bit
	 * @return int - the previous bit value 
	 */
	public function setBit( $index, $bit )
	{
		return $this->getRedis()->setBit($this->getKey(), $index, $bit);
	}
	
	/**
	 * returns a single bit value from position $index, returns
	 * 0 for all indexes that have not been set.
	 * 
	 * @param int $index
	 * @return int 
	 */
	public function getBit( $index )
	{
		return $this->getRedis()->getBit($this->getKey(), $index);
	}

}
