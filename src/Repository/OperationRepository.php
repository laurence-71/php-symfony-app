<?php

namespace App\Repository;

use App\Entity\Operation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Operation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Operation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Operation[]    findAll()
 * @method Operation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OperationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Operation::class);
    }

    public function countByDate()
    {
        return $this->createQueryBuilder('o')
        ->select('SUBSTRING(o.receptionDate,1,10) as operationDate , COUNT(o) as operationCount')
        ->groupBy('operationDate')
        ->getQuery()->getResult();
    }

    public function countRepairByDate()
    {
        return $this->createQueryBuilder('o')
        ->select('COUNT(o.repair) as repairCount')
        ->addSelect('SUBSTRING(o.receptionDate,1,10) as operationDate')
        ->groupBy('operationDate')
        ->getQuery()->getResult();
       
    }

    public function countRecyclingByDate()
    {
        return $this->createQueryBuilder('o')
        ->select('COUNT(o.recycling) as recyclingCount')
        ->addSelect('SUBSTRING(o.receptionDate,1,10) as operationDate')
        ->groupBy('operationDate')
        ->getQuery()->getResult();
    }

    public function findByDate($receptionDate)
    {
        return $this->createQueryBuilder('o')
        ->andWhere('o.receptionDate BETWEEN :DATE AND :NOW')
        ->setParameter('DATE',$receptionDate->format('Y-m-d 00:00'))
        ->setParameter('NOW',new \DateTime('NOW'))
        ->orderBy('o.receptionDate','DESC')
       
        ->getQuery()->getResult();
    }

    public function getPaginatedOperation($page,$limit)
    {
        return $this->createQueryBuilder('o')
        ->orderBy('o.receptionDate','DESC')
        ->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit)
        ->getQuery()->getResult();
    }

    public function getTotalOperation()
    {
        return $this->createQueryBuilder('o')
        ->select('COUNT(o)')
        ->getQuery()->getSingleScalarResult();
    }
    

    // /**
    //  * @return Operation[] Returns an array of Operation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Operation
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
