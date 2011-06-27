<?php
namespace RedisTools\Db\Field;
/**
 * Created by IntelliJ IDEA.
 * User: protom
 * Date: 6/27/11
 * Time: 10:20 PM
 * To change this template use File | Settings | File Templates.
 */
 
class TestBase extends \PHPUnit_Framework_TestCase
{

	protected $redisKey = 'asdf';

	public function tearDown()
	{
		$this->getRedis()->delete($this->redisKey);
		parent::tearDown();
	}

	/**
	 * @return \RedisTools\Db\ValueObject
	 */
	protected function getValueObject()
	{
		return new \RedisTools\Db\ValueObject( $this->redisKey, $this->getRedis() );
	}

	/**
	 * @return \Redis
	 */
	protected function getRedis()
	{
		$redis = new \Redis();
		$redis->pconnect('127.0.0.1');
		return $redis;
	}

}
