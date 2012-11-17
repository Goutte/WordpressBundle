<?php

namespace Goutte\WordpressBundle\Tests\Types;

use Doctrine\DBAL\Types\Type;
use Doctrine\Tests\DBAL\Mocks\MockPlatform; // if this fails, see README
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Types\WordPressIdType;

class WordPressIdTypeTest extends TypeTestCase
{

    protected function getTypeName()
    {
        return WordPressIdType::NAME;
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
}
