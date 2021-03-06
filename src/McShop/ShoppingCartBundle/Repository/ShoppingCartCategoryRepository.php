<?php
namespace McShop\ShoppingCartBundle\Repository;

use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use McShop\ShoppingCartBundle\Entity\ShoppingCartCategory;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

/**
 * ShoppingCartCategoryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShoppingCartCategoryRepository extends NestedTreeRepository
{
    /**
     * @return Pagerfanta|ShoppingCartCategory[]
     */
    public function findAllWithPagination()
    {
        $qb = $this->createQueryBuilder('c');

        $qb
            ->select('c, p, ch, i')
            ->leftJoin('c.parent', 'p')
            ->leftJoin('c.children', 'ch')
            ->leftJoin('c.items', 'i')
            ->orderBy('c.id', 'ASC')
        ;

        $adapter = new DoctrineORMAdapter($qb);

        return new Pagerfanta($adapter);
    }

    /**
     * @return mixed
     */
    public function getTotalCount()
    {
        $qb = $this->createQueryBuilder('c');

        return $qb->select('COUNT(c)')->getQuery()->getSingleScalarResult();
    }
}
