<?php
/**
 * Helper Class for generating unique id hashes
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 23.03.2011
 */
namespace PRTools\Utils;

class Uid
{

	/**
	 * generates a unique id hash
	 * 
	 * @return string
	 */
	public function generate( $seed = '' )
	{
		$chars = range('a','z');
		$numbers = range(0, 50);
		
		shuffle( $chars );
		shuffle( $numbers );
		
		$string = implode(':', $chars) . \implode( ':', $numbers );
		$string .= microtime() .  mt_rand(1, 999999);
		
		return md5($string . $seed);
	}

}
