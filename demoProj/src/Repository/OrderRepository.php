<?php

namespace App\Repository;

use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function findByDate($date)
    {
        $dateStart = new \DateTime($date);
        $dateStart->setTime(7,0);
        $dateEnd = new \DateTime($date);
        $dateEnd->setTime(18,0);

        return $this->createQueryBuilder('o')
            ->andwhere('o.startDate > :dateStart')->setParameter('dateStart', $dateStart)
            ->andwhere('o.finishDate < :dateEnd')->setParameter('dateEnd', $dateEnd)
            //->select('o.startDate', 'o.finishDate')
            ->orderBy('o.startDate', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
