<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;

//use Application\FaxServerBundle\DataFixtures\ORM\NetworkConfigurationData;

class RepositoryTestCase extends WebTestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;


    protected function setUp()
    {
        parent::setUp();

        $this->getBootedKernel();

        //$this->repo = $this->getEm()->getRepository('GoutteWordpressBundle:Post');
    }

//    public function loadNetworkConfigurationFixtures()
//    {
//        $loader = new Loader();
//        $loader->addFixture( new NetworkConfigurationData() );
//
//        $this->loadFixtures( $loader );
//    }

    public function loadFixtures(Loader $loader)
    {
        $purger     = new ORMPurger();
        $executor   = new ORMExecutor( $this->getEm(), $purger );
        $executor->execute( $loader->getFixtures() );
    }

    protected function getEm()
    {
        return $this->em = $this->getBootedKernel()->getContainer()->get('doctrine.orm.entity_manager');
    }

    protected function getService($name)
    {
        return $this->getBootedKernel()->getContainer()->get($name);
    }

    protected function hasService($name)
    {
        return $this->getBootedKernel()->getContainer()->has($name);
    }

    protected function getBootedKernel()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        return static::$kernel;
    }

//    public function generateUrl( $client, $route, $parameters = array() )
//    {
//        return $client->getContainer()->get( 'router' )->generate( $route, $parameters );
//    }
}