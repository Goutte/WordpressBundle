<?php

namespace Goutte\WordpressBundle\Tests\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\Tests\DBAL\Mocks\MockPlatform; // if this fails, see README
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Types\WordPressIdType;

class WordPressIdTypeTest extends WebTestCase
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
        return WordPressIdType::NAME;
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

        $this->assertEquals(0, $convertedNull);
        $this->assertNull($this->getType()->convertToPHPValue($convertedNull, $this->platform));
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

    public function provideIntegers()
    {
        return array(
            array(0),
            array(-42),
            array(42),
            array(PHP_INT_MAX)
        );
    }
}
