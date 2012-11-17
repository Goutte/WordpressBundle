<?php

/**
 * Datatype for WordPress's meta values, so we may unserialize them automagically if needed
 */

namespace Goutte\WordpressBundle\Types;

use Doctrine\DBAL\Types\TextType;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class WordPressMetaType extends TextType
{
    const NAME = 'wordpress_meta';

    // Warning: WP has an inconsistent management of booleans, sometimes it is an integer, sometimes it is a string,
    // and sometimes it is 'true' or 'false' and sometimes 'yes' or 'no'
    // We can only provide for one meaning, and we choose 'true' and 'false', which are the most commonly used by WP
    const STRING_TRUE  = 'true';
    const STRING_FALSE = 'false';

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($this->isSerialized($value)) {
            return @unserialize($value);
        }
        if (self::STRING_TRUE  === $value) {
            return true;
        }
        if (self::STRING_FALSE === $value) {
            return false;
        }

        return $value;
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (
            is_array($value)  ||
            is_object($value) ||
            $this->isSerialized($value) ||
            self::STRING_TRUE  === $value ||
            self::STRING_FALSE === $value
        ) {
            return serialize($value);
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        return $value;
    }

    /**
     * Check value to find if it was serialized.
     *
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @param  mixed $data Value to check to see if was serialized.
     * @return bool  False if not serialized and true if it was.
     */
    private function isSerialized($data)
    {
        // if it isn't a string, it isn't serialized
        if (!is_string($data))
            return false;
        $data = trim($data);
        if ('N;' == $data)
            return true;
        $length = strlen($data);
        if ($length < 4)
            return false;
        if (':' !== $data[1])
            return false;
        $lastc = $data[$length-1];
        if (';' !== $lastc && '}' !== $lastc)
            return false;
        $token = $data[0];
        switch ($token) {
            case 's' :
                if ( '"' !== $data[$length-2] ) return false;
            case 'a' :
            case 'O' :
                return (bool) preg_match( "/^{$token}:[0-9]+:/s", $data );
            case 'b' :
            case 'i' :
            case 'd' :
                return (bool) preg_match( "/^{$token}:[0-9.E-]+;\$/", $data );
        }

        return false;
    }

    public function getName()
    {
        return self::NAME;
    }
}
