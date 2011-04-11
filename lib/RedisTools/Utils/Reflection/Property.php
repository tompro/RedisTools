<?php
/**
 * Property
 * 
 * Copyright (c) 2011 Thomas Profelt
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 * 
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 * 
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 * 
 * 
 * @author Thomas Profelt <office@protom.eu>
 * @since 11.04.2011
 */
namespace RedisTools\Utils\Reflection;

class Property
{
	
	/**
	 * the property name
	 * 
	 * @var String
	 */
	private $name;
	
	/**
	 * contains RedisToolsProperty options for this property
	 * 
	 * @var array
	 */
	private $options;


	/**
	 * Creates a new Redis Property with name $name and an 
	 * optional options array or string. 
	 * 
	 * If options are given as string the string is parsed for
	 * doc block annotations that are converted to options.
	 * 
	 * @param String $name
	 * @param array | string - the redis options 
	 */
	public function __construct( $name = null, $options = null )
	{
		$this->setName($name);
		$this->setOptions($options);
	}

	/**
	 * Returns the RedisTools options of this property
	 * 
	 * @return array
	 */
	public function getOptions()
	{
		return $this->options;
	}
	
	/**
	 * sets the options for this property either as array
	 * or as a string containing docblock comment formatted @RedisTools
	 * properties.
	 * 
	 * @param array | string $options 
	 */
	public function setOptions( $options )
	{
		if(  is_array( $options))
		{
			$this->options = $options;
		}
		elseif( is_string( $options ) )
		{
			$this->options = $this->parseDocHeader($options);
		}
		else
		{
			$this->options = $options;
		}
	}
	
	
	/**
	 * Parses property doc headers for RedisTools annotations
	 * and returns them as $options array with name/value pairs for this Property
	 * 
	 * @param String $docHeader
	 * @return array 
	 */
	private function parseDocHeader( $docHeader )
	{
		$options = array();
		$string =  trim(preg_replace('/\t *\*. */', ' ', $docHeader));
		$lines = explode("\n", $string);
		
		$pattern = '/'.\RedisTools\Utils\Reflection::REDIS_PROPERTY_PREFIX.'/';
		$lines = preg_grep( $pattern, $lines );
		foreach($lines as $line)
		{
			$elements = explode(' ', trim($line) );
			if( isset($elements[0]) && isset($elements[1]) )
			{
				$name = str_replace('@RedisTools', '', $elements[0]);
				$value = trim($elements[1]);
				$options[$name] = $value;
			}
		}
		
		return $options;
	}

		
	/**
	 * @return String
	 */
	public function getName()
	{
		return $this->name;
	}
	
	/**
	 * @param String $name 
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}


}