<?php

namespace App\Repository;

use App\Entity\NewOrder;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Exception;

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

    /**
     * @return array
     * @throws Exception
     */
    public function findNewOrdersForSend(): array
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.isSend = :isSend')
            ->andWhere('h.sendTime < :currentTime')
            ->setParameter('isSend', false)
            ->setParameter('currentTime', new DateTime())
            ->orderBy('h.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
