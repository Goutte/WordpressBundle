<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

//use Doctrine\Common\DataFixtures\Loader;
//use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
//use Doctrine\Common\DataFixtures\Purger\ORMPurger;

//use Application\FaxServerBundle\DataFixtures\ORM\NetworkConfigurationData;

class RepositoryTestCase extends WebTestCase
{

    const PATH_TO_SQL_FILE = '../Resources/sql/';

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    static $em;


    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::resetDatabase();
    }

    protected function setUp()
    {
        parent::setUp();
    }

    protected function getService($name)
    {
        return $this->getBootedKernel()->getContainer()->get($name);
    }

    protected function hasService($name)
    {
        return $this->getBootedKernel()->getContainer()->has($name);
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected static function getEm()
    {
        return self::$em = self::getBootedKernel()->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * @return \Symfony\Component\HttpKernel\Kernel
     */
    protected static function getBootedKernel()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        return static::$kernel;
    }

    /**
     * Sets up the database to mirror a freshly installed wordpress
     * /!\ IT DROPs TABLES BEFOREHAND /!\
     */
    protected static function resetDatabase()
    {
        $files_in_order = array(
            'wordpress_3.4.2',
            'fixtures',
        );
        foreach ($files_in_order as $filename) {
            self::executeSqlFile($filename);
        }
    }

    protected static function executeSqlFile($filename)
    {
        if ('.sql' != substr($filename, -4)) $filename .= '.sql';
        $filename = __DIR__ . DIRECTORY_SEPARATOR . self::PATH_TO_SQL_FILE . $filename;
        self::getEm()->getConnection()->exec(file_get_contents($filename));
    }





//    public function loadNetworkConfigurationFixtures()
//    {
//        $loader = new Loader();
//        $loader->addFixture( new NetworkConfigurationData() );
//
//        $this->loadFixtures( $loader );
//    }

//    public function loadFixtures(Loader $loader)
//    {
//        $purger     = new ORMPurger();
//        $executor   = new ORMExecutor( $this->getEm(), $purger );
//        $executor->execute( $loader->getFixtures() );
//    }
}