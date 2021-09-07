<?php

namespace App\Repository;

use App\Entity\Bike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bike|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bike|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bike[]    findAll()
 * @method Bike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bike::class);
    }

    public function findOneBySerialNumber($serialNumber)
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.serialNumber= :BIKENUMBER')
        ->setParameter('BIKENUMBER',$serialNumber)
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findByCategory($category,$page,$limit)
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.category= :CATEGORY')
        ->orderBy('b.size','ASC')
        ->setParameter('CATEGORY',$category)
        ->setFirstResult(($page * $limit)-$limit)
        ->setMaxResults($limit)
        ->getQuery()->getResult();
    }

    public function getPaginatedBike($page,$limit)
    {
        return $this->createQueryBuilder('b')
        ->orderBy('b.brand','ASC')
        ->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit)
        ->getQuery()->getResult();
    }

    public function getTotalBike()
    {
        return $this->createQueryBuilder('b')
        ->select('COUNT(b)')
        ->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Bike[] Returns an array of Bike objects
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
    public function findOneBySomeField($value): ?Bike
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
