<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Goutte\WordpressBundle\Entity\Post;
use Goutte\WordpressBundle\Tests\Repository\RepositoryTestCase;

class AttachmentRepositoryTest extends RepositoryTestCase
{
    /**
     * @var \Goutte\WordpressBundle\Repository\AttachmentRepository
     */
    private $repo;

    protected function setUp()
    {
        parent::setUp();
        $this->repo = $this->getEm()->getRepository('GoutteWordpressBundle:Attachment');
    }

    public function testFindImages()
    {
        $allAttachments = $this->repo->findImages();
        $this->assertEquals(1, count($allAttachments));

        $allAttachments = $this->repo->findImages('png'); // it's png !
        $this->assertEquals(1, count($allAttachments));

        $allAttachments = $this->repo->findImages('bmp'); // no bmp 4u
        $this->assertEquals(0, count($allAttachments));
    }


}
