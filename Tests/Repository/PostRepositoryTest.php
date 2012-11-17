<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Entity\Post;
use Goutte\WordpressBundle\Tests\Repository\RepositoryTestCase;

class PostRepositoryTest extends RepositoryTestCase
{
    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    private $repo;

    protected function setUp()
    {
        parent::setUp();

        $this->repo = $this->getEm()->getRepository('GoutteWordpressBundle:Post');
    }

    public function testFindPublishedPosts()
    {

    }

}
