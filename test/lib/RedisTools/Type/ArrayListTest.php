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
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertEquals('b', 
			$this->object->pop()
		);
		$this->assertEquals('a', 
			$this->object->pop()
		);
		$this->assertFalse(
			$this->object->pop()
		);
	}
	
	public function testShiftValueOfEmptyKey()
	{
		$this->assertFalse(
			$this->object->shift()
		);
	}
	
	public function testShiftValue()
	{
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertEquals('a', 
			$this->object->shift()
		);
		$this->assertEquals('b', 
			$this->object->shift()
		);
		$this->assertFalse(
			$this->object->shift()
		);
	}
	
	public function testTrimEmptyList()
	{
		$this->assertTrue(
			$this->object->trim(0)
		);
	}
	
	public function testTrimListToCompleteAndToLongLength()
	{
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertTrue(
			$this->object->trim(0)
		);
		
		$this->assertEquals('b',
			$this->object->pop()
		);
		
		$this->assertEquals('a',
			$this->object->pop()
		);
		
		$this->assertFalse(
			$this->object->pop()
		);
		
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertTrue(
			$this->object->trim(0, 10)
		);
	}
	
	public function testTrimList()
	{
		$this->object->push('a');
		$this->object->push('b');
		$this->object->push('c');
		
		$this->assertTrue(
			$this->object->trim(1)
		);
		
		$this->assertEquals('b',
			$this->object->shift()
		);
		
		$this->object->push('a', true);
		
		$this->assertTrue(
			$this->object->trim(0, 1)
		);
		
		$this->assertEquals('c',
			$this->object->pop()
		);
	}
	
	public function testCountOnEmptyKey()
	{
		$this->assertEquals(0,
			$this->object->count()
		);
	}
	
	public function testCount()
	{
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertEquals(2,
			$this->object->count()
		);
		
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertEquals(4,
			$this->object->count()
		);
		
		$this->assertEquals(4,
			count($this->object)
		);
	}
	
	public function testIteratorInterface()
	{
		$elements = array('a', 'b', 'c');
		
		$this->object->push('a');
		$this->object->push('b');
		$this->object->push('c');
		
		$index = 0;
		
		foreach ($this->object as $key => $value)
		{
			$this->assertEquals($index, $key);
			$this->assertEquals($elements[$index], $value);
			$index++;
		}
		
	}
	
	public function testInserBeforeValueOnEmptyList()
	{
		$this->assertEquals(0,
			$this->object->insertBeforeValue( 'b', 'a' )
		);
	}
	
	public function testInserAfterValueOnEmptyList()
	{
		$this->assertEquals(0,
			$this->object->insertAfterValue( 'a', 'b' )
		);
	}
	
	public function testInsertBeforeValueValueNotExisting()
	{
		$this->object->push('b');
		$this->assertEquals(-1,
			$this->object->insertBeforeValue( 'd', 'c' )
		);
		$this->assertEquals(1, count($this->object));
	}
	
	public function testInsertAfterValueValueNotExisting()
	{
		$this->object->push('a');
		$this->assertEquals(-1,
			$this->object->insertAfterValue( 'c', 'd' )
		);
		$this->assertEquals(1, count($this->object));
	}
	
	public function testInsertBeforeValue()
	{
		$this->object->push('b');
		$this->assertEquals(2,
			$this->object->insertBeforeValue( 'b', 'a')
		);
		$this->assertEquals('a',
			$this->object->getValueAt(0)
		);
	}
	
	public function testInsertAfterValue()
	{
		$this->object->push('a');
		$this->assertEquals(2,
			$this->object->insertAfterValue( 'a', 'b')
		);
		$this->assertEquals('b',
			$this->object->getValueAt(1)
		);
	}
	
	public function testInsertBeforeValueWithMultipleValues()
	{
		$this->object->push('b');
		$this->object->push('b');
		$this->object->push('b');
		
		$this->assertEquals(4,
			$this->object->insertBeforeValue( 'b', 'a')
		);
		$this->assertEquals('a',
			$this->object->getValueAt(0)
		);
	}
	
	public function testInsertAfterValueWithMultipleValues()
	{
		$this->object->push('a');
		$this->object->push('a');
		$this->object->push('a');
		
		$this->assertEquals(4,
			$this->object->insertAfterValue( 'a', 'b')
		);
		$this->assertEquals('b',
			$this->object->getValueAt(1)
		);
	}
	
	public function testSliceOnEmptyKey()
	{
		$result = $this->object->slice(0);
		$this->assertType('array', $result);
		$this->assertEquals(0, count($result));
	}
	
	public function testSlice()
	{
		$this->object->push('a');
		$this->object->push('b');
		$this->object->push('c');
		
		$result = $this->object->slice(0);
		$this->assertType('array', $result);
		$this->assertEquals(3, count($result));
		
		$result = $this->object->slice(0, 1);
		$this->assertType('array', $result);
		$this->assertEquals(2, count($result));
		$this->assertEquals('a', $result[0]);
		
		$result = $this->object->slice(1);
		$this->assertType('array', $result);
		$this->assertEquals(2, count($result));
		$this->assertEquals('b', $result[0]);
		
		$result = $this->object->slice(2, 10);
		$this->assertType('array', $result);
		$this->assertEquals(1, count($result));
		$this->assertEquals('c', $result[0]);
	}
	
	public function testRemoveValuesOnEmptyKey()
	{
		$this->assertEquals(0,
			$this->object->removeValues('a')
		);
	}
	
	public function testRemoveValuesNoValue()
	{
		$this->object->push('b');
		
		$this->assertEquals(0,
			$this->object->removeValues('a')
		);
	}
	
	public function testRemoveValuesOne()
	{
		$this->object->push('a');
		$this->object->push('a');
		$this->object->push('b');
		
		$this->assertEquals(1,
			$this->object->removeValues('a', 1)
		);
		
		$this->assertEquals('a',
			$this->object->getValueAt(0)
		);
	}
	
	public function testRemoveValuesAll()
	{
		$this->object->push('a');
		$this->object->push('a');
		$this->object->push('b');
		$this->object->push('a');
		$this->object->push('a');
		
		$this->assertEquals(4,
			$this->object->removeValues('a')
		);
		
		$this->assertEquals('b',
			$this->object->getValueAt(0)
		);
	}
	
}

?>
