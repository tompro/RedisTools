<?php
/**
 * Unittest bootstraping
 * 
 * @author protom
 */


error_reporting(E_ALL);

ini_set(
	'include_path', 
	ini_get('include_path')
	.PATH_SEPARATOR.dirname(__FILE__).'/../lib/'
	.PATH_SEPARATOR.dirname(__FILE__).'/lib/'
);

function loadClass($className) 
{
	$path = str_replace('\\', '/', $className);
	try{
		require_once $path . '.php';
	}catch(Exception $e){}
}

spl_autoload_register('loadClass');

?>
