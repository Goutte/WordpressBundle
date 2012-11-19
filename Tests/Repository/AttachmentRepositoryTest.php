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

    public function testFindAll()
    {
        $allAttachments = $this->repo->findAll();
        $this->assertEquals(0, count($allAttachments));
    }


}
