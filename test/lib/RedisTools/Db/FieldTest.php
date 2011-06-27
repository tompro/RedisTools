<?php

namespace RedisTools\Db;

class FieldTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Field
	 */
	protected $object;

	/**
	 * @var ValueObject
	 */
	protected $valueObject;


	protected function setUp()
	{
		$this->valueObject = new ValueObject();
		$this->object = new FieldDummy($this->valueObject, 'name', 'value');
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
	
	public function testOnSave()
	{
		$this->assertTrue($this->object->onSave());
	}

	public function testOnDelete()
	{
		$this->assertTrue($this->object->onDelete());
	}
}

?>
