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
    private $excerptLength = 100;

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
    private $commentStatus = self::STATUS_OPEN;

    /**
     * @var string $pingStatus
     *
     * @ORM\Column(name="ping_status", type="string", length=20, nullable=false)
     */
    private $pingStatus = self::STATUS_OPEN;

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
     * @var text $toPing
     *
     * @ORM\Column(name="to_ping", type="text", nullable=false)
     */
    private $toPing = "";

    /**
     * @var text $pinged
     *
     * @ORM\Column(name="pinged", type="text", nullable=false)
     */
    private $pinged = "";

    /**
     * @var text $contentFiltered
     *
     * @ORM\Column(name="post_content_filtered", type="text", nullable=false)
     */
    private $contentFiltered = "";

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
     * @var integer $menuOrder
     *
     * @ORM\Column(name="menu_order", type="integer", length=11, nullable=false)
     */
    private $menuOrder = 0;

    /**
     * @var string $type
     *
     * @ORM\Column(name="post_type", type="string", nullable=false)
     */
    private $type = self::TYPE_POST;

    /**
     * @var string $mimeType
     *
     * @ORM\Column(name="post_mime_type", type="string", length=100, nullable=false)
     */
    private $mimeType = "";

    /**
     * @var bigint $commentCount
     *
     * @ORM\Column(name="comment_count", type="bigint", length=20, nullable=false)
     */
    private $commentCount = 0;

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
        $this->created_at            = new \DateTime('now');
        $this->created_at_gmt         = new \DateTime('now', new \DateTimeZone('GMT'));
        $this->modified_at    = new \DateTime('now');
        $this->modified_at_gmt = new \DateTime('now', new \DateTimeZone('GMT'));
    }

    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        $this->modified_at     = new \DateTime('now');
        $this->modified_at_gmt  = new \DateTime('now', new \DateTimeZone('GMT'));
    }

    /**
     * Get ID
     *
     * @return bigint
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date
     *
     * @param datetime $date
     */
    public function setCreatedAt($date)
    {
        $this->created_at = $date;
    }

    /**
     * Get date
     *
     * @return datetime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set dateGmt
     *
     * @param datetime $dateGmt
     */
    public function setCreatedAtGmt($dateGmt)
    {
        $this->created_at_gmt = $dateGmt;
    }

    /**
     * Get dateGmt
     *
     * @return datetime
     */
    public function getCreatedAtGmt()
    {
        return $this->created_at_gmt;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content)
    {
        $this->content = $content;

        $this->excerpt = $this->trimContent($content);
    }

    /**
     * Cut string to n symbols and add delim but do not break words.
     *
     * @param string string we are operating with
     * @param integer character count to cut to
     * @param string|NULL delimiter. Default: '...'
     * @return string processed string
     **/
    public function trimContent($content)
    {
        $content = strip_tags($content);
        $length = $this->getExcerptLength();

        if (strlen($content) <= $length) {
            // return origin content if not needed
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
     * Get content
     *
     * @return text
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set title
     *
     * @param text $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * Get title
     *
     * @return text
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set excerpt
     *
     * @param text $excerpt
     */
    public function setExcerpt($excerpt)
    {
        $this->excerpt = $excerpt;
    }

    /**
     * Get excerpt
     *
     * @return text
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
        $this->excerptLength = (int) $excerptLength;
    }

    /**
     * Get excerpt length
     *
     * @return int
     */
    public function getExcerptLength()
    {
        return $this->excerptLength;
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
        $this->commentStatus = $commentStatus;
    }

    /**
     * Get commentStatus
     *
     * @return string
     */
    public function getCommentStatus()
    {
        return $this->commentStatus;
    }

    /**
     * Set pingStatus
     *
     * @param string $pingStatus
     */
    public function setPingStatus($pingStatus)
    {
        $this->pingStatus = $pingStatus;
    }

    /**
     * Get pingStatus
     *
     * @return string
     */
    public function getPingStatus()
    {
        return $this->pingStatus;
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
     * @param text $toPing
     */
    public function setToPing($toPing)
    {
        $this->toPing = $toPing;
    }

    /**
     * Get toPing
     *
     * @return text
     */
    public function getToPing()
    {
        return $this->toPing;
    }

    /**
     * Set pinged
     *
     * @param text $pinged
     */
    public function setPinged($pinged)
    {
        $this->pinged = $pinged;
    }

    /**
     * Get pinged
     *
     * @return text
     */
    public function getPinged()
    {
        return $this->pinged;
    }

    /**
     * Set modifiedDate
     *
     * @param datetime $modifiedDate
     */
    public function setModifiedAt($modifiedDate)
    {
        $this->modified_at = $modifiedDate;
    }

    /**
     * Get modifiedDate
     *
     * @return datetime
     */
    public function getModifiedAt()
    {
        return $this->modified_at;
    }

    /**
     * Set modifiedDateGmt
     *
     * @param datetime $modifiedDateGmt
     */
    public function setModifiedAtGmt($modifiedDateGmt)
    {
        $this->modified_at_gmt = $modifiedDateGmt;
    }

    /**
     * Get modifiedDateGmt
     *
     * @return datetime
     */
    public function getModifiedAtGmt()
    {
        return $this->modified_at_gmt;
    }

    /**
     * Set contentFiltered
     *
     * @param text $contentFiltered
     */
    public function setContentFiltered($contentFiltered)
    {
        $this->contentFiltered = $contentFiltered;
    }

    /**
     * Get contentFiltered
     *
     * @return text
     */
    public function getContentFiltered()
    {
        return $this->contentFiltered;
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
     * Set parent
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
        $this->menuOrder = $menuOrder;
    }

    /**
     * Get menuOrder
     *
     * @return integer
     */
    public function getMenuOrder()
    {
        return $this->menuOrder;
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
        $this->mimeType = $mimeType;
    }

    /**
     * Get mimeType
     *
     * @return string
     */
    public function getMimeType()
    {
        return $this->mimeType;
    }

    /**
     * Set commentCount
     *
     * @param bigint $commentCount
     */
    public function setCommentCount($commentCount)
    {
        $this->commentCount = $commentCount;
    }

    /**
     * Get commentCount
     *
     * @return bigint
     */
    public function getCommentCount()
    {
        return $this->commentCount;
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
        $this->commentCount = $this->getComments()->count();
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
}
