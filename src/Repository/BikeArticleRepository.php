<?php

namespace App\Repository;

use App\Entity\BikeArticle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BikeArticle|null find($id, $lockMode = null, $lockVersion = null)
 * @method BikeArticle|null findOneBy(array $criteria, array $orderBy = null)
 * @method BikeArticle[]    findAll()
 * @method BikeArticle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BikeArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BikeArticle::class);
    }

    // /**
    //  * @return BikeArticle[] Returns an array of BikeArticle objects
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
    public function findOneBySomeField($value): ?BikeArticle
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
