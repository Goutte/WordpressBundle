<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Goutte\WordpressBundle\Entity\Post;
use Goutte\WordpressBundle\Tests\Repository\RepositoryTestCase;

class PostRepositoryTest extends RepositoryTestCase
{
    /**
     * @var \Goutte\WordpressBundle\Repository\PostRepository
     */
    private $repo;

    protected function setUp()
    {
        parent::setUp();
        $this->repo = $this->getEm()->getRepository('GoutteWordpressBundle:Post');
    }

    public function testFindPublishedPosts()
    {
        $publishedPosts = $this->repo->findPublished();
        $this->assertEquals(1, count($publishedPosts));
    }

    public function testFindPublishedBySlug()
    {
        $helloPost = $this->repo->findPublishedBySlug('hello-world'); // exists
        $this->assertNotEmpty($helloPost);

        $hello2Post = $this->repo->findPublishedBySlug('hello-world-2'); // exists as draft
        $this->assertEmpty($hello2Post);

        $salutPost = $this->repo->findPublishedBySlug('salut-world'); // does not exist
        $this->assertEmpty($salutPost);
    }

}
