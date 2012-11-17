<?php

namespace Goutte\WordpressBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Entity\Post;

class PostRepositoryTest extends WebTestCase
{
    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;

    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Goutte\WordpressBundle\Repository\PostRepository
     */
    private $repo;

    protected function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->em   = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->repo = $this->em->getRepository('GoutteWordpressBundle:Post');
    }

    public function testFindPublishedPosts()
    {

    }

}
