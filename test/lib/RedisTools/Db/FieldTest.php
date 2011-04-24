<?php

namespace RedisTools\Db;

class FieldTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Field
	 */
	protected $object;

	protected function setUp()
	{
		$valueObject = new ValueObject();
		$this->object = new Field($valueObject, 'name', 'value');
	}

	public function testGetName()
	{
		$this->assertEquals('name', $this->object->getName());
	}

	public function testGetValue()
	{
		$this->assertEquals('value', $this->object->getValue());
	}

	public function testSetValue()
	{
		$this->object->setValue('asdf');
		$this->assertEquals('asdf', $this->object->getValue());
		$this->assertTrue($this->object->isModified());
		
		$this->object->setValue('asdf', false);
		$this->assertTrue($this->object->isModified());
		
		$this->object->setValue('qwer', false);
		$this->assertFalse($this->object->isModified());
	}

}

?>
