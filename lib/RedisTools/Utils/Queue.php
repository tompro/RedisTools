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
 * @package Protom_
 * @author Thomas Profelt <office@protom.eu>
 * @since 01.04.2011
 */
class Queue
{
	
	/**
	 * If at least one of the lists $keys contains at least one element, 
	 * the element will be popped from the head of the list and returned. 
	 * Il all the list identified by the keys passed in arguments are empty, 
	 * blPop will block during the specified timeout until an element is 
	 * pushed to one of those lists. This element will be popped.
	 * 
	 * Example: blPop(array('list1', 'list2'), 10){}
	 * 
	 * @param type $keys - array of keys identifying a list
	 * @param type $timeout - seconds to wait for an element
	 * @return array - array('listname', 'elementvalue'){} 
	 */
	//public function blPop( $keys, $timeout ){}
	
	/**
	 * If at least one of the lists $keys contains at least one element, 
	 * the element will be popped from the end of the list and returned. 
	 * Il all the list identified by the keys passed in arguments are empty, 
	 * brPop will block during the specified timeout until an element is 
	 * pushed to one of those lists. This element will be popped.
	 * 
	 * Example: brPop(array('list1', 'list2'), 10){}
	 * 
	 * @param type $keys - array of keys identifying a list
	 * @param type $timeout - seconds to wait for an element
	 * @return array - array('listname', 'elementvalue'){} 
	 */
	//public function brPop( $keys, $timeout ){}
	
}
