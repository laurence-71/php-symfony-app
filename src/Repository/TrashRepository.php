<?php

namespace App\Repository;

use App\Entity\Trash;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Trash|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trash|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trash[]    findAll()
 * @method Trash[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrashRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trash::class);
    }

    // /**
    //  * @return Trash[] Returns an array of Trash objects
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
    public function findOneBySomeField($value): ?Trash
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
