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

## Shared functionality
There are several key operations you can perform with all different RedisTools\Types. The following methods can be used with all types.

<pre>
// delete all data stored at the configured key
$exampleType->delete();

// determine wether the type already exists in Redis 
$exampleType->exists();

// sets the expiration time in seconds 
$exampleType->setTtl( $ttl );

// returns the remaining time till expiration in seconds
$exampleType->getTtl();

// set the expiration data as a timestamp
$exampleType->expireAt( $timestamp )

// returns the (Redis) type of the data stored at key
$exampleType->getType();

// renames the key of a Redis type
$exampleType->renameKey( $newName );

// same as renameKey but only executes if $newName does not already exist
$exampleType->renameKeyNx( $newName );

// moves a Redis type into another database
$exampleType->moveToDb( $integer );

</pre>

## String

##### Description
The String Type of RedisTools is the most simplest type of all. It is essentially a key - value pair with some additional functionality that comes with Redis.

##### Examples
<pre>
// all examples assume this namespace to provide a convinient read
use RedisTools\Type\String;

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
A Bitmap enables you to store boolean types by an index. Such Redis bitmaps are 
fast and have a  very small memory footprint. If the bitvalue at the given index 
is not set, 0 is returned.
##### Examples
<pre>
use RedisTools\Type\Bitmap;

$userId = 214;
$voterlist = new Bitmap('has_voted');
if(! $voterlist->getBit($userId) ){
	// vote
	$voterlist->setBit($userId, 1);
}
</pre>

## Hash
##### Description
A Redis Hash is very simmilar to a hash in PHP. It enables you to store string/integer 
values that can be accessed via a custom string key. A PHP example would look like 
array('key' => 'value'). For performance reasons this class does not implement the 
Iterator Interface (to be used with foreach), use the getAll() method to iterate over 
all values. 

##### Examples
<pre>
use RedisTools\Type\Hash;

$hash = new Hash('my_hash');

$hash->set('color', 'blue');
$hash->keyExists('color'); // -> true
echo $hash->getValue('color'); // -> blue

$hash->set('name', 'Luigi');
echo count($hash); // -> 2

$hash->getKeys(); // -> array('color', 'name')
$hash->getValues(); // -> array('blue', 'Luigi')
$hash->getAll(); // -> array('color' => 'blue', 'name' => 'Luigi')

$hash->set('views', 0);
$hash->incrementValue('views');
echo $hash->getValue('views'); // -> 1

$hash->getMulti(array('name', 'views', 'nonexisting')); // -> array('Luigi', 1, false)
$hash->setMulti(array('name' => 'Mario', 'views' => 5));

$hash->setIfNotExists('color', 'red'); // -> false
$hash->deleteKey('color');
$hash->setIfNotExists('color', 'red'); // -> true

</pre>
## Set
A Redis Set is a collection of values stored in a random order. Every value can 
only exist once in a Set. 
##### Description
<pre>
user RedisTools\Type\Set;

$set = new Set('characters');

$set->addValue('Mario'); // -> true
$set->addValue('Mario'); // -> false
$set->addValue('Luigi'); // -> true

$set->contains('Luigi'); // -> true
$set->contains('Peach'); // -> false

$set->deleteValue('Peach'); // -> false
$set->deleteValue('Mario'); // -> true
$set->contains('Mario'); // -> false

$set->addValue('Peach');
count($set); // -> 2
$set->getValues(); // -> array('Luigi', 'Peach')  in random order!

$set->addValue('Mario');
$set2 = new Set('others');
$set2->addValue('Mario');
$set->getDiff($set2); // -> array('Peach', 'Luigi')

$set3 = new Set('more');
$set3->addValue('Luigi');
$set->getDiff(array($set2, $set3)); // -> array('Peach');

$set->getDiff($set2, true, 'result');
$result = new Set('result');
$result->getValues(); // -> array('Peach', 'Luigi')

$set->moveValueToSet('Mario', $set3);
$set->contains('Mario'); // -> false
$set3->contains('Mario'); // -> true

$set->pop(); // returns random value -> Luigi || Peach

</pre>
##### Examples

## ArrayList
##### Description

##### Examples

## OrderedList
##### Description

##### Examples