<?php

namespace App\Repository;

use App\Entity\Billing;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Billing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Billing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Billing[]    findAll()
 * @method Billing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BillingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Billing::class);
    }

    public function findByDate($billingDate)
    {
        return $this->createQueryBuilder('b')
        ->andWhere('b.billingDate BETWEEN :DATE AND :NOW')
        ->setParameter('DATE',$billingDate->format('Y-m-d 00:00'))
        ->setParameter('NOW',new \DateTime('NOW'))
        ->orderBy('b.billingDate','DESC')
        ->getQuery()->getResult();
    }

    public function getPaginatedBilling($page,$limit)
    {
        return $this->createQueryBuilder('b')
        ->orderBy('b.billingDate','DESC')
        ->setFirstResult(($page * $limit) - $limit)
        ->setMaxResults($limit)
        ->getQuery()->getResult();
    }

    public function getTotalBilling()
    {
        return $this->createQueryBuilder('b')
        ->select('COUNT(b)')
        ->getQuery()->getSingleScalarResult();
    }

    // /**
    //  * @return Billing[] Returns an array of Billing objects
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
    public function findOneBySomeField($value): ?Billing
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
