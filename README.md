RedisTools
==========

RedisTools provides wrapper classes for using the [phpredis](https://github.com/nicolasff/phpredis) extension. 
Most Redis types (like lists, hashes, etc...) already have their PHP equivalent in RedisTools. The main goal for
this library is to provide tools that enables more database like functionality (indexes, relations, etc...).
Those database features are currently under development and not intended to be used in real projects. Nevertheless 
the Redis types (in Redis\Type\\*) are already feature complete.



RedisTools Types
================
Please keep in mind that all RedisTools\Types are low level implemetations. Therefore all Redis operations are executed immediately. So setting a value of a Type also writes this value to Redis.

## Setup your Redis instance

##### Description
Every RedisTools Type has to be provided a configured and connected Redis instance 
to work with. You can either provide the Type with an instance in construction or via a setter method.

If you want to reuse your intance throughout all your Redis types, you can set a global instance that will be used by all type instances as default (which can be 
overridden for each instance individually). 

##### Example
<pre>
$redis = new \Redis();
$redis->pconnect('127.0.0.1');

// setup a global fallback Redis instance for all Redis\Tools\Types
RedisTools::setRedis( $redis );
</pre>

## String

##### Description
The String Type of RedisTools is the most simples type of all. It is essentially a key - value pair with some additional functionality that comes with Redis.

##### Examples
<pre>
// all examples assume this namespace to provide a convinient read
namespace RedisTools\Type;

$string = new String();

$string->setKey('name');
$string->setValue('Mario');

$otherString = new String('name');
echo $otherString->getValue(); // -> Mario

$otherString->setValue('Luigi');
echo $string->getValue(); // -> Luigi
</pre>

## Bitmap
##### Description

##### Examples

## Hash
##### Description

##### Examples

## Set
##### Description

##### Examples

## ArrayList
##### Description

##### Examples

## OrderedList
##### Description

##### Examples