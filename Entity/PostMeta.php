<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * Goutte\WordpressBundle\Entity\PostMeta
 *
 * @ORM\Table(name="postmeta")
 * @ORM\Entity
 */
class PostMeta
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="meta_id", type="bigint", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $key
     *
     * @ORM\Column(name="meta_key", type="string", length=255, nullable=true)
     * @Constraints\NotBlank()
     */
    private $key;

    /**
     * @var string $value
     *
     * @ORM\Column(name="meta_value", type="wordpress_meta", nullable=true)
     */
    private $value;

    /**
     * @var \Goutte\WordpressBundle\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="Goutte\WordpressBundle\Entity\Post", inversedBy="metas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_id", referencedColumnName="ID")
     * })
     */
    private $post;

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set key
     *
     * @param string $key
     */
    public function setKey($key)
    {
        $this->key = $key;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set value
     *
     * @param text $value
     */
    public function setValue($value)
    {
        $this->value = $value;
    }

    /**
     * Get value
     *
     * @return text
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set post
     *
     * @param \Goutte\WordpressBundle\Entity\Post $post
     */
    public function setPost(\Goutte\WordpressBundle\Entity\Post $post)
    {
        $this->post = $post;
    }

    /**
     * Get post
     *
     * @return \Goutte\WordpressBundle\Entity\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}
