<?php
/**
 * 
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 */
class RedisTools
{
	
	const BEFORE = \Redis::BEFORE;
	
	const AFTER = \Redis::AFTER;
	
	
	/**
	 * the default Redis instance
	 * 
	 * @var Redis
	 */
	private static $redis;
	
	/**
	 * sets the default instance of redis
	 * 
	 * @param Redis $redis 
	 * @return void
	 */
	public static function setRedis( Redis $redis )
	{
		self::$redis = $redis;
	}

}
