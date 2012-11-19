<?php

namespace Goutte\WordpressBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Validator\Constraints as Constraints;


/**
 * Goutte\WordpressBundle\Entity\Attachment
 *
 * @ORM\Entity(repositoryClass="Goutte\WordpressBundle\Repository\AttachmentRepository")
 */
class Attachment extends BasePost
{

    // fixme : add mime type related methods

}
