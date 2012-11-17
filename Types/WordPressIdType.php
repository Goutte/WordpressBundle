<?php

/**
 * Datatype for WordPress's IDs
 *
 * WordPress uses 0 to represent a guest user.
 * It causes a lots of problems in Doctrine because the user with id zero never exists.
 * This datatype converts 0 to null, making life easier.
 */

namespace Goutte\WordpressBundle\Types;

use Doctrine\DBAL\Types\BigIntType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class WordPressIdType extends BigIntType
{
    const NAME = 'wordpress_id';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if (0 === $value) {
            return null;
        }

        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (null === $value) {
            return 0;
        }

        return $value;
    }

    public function getName()
    {
        return self::NAME;
    }
}
