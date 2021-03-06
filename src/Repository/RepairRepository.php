<?php

namespace App\Repository;

use App\Entity\Repair;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repair|null find($id, $lockMode = null, $lockVersion = null)
 * @method Repair|null findOneBy(array $criteria, array $orderBy = null)
 * @method Repair[]    findAll()
 * @method Repair[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepairRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repair::class);
    }
    
    public function getPaginatedRepair($page, $limit)
    {
        return $this->createQueryBuilder('r')
        ->orderBy('r.takingCareDate','DESC')
        ->setFirstResult(($page * $limit) -$limit)
        ->setMaxResults($limit)
        ->getQuery()->getResult();
    }

    public function getTotalRepair()
    {
        return $this->createQueryBuilder('r')
        ->select('COUNT(r)')
        ->getQuery()->getSingleScalarResult();
    }

    public function getTotalCurrentRepair()
    {
        return $this->createQueryBuilder('r')
        ->select('COUNT(r.validation)')
        ->getQuery()->getSingleScalarResult();
    }
  
    // /**
    //  * @return Repair[] Returns an array of Repair objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Repair
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
