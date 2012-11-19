<?php

namespace Goutte\WordpressBundle\Tests\Repository;

use Goutte\WordpressBundle\Tests\TestCase\RepositoryTestCase;

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
        // One png, one gif, nothing else

        $allAttachments = $this->repo->findImages();
        $this->assertEquals(2, count($allAttachments));

        $allAttachments = $this->repo->findImages('png');
        $this->assertEquals(1, count($allAttachments));

        $allAttachments = $this->repo->findImages('bmp'); // no bmp 4u
        $this->assertEquals(0, count($allAttachments));

        $allAttachments = $this->repo->findImages(array('png','gif'));
        $this->assertEquals(2, count($allAttachments));

        $allAttachments = $this->repo->findImages(array('png','bmp'));
        $this->assertEquals(1, count($allAttachments));
    }


}
