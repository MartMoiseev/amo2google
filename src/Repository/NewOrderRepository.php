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
}
