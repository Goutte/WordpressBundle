<?php

namespace Goutte\WordpressBundle\Tests\Types;

use Doctrine\DBAL\Types\Type;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Doctrine\Tests\DBAL\Mocks\MockPlatform; // if this fails, see README
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Types\WordPressIdType;

class TypeTestCase extends WebTestCase
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
        throw new InvalidConfigurationException("You must override getTypeName()");
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
