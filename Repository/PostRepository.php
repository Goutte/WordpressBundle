<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Goutte\WordpressBundle\Entity\Post;

class PostRepository extends EntityRepository
{

    /**
     * Find published posts, maximum $maxResults and from offset $offset
     * @param integer $maxResults
     * @param integer $offset
     * @return \Doctrine\Common\Collections\Collection of Post
     */
    public function findPublished($maxResults = 3, $offset = 0)
    {
        $query = $this->cqbPublishedPost()->getQuery();
        $query->setMaxResults($maxResults);
        $query->setFirstResult($offset);

        return $query->getResult();
    }


    /**
     * Find the pulished Post with the specified $slug
     * If not found, return false
     * @param $slug
     * @return bool|Post
     */
    public function findPublishedBySlug($slug)
    {
        $qb = $this->cqbPublishedPost();
        $qb->andWhere('p.slug = :slug');
        $qb->setParameter('slug', $slug);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {
            return false;
        }
    }

    /**
     * Creates a QueryBuilder for Posts with the status published
     * Orders them by date of creation, most recent first
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function cqbPublishedPost()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('p.status = :status');
        $qb->andWhere('p.type   = :type_post');
        $qb->orderBy('p.created_at', 'DESC');

        $qb->setParameter('status',    Post::STATUS_PUBLISH);
        $qb->setParameter('type_post', Post::TYPE_POST);

        return $qb;
    }



//// FIXME : MOVE THIS

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
              ->where   ('p.type      = :type')
              ->andWhere('p.status    = :status')
              ->andWhere('p.mime_type = :mime_type');

            $q->setParameter('type',     Post::TYPE_ATTACHMENT);
            $q->setParameter('status',   Post::STATUS_INHERIT);
            $q->setParameter('mimeType', $mimeType);
        }


        $query->setParameter('type',     Post::TYPE_ATTACHMENT);
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




//    /**
//     * @return Doctrine\ORM\Query
//     */
//    public function getPublishedPostsByTagQuery($tagSlug)
//    {
//        $query = $this->getEntityManager()->createQuery(
//            'SELECT p, a FROM PSS\Bundle\BlogBundle\Entity\Post p
//             INNER JOIN p.author a
//             INNER JOIN p.termRelationships tr
//             INNER JOIN tr.termTaxonomy tt
//             INNER JOIN tt.term t
//             WHERE p.type = :type
//               AND p.status = :status
//               AND tt.taxonomy = :taxonomy
//               AND t.slug = :slug
//             ORDER BY p.publishedAt DESC'
//        );
//
//        $query->setParameter('type', Post::TYPE_POST);
//        $query->setParameter('status', Post::STATUS_PUBLISH);
//        $query->setParameter('slug', $tagSlug);
//        $query->setParameter('taxonomy', TermTaxonomy::POST_TAG);
//
//        return $query;
//    }
}
