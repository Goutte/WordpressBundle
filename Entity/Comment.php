<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraints;

/**
 * Goutte\WordpressBundle\Entity\Comment
 *
 * @ORM\Table(name="comments")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Comment
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="comment_ID", type="wordpress_id", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $author
     *
     * @ORM\Column(name="comment_author", type="text")
     * @Constraints\NotBlank()
     */
    private $author;

    /**
     * @var string $authorEmail
     *
     * @ORM\Column(name="comment_author_email", type="string")
     * @Constraints\Email()
     */
    private $author_email = '';

    /**
     * @var string $authorUrl
     *
     * @ORM\Column(name="comment_author_url", type="string")
     * @Constraints\Url()
     */
    private $author_url = '';

    /**
     * @var string $authorIp
     *
     * @ORM\Column(name="comment_author_IP", type="string")
     * @Constraints\Ip()
     */
    private $author_ip;

    /**
     * @var \Datetime $created_at
     *
     * @ORM\Column(name="comment_date", type="datetime")
     */
    private $created_at;

    /**
     * @var \Datetime $created_at_gmt
     *
     * @ORM\Column(name="comment_date_gmt", type="datetime")
     */
    private $created_at_gmt;

    /**
     * @var string $content
     *
     * @ORM\Column(name="comment_content", type="text")
     * @Constraints\NotBlank()
     */
    private $content;

    /**
     * @var integer $karma
     *
     * @ORM\Column(name="comment_karma", type="integer")
     */
    private $karma = 0;

    /**
     * @var string $approved
     *
     * @ORM\Column(name="comment_approved", type="string")
     */
    private $approved = 1;

    /**
     * @var string $agent
     *
     * @ORM\Column(name="comment_agent", type="string")
     */
    private $agent;

    /**
     * @var string $type
     *
     * @ORM\Column(name="comment_type", type="string")
     */
    private $type = '';

    /**
     * @var int $parent
     *
     * @ORM\OneToOne(targetEntity="Comment")
     * @ORM\JoinColumn(name="comment_parent", referencedColumnName="comment_ID")
     */
    private $parent;

    /**
     * @var \Goutte\WordpressBundle\Entity\CommentMeta
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\CommentMeta", mappedBy="comment")
     */
    private $metas;

    /**
     * @var \Goutte\WordpressBundle\Entity\Post
     *
     * @ORM\ManyToOne(targetEntity="Goutte\WordpressBundle\Entity\Post", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment_post_ID", referencedColumnName="ID", nullable=false)
     * })
     */
    private $post;

    /**
     * @var \Goutte\WordpressBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Goutte\WordpressBundle\Entity\User", inversedBy="comments")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="ID")
     * })
     */
    private $user;


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->author_url = "";
        $this->author_ip = "";
        $this->karma = 0;
        $this->approved = 1;
        $this->agent = "";
        $this->type = "";
        $this->parent = null;
        $this->user = null;

        $this->metas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function __toString()
    {
        return $this->getContent();
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at     = new \Datetime('now');
        $this->created_at_gmt = new \Datetime('now', new \DatetimeZone('GMT'));
    }

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
     * Set author
     *
     * @param string $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * Get author
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set authorEmail
     *
     * @param string $authorEmail
     */
    public function setAuthorEmail($authorEmail)
    {
        $this->author_email = $authorEmail;
    }

    /**
     * Get authorEmail
     *
     * @return string
     */
    public function getAuthorEmail()
    {
        return $this->author_email;
    }

    /**
     * Set authorUrl
     *
     * @param string $authorUrl
     */
    public function setAuthorUrl($authorUrl)
    {
        $this->author_url = $authorUrl;
    }

    /**
     * Get authorUrl
     *
     * @return string
     */
    public function getAuthorUrl()
    {
        return $this->author_url;
    }

    /**
     * Set authorIp
     *
     * @param string $authorIp
     */
    public function setAuthorIp($authorIp)
    {
        $this->author_ip = $authorIp;
    }

    /**
     * Get authorIp
     *
     * @return string
     */
    public function getAuthorIp()
    {
        return $this->author_ip;
    }

    /**
     * Set date
     *
     * @param \Datetime $date
     */
    public function setCreatedAt($date)
    {
        $this->created_at = $date;
    }

    /**
     * Get date
     *
     * @return \Datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set date_gmt
     *
     * @param \Datetime $dateGmt
     */
    public function setCreatedAtGmt($dateGmt)
    {
        $this->created_at_gmt = $dateGmt;
    }

    /**
     * Get date_gmt
     *
     * @return \Datetime
     */
    public function getCreatedAtGmt()
    {
        return $this->created_at_gmt;
    }

    /**
     * Set content
     *
     * @param string $commentContent
     */
    public function setContent($commentContent)
    {
        $this->content = $commentContent;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set karma
     *
     * @param integer $karma
     */
    public function setKarma($karma)
    {
        $this->karma = $karma;
    }

    /**
     * Get karma
     *
     * @return integer
     */
    public function getKarma()
    {
        return $this->karma;
    }

    /**
     * Set approved
     *
     * @param string $approved
     */
    public function setApproved($approved)
    {
        if (is_bool($approved)) {
            $this->approved = $approved ? 1 : 0;
        }

        $this->approved = $approved;
    }

    /**
     * Get approved
     *
     * @return string
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * Set agent
     *
     * @param string $agent
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;
    }

    /**
     * Get agent
     *
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * Set type
     *
     * @param string $commentType
     */
    public function setType($commentType)
    {
        $this->type = $commentType;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set parent
     *
     * @param \Goutte\WordpressBundle\Entity\Comment $comment
     */
    public function setParent(\Goutte\WordpressBundle\Entity\Comment $comment)
    {
        $this->parent = $comment;
    }

    /**
     * Get parent
     *
     * @return \Goutte\WordpressBundle\Entity\Comment
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add meta
     *
     * @param \Goutte\WordpressBundle\Entity\CommentMeta $meta
     */
    public function addMeta(\Goutte\WordpressBundle\Entity\CommentMeta $meta)
    {
        $this->metas[] = $meta;
    }

    /**
     * Get metas
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetas()
    {
        return $this->metas;
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

    /**
     * Set user
     *
     * @param \Goutte\WordpressBundle\Entity\User $user
     */
    public function setUser(\Goutte\WordpressBundle\Entity\User $user)
    {
        $this->user = $user;

        $this->author      = $user->getDisplayName();
        $this->author_url   = $user->getUrl();
        $this->author_email = $user->getEmail();
    }

    /**
     * Get user
     *
     * @return \Goutte\WordpressBundle\Entity\User | null
     */
    public function getUser()
    {
        if ($this->user instanceof \Doctrine\ORM\Proxy\Proxy) {
            try {
                // prevent lazy loading the user entity because it might not exist
                $this->user->__load();
            } catch (\Doctrine\ORM\EntityNotFoundException $e) {
                // return null if user does not exist
                $this->user = null;
            }
        }

        return $this->user;
    }
}
