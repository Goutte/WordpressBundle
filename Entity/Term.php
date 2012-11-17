<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Constraints;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Goutte\WordpressBundle\Entity\Term
 *
 * @ORM\Table(name="terms")
 * @ORM\Entity
 */
class Term
{
    /**
     * @var int $id
     *
     * @ORM\Column(name="term_id", type="wordpress_id", length=20)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=200)
     * @Constraints\NotBlank()
     */
    private $name;

    /**
     * @var string $slug
     *
     * @ORM\Column(name="slug", type="string", length=200)
     * @Gedmo\Slug(fields={"name"})
     */
    private $slug;

    /**
     * @var int $group
     *
     * @ORM\Column(name="term_group", type="int", length=10)
     */
    private $group = 0;

    /**
     * @var \Goutte\WordpressBundle\Entity\Taxonomy
     *
     * @ORM\OneToOne(targetEntity="Taxonomy", mappedBy="term")
     **/
    private $taxonomy;

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
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set group
     *
     * @param int $group
     */
    public function setGroup($group)
    {
        $this->group = $group;
    }

    /**
     * Get group
     *
     * @return int
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Set taxonomy
     *
     * @param \Goutte\WordpressBundle\Entity\Taxonomy $taxonomy
     */
    public function setTaxonomy(\Goutte\WordpressBundle\Entity\Taxonomy $taxonomy)
    {
        $this->taxonomy = $taxonomy;
    }

    /**
     * Get taxonomy
     *
     * @return \Goutte\WordpressBundle\Entity\Taxonomy
     */
    public function getTaxonomy()
    {
        return $this->taxonomy;
    }
}
