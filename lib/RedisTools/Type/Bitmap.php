<?php
/**
 * Manages Bitmaps stored in Redis keys
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
