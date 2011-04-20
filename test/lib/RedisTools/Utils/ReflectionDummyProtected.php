<?php

/**
 * ReflectionDummy just for testing the reflection class
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 08.04.2011
 */
namespace RedisTools\Utils;

class ReflectionDummyProtected
{
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
}