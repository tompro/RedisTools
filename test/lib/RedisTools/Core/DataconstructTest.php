<?php

namespace RedisTools\Core;

/**
 * Test class for Dataconstruct.
 * Generated by PHPUnit on 2011-03-24 at 23:58:08.
 */
class DataconstructTest extends \PHPUnit_Framework_TestCase
{

	/**
	 * @var Dataconstruct
	 */
	protected $object;

	protected $testKey = 'testkey';
	
	/**
	 * Sets up the fixture, for example, opens a network connection.
	 * This method is called before a test is executed.
	 */
	protected function setUp()
	{
		$this->object = new Dataconstruct();
	}

	/**
	 * @expectedException RedisTools\Exception
	 */
	public function testConstructWithKey()
	{
		$object = new Dataconstruct( 'asdf' );
		$this->assertEquals('asdf', $object->getKey());
		$this->assertNull($object->getRedis());
	}
	
	public function testConstructWithCompleteConfiguration()
	{
		$redis = new \stdClass();
		$object = new Dataconstruct( 'asdf', $redis );
		$this->assertEquals('asdf', $object->getKey());
		$this->assertEquals($redis, $object->getRedis());
	}


	/**
	 * @expectedException RedisTools\Exception
	 */
	public function testGetKeyWithNullValue()
	{
		$this->object->getKey();
	}
	
	/**
	 * @expectedException RedisTools\Exception
	 */
	public function testGetKeyWithIntValue()
	{
		$this->object->setKey(1234);
		$this->object->getKey();
	}
	
	/**
	 * @expectedException RedisTools\Exception
	 */
	public function testGetKeyWithInvalidStringValue()
	{
		$this->object->setKey('asdf ? asdf');
		$this->object->getKey();
	}


	public function testGetKeyWithNumericStringValue()
	{
		$this->object->setKey('1234');
		$this->assertEquals('1234', $this->object->getKey());
	}

	public function testSetKey()
	{
		$this->object->setKey('asdf');
		$this->assertEquals('asdf', $this->object->getKey());
	}

	/**
	 * @expectedException RedisTools\Exception
	 */
	public function testGetRedisNoInstanceSet()
	{
		$this->object->getRedis();
	}
	
	public function testSetAndGetRedisWithStdClass()
	{
		$object = new \stdClass();
		$this->object->setRedis($object);
		$this->assertEquals($object, $this->object->getRedis());
	}
	
	
	public function testDeletingValue()
	{
		$redis = $this->getRedis();
		$this->object->setRedis($redis);
		$this->object->setKey($this->testKey);
		$redis->set($this->testKey, 'asdf');
		
		$this->assertEquals(
			1, $this->object->delete(), 
			'Value should have been deleted but was not. '
		);
		
		$this->assertEquals(
			0, $this->object->delete(), 
			'Value should have already been deleted but was present. '
		);
	}
	
	public function testIfKeyExistsOnEmptyKey()
	{
		$this->object->setRedis($this->getRedis());
		$this->object->setKey($this->testKey);
		$this->assertFalse(
			$this->object->exists(),
			'Key should not exist but did not return false. '
		);
	}
	
	public function testGettingTtlOnEmptyValue()
	{
		$this->setupObject();
		
		$this->assertEquals(
			-1, $this->object->getTtl(),
			'Ttl of empty key should return -1 but was not. '
		);
	}
	
	public function testGettingTtlOfNotExpiringValue()
	{
		$this->setupObject();
		$this->getRedis()->set($this->testKey, 'asdf');
		
		$this->assertEquals(
			-1, $this->object->getTtl(),
			'Ttl of non expiring key should return -1 but was not. '
		);
	}
	
	public function testSettingExpireValue()
	{
		$this->setupObject();
		//$this->object->set($this->testValue);
		
		$offset = 2;
		
		$this->assertTrue(
			$this->object->expireAt( \time() + $offset ),
			'Setting expire date was not successful. '
		);
		
		$ttl = $this->object->getTtl();
		$this->assertEquals(
			$offset,
			$ttl,
			'TTL should be ' . $offset . ' but was ' . $ttl . '. '
		);
	}
	
	public function testSettingExpireValueInThePast()
	{
		$this->setupObject();
		$this->getRedis()->set($this->testKey, 'asdf');
		
		//$this->object->set($this->testValue);
		$this->assertTrue(
			$this->object->expireAt( 1 ),
			'Setting expire value in the past was not posible. '
		);
		
		$this->assertFalse(
			$this->object->exists(),
			'Setting ttl value in the past should expire key immediately but did not. '
		);
		
		$this->object->delete();
	}
	
	public function testSettingExpireValueOnEmptyKey()
	{
		$this->setupObject();
		$this->assertFalse(
			$this->object->expireAt( \time() + 2 ),
			'Setting expire date should not be possible on empty keys. '
		);
	}
	
	public function testSettingTtlOnEmptyKey()
	{
		$this->setupObject();
		$this->assertFalse(
			$this->object->setTtl( 2 )
		);
	}
	
	public function testSettingTtl()
	{
		$this->setupObject();
		$this->getRedis()->set($this->testKey, 'asdf');
		
		$this->assertTrue(
			$this->object->setTtl( 2 )
		);
		
		$this->assertEquals(2,
			$this->object->getTtl()
		);
	}
	
	public function testRenameKeyOnEmptyKey()
	{
		$this->setupObject();
		$this->assertTrue(
			$this->object->renameKey( 'asdf' )
		);
	}
	
	public function testRenameKey()
	{
		$this->setupObject();
		$this->assertEquals($this->testKey, $this->object->getKey());
		
		$this->getRedis()->set($this->testKey, 'asdf');
		$this->assertTrue(
			$this->object->renameKey( 'qwer' )
		);
		
		$this->assertEquals('qwer', 
			$this->object->getKey()
		);
		
		$this->assertEquals('asdf',
			$this->getRedis()->get($this->object->getKey())
		);
		
		
	}


	protected function setupObject()
	{
		$this->object->setRedis($this->getRedis());
		$this->object->setKey($this->testKey);
	}
	
	protected function tearDownObject()
	{
		$this->object->delete();
	}


	protected function getRedis()
	{
		$redis = new \Redis();
		$redis->pconnect('127.0.0.1');
		return $redis;
	}

}

?>
