<?php
namespace RedisTools\Type;

class ArrayListTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var ArrayList
	 */
	protected $object;

	protected $testKey = 'key';
	
	protected function setUp()
	{
		$redis = new \Redis();
		$redis->pconnect('127.0.0.1');
		
		$this->object = new ArrayList(
			$this->testKey,
			$redis
		);
	}

	protected function tearDown()
	{
		$this->object->delete();
	}

	public function testGetValueAtFromEmptyKey()
	{
		$this->assertFalse(
			$this->object->getValueAt( 0 )
		);
		
		$this->assertFalse(
			$this->object->getValueAt( 5 )
		);
	}
	
	public function testGetValueAt()
	{
		$this->object->push('a');
		$this->object->push('b');
		$this->object->push('c');
		$this->object->push('d');
		
		$this->assertEquals('a',
			$this->object->getValueAt(0)
		);
		
		$this->assertEquals('d',
			$this->object->getValueAt(-1)
		);
		
		$this->assertEquals('d',
			$this->object->getValueAt(3)
		);
		
		$this->assertEquals('c',
			$this->object->getValueAt(2)
		);
		
		$this->assertEquals('b',
			$this->object->getValueAt(-3)
		);
	}

	public function testSetValueOnEmptyKey()
	{
		$this->assertFalse(
			$this->object->setValueAt( 0, 'asdf')
		);
		
		$this->assertFalse(
			$this->object->setValueAt( 4, 'asdf')
		);
	}
	
	public function testSetValue()
	{
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertTrue(
			$this->object->setValueAt( 1, 'd')
		);
		
		$this->assertEquals('d',
			$this->object->getValueAt(1)
		);
		
		$this->assertTrue(
			$this->object->setValueAt( 0, 'c')
		);
		
		$this->assertEquals('c',
			$this->object->getValueAt(0)
		);
		
		$this->assertFalse(
			$this->object->setValueAt( 2, 'a' )
		);
		
		$this->assertTrue(
			$this->object->setValueAt( -1, 'a')
		);
		
		$this->assertEquals('a',
			$this->object->getValueAt(1)
		);
	}
	
	public function testPushToEmptyKeyTail()
	{
		$this->assertEquals(1,
			$this->object->push( 'asdf' )
		);
		
		$this->assertEquals(2,
			$this->object->push( 'qwer' )
		);
		
		$this->assertEquals(3,
			$this->object->push( 'qwer' )
		);
		
		$this->assertEquals('qwer',
			$this->object->getValueAt(2)
		);
	}
	
	public function testPushToEmptyKeyHead()
	{
		$this->assertEquals(1,
			$this->object->push( 'asdf', true )
		);
		
		$this->assertEquals(2,
			$this->object->push( 'qwer', true )
		);
		
		$this->assertEquals(3,
			$this->object->push( 'qwer', true )
		);
		
		$this->assertEquals('asdf',
			$this->object->getValueAt(2)
		);
	}
	
	public function testPushToEmptyKeyProtectedTail()
	{
		$this->assertEquals(0,
			$this->object->push( 'asdf', false, false )
		);
		
		$this->assertFalse(
			$this->object->getValueAt(0)
		);
		
		$this->assertEquals(1,
			$this->object->push( 'asdf' )
		);
		
		$this->assertEquals(2,
			$this->object->push( 'qwer', false, false )
		);
		
		$this->assertEquals('qwer',
			$this->object->getValueAt(1)
		);
	}
	
	public function testPushToEmptyKeyProtectedHead()
	{
		$this->assertEquals(0,
			$this->object->push( 'asdf', true, false )
		);
		
		$this->assertFalse(
			$this->object->getValueAt(0)
		);
		
		$this->assertEquals(1,
			$this->object->push( 'asdf', true )
		);
		
		$this->assertEquals(2,
			$this->object->push( 'qwer', true, false )
		);
		
		$this->assertEquals('asdf',
			$this->object->getValueAt(1)
		);
	}
	
	public function testPopValueOfEmptyKey()
	{
		$this->assertFalse(
			$this->object->pop()
		);
	}
	
	public function testPopValue()
	{
		$this->fail('no tests');
	}
	
	public function testShiftValueOfEmptyKey()
	{
		$this->assertFalse(
			$this->object->shift()
		);
	}
	
	public function testShiftValue()
	{
		$this->fail('no tests');
	}

}

?>
