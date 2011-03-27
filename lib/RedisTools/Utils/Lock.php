<?php
/**
 * a simple locking mechanism to block operations to be executed in paralell
 * by multiple processes
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
		$this->delete();
		return true;
	}
	
}