<?php

namespace Goutte\WordpressBundle\Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BaseTestCase extends WebTestCase
{

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;

    /**
     * @return \Symfony\Component\HttpKernel\Kernel
     */
    protected static function getBootedKernel()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        return static::$kernel;
    }

    protected function getService($name)
    {
        return $this->getBootedKernel()->getContainer()->get($name);
    }

    protected function hasService($name)
    {
        return $this->getBootedKernel()->getContainer()->has($name);
    }

}