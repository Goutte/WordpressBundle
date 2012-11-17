<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Constraints;


/**
 * Goutte\WordpressBundle\Entity\Post
 *
 * @ORM\Table(name="posts")
 * @ORM\Entity(repositoryClass="Goutte\WordpressBundle\Repository\PostRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Post
{

    const STATUS_PUBLISH    = 'publish';
    const STATUS_INHERIT    = 'inherit';
    const STATUS_DRAFT      = 'draft';
    const STATUS_AUTO_DRAFT = 'auto-draft';
    const STATUS_TRASH      = 'trash';
    const STATUS_OPEN       = 'open';

    const TYPE_ATTACHMENT   = 'attachment';
    const TYPE_PAGE         = 'page';
    const TYPE_POST         = 'post';
    const TYPE_REVISION     = 'revision';


    /**
     * @var int $id
     *
     * @ORM\Column(name="ID", type="wordpress_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \Datetime $created_at
     *
     * @ORM\Column(name="post_date", type="datetime")
     */
    private $created_at;

    /**
     * @var \Datetime $created_at_gmt
     *
     * @ORM\Column(name="post_date_gmt", type="datetime")
     */
    private $created_at_gmt;

    /**
     * @var \Datetime $modified_at
     *
     * @ORM\Column(name="post_modified", type="datetime")
     */
    private $modified_at;

    /**
     * @var \Datetime $modified_at_gmt
     *
     * @ORM\Column(name="post_modified_gmt", type="datetime")
     */
    private $modified_at_gmt;

    /**
     * @var string $content
     *
     * @ORM\Column(name="post_content", type="text")
     * @Constraints\NotBlank()
     */
    private $content;

    /**
     * @var string $title
     *
     * @ORM\Column(name="post_title", type="text")
     * @Constraints\NotBlank()
     */
    private $title;

    /**
     * @var string $excerpt
     *
     * @ORM\Column(name="post_excerpt", type="text")
     * @Constraints\NotBlank()
     */
    private $excerpt;

    /**
     * @var int excerpt length
     */
    private $excerpt_length = 100;

    /**
     * @var string $status
     *
     * @ORM\Column(name="post_status", type="string", length=20, nullable=false)
     */
    private $status = self::STATUS_PUBLISH;

    /**
     * @var string $commentStatus
     *
     * @ORM\Column(name="comment_status", type="string", length=20, nullable=false)
     */
    private $comment_status = self::STATUS_OPEN;

    /**
     * @var string $pingStatus
     *
     * @ORM\Column(name="ping_status", type="string", length=20, nullable=false)
     */
    private $ping_status = self::STATUS_OPEN;

    /**
     * @var string $password
     *
     * @ORM\Column(name="post_password", type="string", length=20, nullable=false)
     */
    private $password = "";

    /**
     * @var string $slug
     *
     * @ORM\Column(name="post_name", type="string", length=200, nullable=false)
     * @Gedmo\Slug(fields={"title"})
     */
    private $slug;

    /**
     * @var string $to_ping
     *
     * @ORM\Column(name="to_ping", type="text", nullable=false)
     */
    private $to_ping = "";

    /**
     * @var string $pinged
     *
     * @ORM\Column(name="pinged", type="text", nullable=false)
     */
    private $pinged = "";

    /**
     * @var string $content_filtered
     *
     * @ORM\Column(name="post_content_filtered", type="text", nullable=false)
     */
    private $content_filtered = "";

    /**
     * @var \Goutte\WordpressBundle\Entity\Post $parent
     *
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="children")
     * @ORM\JoinColumn(name="post_parent", referencedColumnName="ID")
     */
    private $parent;

    /**
     * @var \Goutte\WordpressBundle\Entity\Post $children
     *
     * @ORM\OneToMany(targetEntity="Post", mappedBy="parent")
     */
    private $children;

    /**
     * @var string $guid
     *
     * @ORM\Column(name="guid", type="string", length=255, nullable=false)
     */
    private $guid = "";

    /**
     * @var integer $menu_order
     *
     * @ORM\Column(name="menu_order", type="integer", length=11)
     */
    private $menu_order = 0;

    /**
     * @var string $type
     *
     * @ORM\Column(name="post_type", type="string")
     */
    private $type = self::TYPE_POST;

    /**
     * @var string $mime_type
     *
     * @ORM\Column(name="post_mime_type", type="string", length=100)
     */
    private $mime_type = "";

    /**
     * @var int $commentCount
     *
     * @ORM\Column(name="comment_count", type="bigint", length=20)
     */
    private $comment_count = 0;

    /**
     * @var \Goutte\WordpressBundle\Entity\PostMeta
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\PostMeta", mappedBy="post", cascade={"persist"})
     */
    private $metas;

    /**
     * @var \Goutte\WordpressBundle\Entity\Comment
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\Comment", mappedBy="post", cascade={"persist"})
     */
    private $comments;

    /**
     * @var \Goutte\WordpressBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="Goutte\WordpressBundle\Entity\User", inversedBy="posts")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="post_author", referencedColumnName="ID")
     * })
     */
    private $user;

    /**
     * @var \Goutte\WordpressBundle\Entity\Taxonomy
     *
     * @ORM\ManyToMany(targetEntity="Goutte\WordpressBundle\Entity\Taxonomy", inversedBy="posts")
     * @ORM\JoinTable(name="wp_term_relationships",
     *   joinColumns={
     *     @ORM\JoinColumn(name="object_id", referencedColumnName="ID")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="term_taxonomy_id", referencedColumnName="term_taxonomy_id")
     *   }
     * )
     */
    private $taxonomies;

    public function __construct()
    {
        $this->metas      = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments   = new \Doctrine\Common\Collections\ArrayCollection();
        $this->taxonomies = new \Doctrine\Common\Collections\ArrayCollection();
        $this->children   = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->created_at      = new \DateTime('now');
        $this->created_at_gmt  = new \DateTime('now', new \DateTimeZone('GMT'));
        $this->modified_at     = new \DateTime('now');
        $this->modified_at_gmt = new \DateTime('now', new \DateTimeZone('GMT'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->modified_at     = new \DateTime('now');
        $this->modified_at_gmt = new \DateTime('now', new \DateTimeZone('GMT'));
    }

    /**
     * Get ID
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
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
     * Set dateGmt
     *
     * @param \Datetime $dateGmt
     */
    public function setCreatedAtGmt($dateGmt)
    {
        $this->created_at_gmt = $dateGmt;
    }

    /**
     * Get dateGmt
     *
     * @return \Datetime
     */
    public function getCreatedAtGmt()
    {
        return $this->created_at_gmt;
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
     * Set content
     *
     * @param string $content
     */
    public function setContent($content)
    {
        $this->content = $content;

        $this->excerpt = $this->getTrimmedContent($content);
    }

    /**
     * Cut string to n symbols and add delim but do not break words.
     *
     * @param  string string to trim
     * @return string processed string
     **/
    public function getTrimmedContent()
    {
        $content = strip_tags($this->getContent());
        $length = $this->getExcerptLength();

        if (strlen($content) <= $length) {
            return $content;
        }

        $content = substr($content, 0, $length);
        $pos = strrpos($content, " ");

        if ($pos > 0) {
            $content = substr($content, 0, $pos);
        }

        return $content;
    }

    /**
     * Set title
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set excerpt
     *
     * @param string $excerpt
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * Get excerpt
     *
     * @return string
     */
    public function getExcerpt()
    {
        return $this->excerpt;
    }

    /**
     * Set excerpt length
     *
     * @param int $excerptLength
     */
    public function setExcerptLength($excerptLength)
    {
        $this->excerpt_length = (int) $excerptLength;
    }

    /**
     * Get excerpt length
     *
     * @return int
     */
    public function getExcerptLength()
    {
        return $this->excerpt_length;
    }

    /**
     * Set status
     *
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set commentStatus
     *
     * @param string $commentStatus
     */
    public function setCommentStatus($commentStatus)
    {
        $this->comment_status = $commentStatus;
    }

    /**
     * Get commentStatus
     *
     * @return string
     */
    public function getCommentStatus()
    {
        return $this->comment_status;
    }

    /**
     * Set pingStatus
     *
     * @param string $pingStatus
     */
    public function setPingStatus($pingStatus)
    {
        $this->ping_status = $pingStatus;
    }

    /**
     * Get pingStatus
     *
     * @return string
     */
    public function getPingStatus()
    {
        return $this->ping_status;
    }

    /**
     * Set password
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set post slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get post slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set toPing
     *
     * @param string $toPing
     */
    public function setToPing($toPing)
    {
        $this->to_ping = $toPing;
    }

    /**
     * Get toPing
     *
     * @return string
     */
    public function getToPing()
    {
        return $this->to_ping;
    }

    /**
     * Set pinged
     *
     * @param string $pinged
     */
    public function setPinged($pinged)
    {
        $this->pinged = $pinged;
    }

    /**
     * Get pinged
     *
     * @return string
     */
    public function getPinged()
    {
        return $this->pinged;
    }

    /**
     * Set modifiedDate
     *
     * @param \Datetime $modified_at
     */
    public function setModifiedAt($modified_at)
    {
        $this->modified_at = $modified_at;
    }

    /**
     * Get modifiedDate
     *
     * @return \Datetime
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set modifiedDateGmt
     *
     * @param \Datetime $modified_at_gmt
     */
    public function setModifiedAtGmt($modified_at_gmt)
    {
        $this->modified_at_gmt = $modified_at_gmt;
    }

    /**
     * Get modifiedDateGmt
     *
     * @return \Datetime
     */
    public function getModifiedAtGmt()
    {
        return $this->modified_at_gmt;
    }

    /**
     * Set contentFiltered
     *
     * @param string $contentFiltered
     */
    public function setContentFiltered($contentFiltered)
    {
        $this->content_filtered = $contentFiltered;
    }

    /**
     * Get contentFiltered
     *
     * @return string
     */
    public function getContentFiltered()
    {
        return $this->content_filtered;
    }

    /**
     * Set parent
     *
     * @param \Goutte\WordpressBundle\Entity\Post $parent
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }

    /**
     * Get parent
     *
     * @return \Goutte\WordpressBundle\Entity\Post
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Get parent
     *
     * @return \Goutte\WordpressBundle\Entity\Post
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add child
     *
     * @param \Goutte\WordpressBundle\Entity\Post $child
     */
    public function addChild(\Goutte\WordpressBundle\Entity\Post $child)
    {
        $child->setParent($this);
        $this->children[] = $child;
    }

    /**
     * Set guid
     *
     * @param string $guid
     */
    public function setGuid($guid)
    {
        $this->guid = $guid;
    }

    /**
     * Get guid
     *
     * @return string
     */
    public function getGuid()
    {
        return $this->guid;
    }

    /**
     * Set menuOrder
     *
     * @param integer $menuOrder
     */
    public function setMenuOrder($menuOrder)
    {
        $this->menu_order = $menuOrder;
    }

    /**
     * Get menuOrder
     *
     * @return integer
     */
    public function getMenuOrder()
    {
        return $this->menu_order;
    }

    /**
     * Set type
     *
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * Set mimeType
     *
     * @param string $mimeType
     */
    public function setMimeType($mimeType)
    {
        $this->mime_type = $mimeType;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mime_type;
    }

    /**
     * Set commentCount
     *
     * @param int $commentCount
     */
    public function setCommentCount($commentCount)
    {
        $this->comment_count = $commentCount;
    }

    /**
     * Get commentCount
     *
     * @return int
     */
    public function getCommentCount()
    {
        return $this->comment_count;
    }

    /**
     * Add metas
     *
     * @param \Goutte\WordpressBundle\Entity\PostMeta $meta
     */
    public function addMeta(\Goutte\WordpressBundle\Entity\PostMeta $meta)
    {
        $meta->setPost($this);
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
     * Get metas by meta key
     *
     * @param string $key
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMetasByKey($key)
    {
        return $this->getMetas()->filter(function($meta) use ($key) {
            return $meta->getKey() === $key;
        });
    }

    /**
     * Add comment
     *
     * @param \Goutte\WordpressBundle\Entity\Comment $comment
     */
    public function addComment(\Goutte\WordpressBundle\Entity\Comment $comment)
    {
        $comment->setPost($this);
        $this->comments[] = $comment;
        $this->comment_count = $this->getComments()->count();
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add taxonomies
     *
     * @param \Goutte\WordpressBundle\Entity\Taxonomy $taxonomy
     */
    public function addTaxonomy(\Goutte\WordpressBundle\Entity\Taxonomy $taxonomy)
    {
        $this->taxonomies[] = $taxonomy;
    }

    /**
     * Get taxonomies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaxonomies()
    {
        return $this->taxonomies;
    }

    /**
     * Set user
     *
     * @param \Goutte\WordpressBundle\Entity\User $user
     */
    public function setUser(\Goutte\WordpressBundle\Entity\User $user)
    {
        $this->user = $user;
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
                // prevent lazy loading the user entity becuase it might not exist
                $this->user->__load();
            } catch (\Doctrine\ORM\EntityNotFoundException $e) {
                // return null if user does not exist
                $this->user = null;
            }
        }

        return $this->user;
    }

}
