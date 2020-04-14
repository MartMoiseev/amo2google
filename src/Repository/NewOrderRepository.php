<?php

namespace App\Repository;

use App\Entity\NewOrder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method NewOrder|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewOrder|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewOrder[]    findAll()
 * @method NewOrder[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewOrderRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewOrder::class);
    }

    // /**
    //  * @return NewOrder[] Returns an array of NewOrder objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewOrder
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
