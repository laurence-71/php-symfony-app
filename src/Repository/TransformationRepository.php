<?php

namespace App\Repository;

use App\Entity\Transformation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Transformation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Transformation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Transformation[]    findAll()
 * @method Transformation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TransformationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Transformation::class);
    }

    // /**
    //  * @return Transformation[] Returns an array of Transformation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Transformation
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
