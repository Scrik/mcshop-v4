<?php

namespace McShop\NewsBundle\Repository;

use Doctrine\ORM\EntityRepository;
use McShop\NewsBundle\Entity\Post;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{
    const RETURN_QUERY = 0;
    const RETURN_RESULT = 1;

    /**
     * @param int $return_as
     * @return \Doctrine\ORM\QueryBuilder|Post[]
     */
    public function findAll($return_as = self::RETURN_RESULT)
    {
        $q = $this->createQueryBuilder('p');

        $query = $q
            ->select('p, u, c')
            ->join('p.user', 'u')
            ->leftJoin('p.commentaries', 'c')
        ;

        if ($return_as === self::RETURN_RESULT) {
            return $query->getQuery()->execute();
        }

        return $query;
    }
}
