<?php
namespace RedisTools\Utils\Reflection;

class PropertyTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Property
	 */
	protected $object;

	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$reflection = new \ReflectionClass(new \RedisTools\Utils\ReflectionDummy);
		$property = current($reflection->getProperties());
		$this->object = new Property(
			$property->getName(), 
			$property->getDocComment()
		);
	}

	public function testSetOptionsNull()
	{
		$this->assertContains('PropertyString', $this->object->getName());
		$this->object->setOptions(null);
		$this->assertNull($this->object->getOptions());
	}
	
	public function testSetOptionsWithArray()
	{
		$options = array('opt1' => 'val1', 'opt2' => 'val2');
		$this->object->setOptions($options);
		foreach($this->object->getOptions() as $key => $value)
		{
			$this->assertEquals($options[$key], $value);
		}
	}
	
	public function testParseOptionFromDocComment()
	{
		$options = $this->object->getOptions();
		$this->assertType('array', $options);
		$this->assertGreaterThan(0, count($options));
		
		$this->assertEquals('String', $options['DbField']);
		$this->assertFalse(isset($options['No']));
		$this->assertEquals('Value', $options['Some']);
		$this->assertEquals('Other', $options['Other']);
	}

}

?>
