<?php
/**
 * manages the functionality of simple key-value types
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 24.03.2011
 */
namespace PRTools;

class Key extends Core\Dataconstruct
{
	
	/**
	 * @var mixed - can contain basic datatypes (string, int, ...)
	 */
	protected $value = false;

	
	public function set( $value )
	{
		if($this->getRedis()->set( $this->getKey(), $value ))
		{
			$this->value = $value;
			return true;
		}
		
		return false;
	}
	
	public function get()
	{
		if( ! $this->value )
		{
			$this->value = $this->getRedis()->get( $this->getKey() );
		}
		return $this->value;
	}
	
	public function delete()
	{
		$result = $this->getRedis()->delete( $this->getKey() );
		if($result === 1)
		{
			$this->value = false;
		}
		return $result;
	}
	
}
