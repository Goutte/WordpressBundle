<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Goutte\WordpressBundle\Entity\Post;

class PostRepository extends EntityRepository
{
    /**
     * @return Query
     */
    public function getPublishedPostsQuery()
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p, a FROM Goutte\WordpressBundle\Entity\Post p
             INNER JOIN p.user a
             WHERE p.type = :type
             AND p.status = :status
             ORDER BY p.created_at DESC'
        );

        $query->setParameter('type',   Post::TYPE_POST);
        $query->setParameter('status', Post::STATUS_PUBLISH);

        return $query;
    }

    /**
     * Find published posts, maximum $maxResults and from offset $offset
     * @param integer $maxResults
     * @param integer $offset
     * @return Post Collection
     */
    public function findPublishedPosts($maxResults = 3, $offset = 0)
    {
        $query = $this->getPublishedPostsQuery();
        $query->setMaxResults($maxResults);
        $query->setFirstResult($offset);

        return $query->getResult();
    }

    /**
     * Find one published post or page, by its slug
     * @param string $slug
     * @return Post
     */
    public function findPublishedPostOrPageBySlug($slug)
    {
        $query = $this->getEntityManager()->createQuery(
            'SELECT p FROM Goutte \WordpressBundle\Entity\Post p
             WHERE p.slug = :slug
             AND p.status = :status
             AND p.type IN (:type_post, :type_page)'
        );

        $query->setParameter('slug',      $slug);
        $query->setParameter('status',    Post::STATUS_PUBLISH);
        $query->setParameter('type_post', Post::TYPE_POST);
        $query->setParameter('type_page', Post::TYPE_PAGE);

        return $query->getSingleResult();
    }


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
             AND p.mimeType = :mimeType
             ORDER BY p.created_at DESC'
        );

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
