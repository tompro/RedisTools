<?php
/**
 * Represents a Db Object String field for simple key value storage
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
namespace RedisTools\Db\Field;
use RedisTools\Db;

class SimpleValue extends Db\Field
{
	/**
	 * Template method to be implemented by descending classes
	 * to perform further db operations eg. deleting indexes and
	 * lookup tables
	 *
	 * @return boolean - success
	 */
	function onDelete()
	{
		return true;
	}

	/**
	 * Template method to be implemented by descending classes
	 * to perform further db operations eg. updating indexes and lookup tables
	 *
	 * @return boolean - success
	 */
	public function onSave()
	{
		return true;
	}

}