<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraints;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Goutte\WordpressBundle\Entity\User
 *
 * @ORM\Table(name="users")
 * @ORM\Entity
 * @UniqueEntity({"fields": "email",       "message": "Sorry, that email address is already used."})
 * @UniqueEntity({"fields": "username",    "message": "Sorry, that username is already used."})
 * @UniqueEntity({"fields": "nicename",    "message": "Sorry, that nicename is already used."})
 * @UniqueEntity({"fields": "displayName", "message": "Sorry, that display name has already been taken."})
 * @ORM\HasLifecycleCallbacks
 */
class User implements UserInterface
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="ID", type="wordpress_id", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $user_name
     *
     * @ORM\Column(name="user_login", type="string", length=60, unique=true)
     * @Constraints\NotBlank(groups={"register", "edit"})
     */
    private $user_name;

    /**
     * @var string $nice_name
     *
     * @ORM\Column(name="user_nicename", type="string", length=64)
     * @Constraints\NotBlank(groups={"unused"})
     */
    private $nice_name;

    /**
     * @var string $display_name
     *
     * @ORM\Column(name="display_name", type="string", length=250)
     * @Constraints\NotBlank(groups={"edit"})
     */
    private $display_name;

    /**
     * @var string $email
     *
     * @ORM\Column(name="user_email", type="string", length=100)
     * @Constraints\NotBlank(groups={"register", "edit"})
     * @Constraints\Email(groups={"register", "edit"})
     */
    private $email;

    /**
     * @var string $password
     *
     * @ORM\Column(name="user_pass", type="string", length=64)
     * @Constraints\NotBlank(groups={"register", "edit"})
     */
    private $password;

    /**
     * @var string $url
     *
     * @ORM\Column(name="user_url", type="string", length=100)
     * @Constraints\Url()
     */
    private $url = '';

    /**
     * @var \Datetime $registered_at
     *
     * @ORM\Column(name="user_registered", type="datetime")
     */
    private $registered_at;

    /**
     * @var string $activation_key
     *
     * @ORM\Column(name="user_activation_key", type="string", length=60)
     */
    private $activation_key;

    /**
     * @var integer $status
     * I have NO IDEA what this is !?
     *
     * @ORM\Column(name="user_status", type="integer", length=11)
     */
    private $status = 0;

    /**
     * @var \Goutte\WordpressBundle\Entity\Post
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\Post", mappedBy="user")
     */
    private $posts;

    /**
     * @var \Goutte\WordpressBundle\Entity\Comment
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\Comment", mappedBy="user")
     */
    private $comments;

    /**
     * @var \Goutte\WordpressBundle\Entity\UserMeta
     *
     * @ORM\OneToMany(targetEntity="Goutte\WordpressBundle\Entity\UserMeta", mappedBy="user", cascade={"persist"})
     */
    private $metas;


    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    public function __construct()
    {
        $this->metas    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->posts    = new \Doctrine\Common\Collections\ArrayCollection();
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        $this->registered_at = new \DateTime('now');
    }

    ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

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
     * Set username
     *
     * @param string $username
     * @return void
     */
    public function setUserName($username)
    {
        $this->user_name = $username;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * Set nicename
     *
     * @param string $niceName
     */
    public function setNiceName($niceName)
    {
        $this->nice_name = $niceName;
    }

    /**
     * Get nicename
     *
     * @return string
     */
    public function getNiceName()
    {
        return $this->nice_name;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->display_name = $displayName;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
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
     * Set url
     *
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set registeredDate
     *
     * @param \Datetime $registered_at
     */
    public function setRegisteredAt($registered_at)
    {
        $this->registered_at = $registered_at;
    }

    /**
     * Get registeredDate
     *
     * @return \Datetime
     */
    public function getRegisteredAt()
    {
        return $this->registered_at;
    }

    /**
     * Set activationKey
     *
     * @param string $activation_key
     */
    public function setActivationKey($activation_key)
    {
        $this->activation_key = $activation_key;
    }

    /**
     * Get activationKey
     *
     * @return string
     */
    public function getActivationKey()
    {
        return $this->activation_key;
    }

    /**
     * Set status
     *
     * @param integer $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * Get status
     *
     * @return integer
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
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
     * Add meta
     *
     * @param \Goutte\WordpressBundle\Entity\UserMeta $meta
     */
    public function addMeta(\Goutte\WordpressBundle\Entity\UserMeta $meta)
    {
        $this->metas[] = $meta;

        $meta->setUser($this);
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
        return $this->getMetas()->filter(function ($meta) use ($key) {
            return $meta->getKey() === $key;
        });
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        $roles = array();
        $metas = $this->getMetasByKey('wp_capabilities');

        if ($metas->isEmpty()) {
            return array();
        }

        $capabilities = $metas->first()->getValue();

        if (!is_array($capabilities)) {
            return array();
        }

        foreach ($capabilities as $role => $value) {
            $roles[] = 'ROLE_WP_' . strtoupper($role);
        }

        return $roles;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    public function getSalt()
    {

    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    public function eraseCredentials()
    {

    }

    /**
     * Returns whether or not the given user is equivalent to *this* user.
     *
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     *
     * @return Boolean
     */
    public function equals(UserInterface $user)
    {
        return ($this->getId() === $user->getId()) && ($this->getUsername() === $user->getUsername());
    }
}
