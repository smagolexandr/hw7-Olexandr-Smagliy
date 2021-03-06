<?php

namespace AppBundle\Repository\Blog;

/**
 * CommentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommentRepository extends \Doctrine\ORM\EntityRepository
{
    public function getCommentsSorted($post_id)
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c, u
                            FROM AppBundle:Blog\Comment c
                            LEFT JOIN c.user u
                            WHERE c.post = :post AND c.approved = 1
                            ORDER BY c.createdAt DESC')
            ->setParameter('post', $post_id)
            ->getResult();
    }

    public function getUnapprovedComments()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c, p, u
                             FROM AppBundle:Blog\Comment c
                             JOIN c.post p
                             JOIN c.user u
                             WHERE c.approved = 0 AND p.approved = 1
                             ORDER BY c.createdAt DESC
                            ')
            ->getResult();
    }

    public function getLastComments()
    {
        return $this->getEntityManager()
            ->createQuery('SELECT c, u, p
                            FROM AppBundle:Blog\Comment c
                            LEFT JOIN c.user u
                            LEFT JOIN c.post p
                            WHERE c.approved = 1 AND p.approved = 1
                            ORDER BY c.createdAt DESC
                            ')
            ->setMaxResults(5)
            ->getResult();
        //todo fix getting comments of post in 1 query
//        ->createQuery('SELECT c, a, p
//                            FROM AppBundle:Comment c
//                            LEFT JOIN c.author a
//                            LEFT JOIN c.post p
//                            LEFT JOIN p.comments pc
//                            WHERE pc.post = p.id
//                            ORDER BY c.createdAt ASC
//                            ')
//        ->setMaxResults(5)
    }
}
