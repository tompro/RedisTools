<?php
/**
 * Unittest bootstraping
 * 
 * @author protom
 */

error_reporting(E_ALL);

ini_set(
	'include_path', 
	ini_get('include_path').PATH_SEPARATOR.dirname(__FILE__).'/../lib/'
);

function __autoload($className) 
{
	$path = str_replace('\\', '/', $className);
    require_once $path . '.php';
}

?>
