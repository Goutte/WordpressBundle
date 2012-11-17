<?php

namespace Goutte\WordpressBundle\Tests\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\Tests\DBAL\Mocks\MockPlatform; // if this fails, see README
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Types\WordPressMetaType;

class WordPressMetaTypeTest extends WebTestCase
{
    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected $platform;

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;


    protected function getTypeName()
    {
        return WordPressMetaType::NAME;
    }

    protected function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->platform = new MockPlatform();
    }

    /**
     * @return \Doctrine\DBAL\Types\Type
     * @throws \Exception
     */
    public function getType()
    {
        $typeName = $this->getTypeName();
        if (Type::hasType($typeName)) {
            return Type::getType($typeName);
        } else {
            throw new \Exception ("Custom type '{$typeName}' was not added. Add this bundle to your AppKernel.");
        }
    }

    public function testHasType()
    {
        $typeName = $this->getTypeName();
        $this->assertTrue(Type::hasType($typeName), "Custom type '{$typeName}' was not added. Add this bundle to your AppKernel.");
    }

    /**
     * Tests the conversion back and forth of null
     */
    public function testNullConversion()
    {
        $convertedNull = $this->getType()->convertToDatabaseValue(null, $this->platform);

        $this->assertTrue(is_null($convertedNull));
        $this->assertEquals(null, $this->getType()->convertToPHPValue($convertedNull, $this->platform));
    }

    /**
     * Tests the conversion back and forth of booleans
     * WP has an inconsistent management of booleans, sometimes it is an integer, sometimes it is a string,
     * and sometimes it is 'true' or 'false' and sometimes 'yes' or 'no'
     * Therefore, we cannot test much.
     * @dataProvider provideBooleans
     */
    public function testBooleanConversion($boolean)
    {
        $convertedBoolean = $this->getType()->convertToDatabaseValue($boolean, $this->platform);

        $this->assertTrue(is_string($convertedBoolean));
        $this->assertEquals($boolean, $this->getType()->convertToPHPValue($convertedBoolean, $this->platform));
    }

    /**
     * Tests the conversion back and forth of integers
     * @dataProvider provideIntegers
     */
    public function testIntegerConversion($integer)
    {
        $convertedInteger = $this->getType()->convertToDatabaseValue($integer, $this->platform);

        $this->assertTrue(is_int($convertedInteger));
        $this->assertEquals($integer, $this->getType()->convertToPHPValue($convertedInteger, $this->platform));
    }

    /**
     * Tests the conversion back and forth of strings
     * @dataProvider provideStrings
     */
    public function testStringConversion($string)
    {
        $convertedString = $this->getType()->convertToDatabaseValue($string, $this->platform);

        $this->assertTrue(is_string($convertedString));
        $this->assertEquals($string, $this->getType()->convertToPHPValue($convertedString, $this->platform));
    }

    /**
     * Tests the conversion back and forth of arrays
     * @dataProvider provideArrays
     */
    public function testArrayConversion($array)
    {
        $convertedArray = $this->getType()->convertToDatabaseValue($array, $this->platform);

        $this->assertTrue(is_string($convertedArray));
        $this->assertEquals($array, $this->getType()->convertToPHPValue($convertedArray, $this->platform));
    }

    /**
     * Tests the conversion back and forth of objects
     * @dataProvider provideObjects
     */
    public function testObjectConversion($object)
    {
        $convertedObject = $this->getType()->convertToDatabaseValue($object, $this->platform);

        $this->assertTrue(is_string($convertedObject));
        $this->assertEquals($object, $this->getType()->convertToPHPValue($convertedObject, $this->platform));
    }


    public function provideBooleans()
    {
        return array(
            array(true),
            array(false),
        );
    }

    public function provideIntegers()
    {
        return array(
            array(0),
            array(-42),
            array(42),
            array(PHP_INT_MAX)
        );
    }

    public function provideStrings()
    {
        return array(
            array(''),
            array('&#>"< }{(.)'),
            array('a:0:{}'), // tricky one !
            array('true'),   // tricky one too !
        );
    }

    public function provideArrays()
    {
        return array(
            array(array()),
            array(array('zero', 1, 2, 3)),
            array(array('ho' => 'noes', '3' => 'three')),
            array(array(array('nested', array('array')), 'just a string')),
            array(array('special chars', 'a:0:{}', '"')),
        );
    }

    public function provideObjects()
    {
        return array(
            array(new MockPlatform()),
            array($this),
        );
    }
}
