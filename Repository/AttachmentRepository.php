<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Goutte\WordpressBundle\Entity\Post;

class AttachmentRepository extends PostRepository
{

    // FIXME

    /**
     * @param $mimeType
     * @return Query
     */
    public function getMediasQuery($mimeType)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM Goutte\WordpressBundle\Entity\Post p
             WHERE p.type = :type
             AND p.status   = :status
             AND p.mime_type = :mimeType
             ORDER BY p.created_at DESC'
        );

        list ($type, $subtype) = explode('/', $mimeType);

        if (empty($subtype)) {

        } else {
            $q = new \Doctrine\ORM\QueryBuilder($this->getEntityManager());
            $q->select('p')
              ->from('Goutte\WordpressBundle\Entity\Post', 'p')
//              ->where   ('p._post_type      = :type')
              ->andWhere('p.status    = :status')
              ->andWhere('p.mime_type = :mime_type');

//            $q->setParameter('type',     Post::TYPE_ATTACHMENT);
            $q->setParameter('status',   Post::STATUS_INHERIT);
            $q->setParameter('mimeType', $mimeType);
        }


//        $query->setParameter('type',     Post::TYPE_ATTACHMENT);
        $query->setParameter('status',   Post::STATUS_INHERIT);
        $query->setParameter('mimeType', $mimeType);

        return $query;
    }





    /**
     * Finds all Jpeg Images
     */
    public function findJpegImages()
    {
        $mimeType = 'image/jpeg';

        return $this->getMediasQuery($mimeType)->getResult();
    }

}
