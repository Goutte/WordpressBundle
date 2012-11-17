<?php

namespace Goutte\WordpressBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Goutte\WordpressBundle\Entity\Post;
use Goutte\WordpressBundle\Entity\Comment;
use Goutte\WordpressBundle\Entity\User;

class PostTest extends WebTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @var \Symfony\Component\HttpKernel\Kernel
     */
    static $kernel;

    protected function setUp()
    {
        parent::setUp();

        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->em = static::$kernel->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Makes sure the Excerpt is no longer than 30 characters
     *
     * @dataProvider postProvider
     */
    public function testPostExcerpt($title, $content)
    {
        $post = new Post();
        $post->setTitle($title);
        $post->setExcerptLength(30);
        $post->setContent($content);

        $this->assertLessThanOrEqual(30, strlen($post->getExcerpt()));
    }

//    /**
//     * Test post slug
//     *
//     * @dataProvider postProvider
//     */
//    public function testPostSlug($title, $content, $userId)
//    {
//        $post = new Post();
//        $post->setTitle($title);
//        $post->setContent($content);
//
//        $this->em->persist($post);
//        $this->em->flush();
//        $this->em->clear();
//
//        $this->assertEquals(
//            1,
//            preg_match('/^[0-9a-z_-]+$/', $post->getSlug()),
//            'Post slug "'.$post->getSlug().'" should only contain numbers, lowercase characters dash, and underscore.'
//        );
//    }

    public function postProvider()
    {
        return array(
            array('Lorem ipsum dolor sit amet', 'Lorem ipsum <strong>dolor sit amet</strong>, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.'),
            array('Sed ut perspiciatis unde',   'Sed ut perspiciatis unde <em>omnis iste natus</em> error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.'),
            array('Sed \ [ ] % ^!@#$%^&* "- ',  'Aenean commodo ligula eget dolor. Aenean massa. '),
        );
    }

    public function commentProvider()
    {
        return array(
            array('Peter', 'peter@example.com', 'Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', null, null),
            array('Mary', 'peter@example.com', 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', null, 1),
            array('Tom', 'tom@example.com', 'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 1, null),
        );
    }

    protected function getPostRepository()
    {
        return $this->em->getRepository('GoutteWordpressBundle:Post');
    }

    protected function getCommentRepository()
    {
        return $this->em->getRepository('GoutteWordpressBundle:Comment');
    }

    protected function getUserRepository()
    {
        return $this->em->getRepository('GoutteWordpressBundle:User');
    }
}
