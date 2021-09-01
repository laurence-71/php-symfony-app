<?php

namespace App\Repository;

use App\Entity\BikesStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BikesStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method BikesStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method BikesStock[]    findAll()
 * @method BikesStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikesStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BikesStock::class);
    }

    // /**
    //  * @return BikesStock[] Returns an array of BikesStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?BikesStock
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
