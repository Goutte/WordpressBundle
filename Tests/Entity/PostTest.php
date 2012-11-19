<?php

namespace Goutte\WordpressBundle\Tests\Entity;

use Goutte\WordpressBundle\Tests\TestCase\FixturedTestCase;

use Goutte\WordpressBundle\Entity\Post;
use Goutte\WordpressBundle\Entity\Comment;
use Goutte\WordpressBundle\Entity\User;

class PostTest extends FixturedTestCase
{

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

    public function testGetMetasByKey()
    {
        $post = $this->getPostRepository()->findOneBy(array('id' => 1));

        $this->assertCount(0, $post->getMetasByKey('_wp_nothing'));
        $this->assertCount(1, $post->getMetasByKey('_wp_something'));
    }

    public function testGetMeta()
    {
        $post = $this->getPostRepository()->findOneBy(array('id' => 1));

        $this->assertNull($post->getMeta('_wp_nothing'));
        $this->assertNotNull($post->getMeta('_wp_something'));
    }

    public function testGetMetaValue()
    {
        $post = $this->getPostRepository()->findOneBy(array('id' => 1));

        $this->assertNull($post->getMetaValue('_wp_nothing'));
        $this->assertEquals('good', $post->getMetaValue('_wp_something'));
    }

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
            array('Mary', 'peter@example.com',  'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.', null, 1),
            array('Tom', 'tom@example.com',     'Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.', 1, null),
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
