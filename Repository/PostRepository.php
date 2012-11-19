<?php

namespace Goutte\WordpressBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query;
use Goutte\WordpressBundle\Entity\Post;

class PostRepository extends BasePostRepository
{



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
