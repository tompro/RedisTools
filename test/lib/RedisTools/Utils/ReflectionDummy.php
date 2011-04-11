<?php

/**
 * ReflectionDummy just for testing the reflection class
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 08.04.2011
 */
namespace RedisTools\Utils;

class ReflectionDummy
{
	/**
	 * asdfdsaf
	 * 
	 * this is a lot of annotations here to test differently messed
	 * up doc block comment are parsed correctly
	 * 
	 * asdfsadf
	 * @fake
	 * @Redis
	 * @RedisToolsSome Value
	 * @RedisToolNo Value
	 * @RedisToolsOther Other Value
	 * 
	 * @
	 * @RedisToolsDbField String
	 * @var String
	 */
	private $privatePropertyString;
	
	/**
	 * @RedisToolsDbField String
	 * @var String
	 */
	protected $protectedPropertyString;
	
	/**
	 * @RedisToolsDbField String
	 * @var String
	 */
	public $publicPropertyString;
	
	/**
	 * @var \RedisTools\Type\Set
	 */
	private $privateNoRedisProperty;
	
	/**
	 * @var string
	 */
	protected $protectedNoRedisProperty;
	
	/**
	 * @var string
	 */
	public $publicNoRedisProperty;
}