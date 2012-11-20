<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\Mapping as ORM; // needed (inheritance?)
use Doctrine\ORM\QueryBuilder;
use Goutte\WordpressBundle\Entity\Attachment;

class AttachmentRepository extends BasePostRepository
{
    /**
     * Finds the images
     * @param string|array|null $subtypes
     * @return array
     */
    public function findImages($subtypes = null)
    {
        $qb = $this->cqbForTypeAndSubtypes(Attachment::TYPE_IMAGE, $subtypes);
        return $qb->getQuery()->getResult();
    }

    /**
     * Creates QueryBuilder for specified mime $type and optional $subtypes
     * @param string $type
     * @param mixed  $subtypes
     * @return QueryBuilder
     */
    public function cqbForTypeAndSubtypes($type, $subtypes=null)
    {
        $qb = $this->createQueryBuilder('a');
        if (empty($subtypes)) {
            $qb->andWhere('a.mime_type LIKE :type');
            $qb->setParameter('type', $type.'%');
        } else {
            $subtypes = (array) $subtypes;
            $mimes = array();
            foreach ($subtypes as $subtype) {
                $mimes[] = "{$type}/{$subtype}";
            }
            $qb->andWhere($qb->expr()->in('a.mime_type', $mimes));
        }

        return $qb;
    }
}
