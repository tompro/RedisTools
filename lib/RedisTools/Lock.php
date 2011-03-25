<?php
/**
 * a simple locking mechanism to block operations to be executed in paralell
 * by multiple processes
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 25.03.2011
 * @version 1.0
 */
namespace RedisTools;

class Lock extends Core\Dataconstruct
{
	
	/**
	 * returns wether the lock is granted or not
	 * 
	 * @return boolean
	 */
	public function getLock()
	{
		return $this->getRedis()->setnx( $this->getKey(), 1 );
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