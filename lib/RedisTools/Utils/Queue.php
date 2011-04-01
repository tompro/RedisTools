<?php

/**
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
