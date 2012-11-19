<?php

namespace Goutte\WordpressBundle\Tests\TestCase;


class FixturedTestCase extends BaseTestCase
{

    const PATH_TO_SQL_FILE = '../Resources/sql/';

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    static $em;


    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();

        self::resetDatabase();
    }

    /**
     * @return \Doctrine\ORM\EntityManager
     */
    protected static function getEm()
    {
        return self::$em = self::getBootedKernel()->getContainer()->get('doctrine.orm.entity_manager');
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
}