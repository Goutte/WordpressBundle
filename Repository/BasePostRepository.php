<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Goutte\WordpressBundle\Entity\BasePost;
use Goutte\WordpressBundle\Entity\Post;

class BasePostRepository extends EntityRepository
{

    /**
     * Find published posts, maximum $maxResults and from offset $offset
     * @param integer $maxResults
     * @param integer $offset
     * @return \Doctrine\Common\Collections\Collection of Post
     */
    public function findPublished($maxResults = 3, $offset = 0)
    {
        $query = $this->cqbPublished()->getQuery();
        $query->setMaxResults($maxResults);
        $query->setFirstResult($offset);

        return $query->getResult();
    }


    /**
     * Find the pulished Post with the specified $slug
     * If not found, return false, don't throw
     * @param $slug
     * @return bool|Post
     */
    public function findPublishedBySlug($slug)
    {
        $qb = $this->cqbPublished();
        $qb->andWhere('p.slug = :slug');
        $qb->setParameter('slug', $slug);

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Doctrine\ORM\NoResultException $e) {}

        return false;
    }


    /**
     * Creates a QueryBuilder for Posts with the status published
     * Orders them by date of creation, most recent first
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function cqbPublished()
    {
        $qb = $this->createQueryBuilder('p');
        $qb->andWhere('p.status = :status');
        $qb->orderBy('p.created_at', 'DESC');

        $qb->setParameter('status', BasePost::STATUS_PUBLISH);

        return $qb;
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
