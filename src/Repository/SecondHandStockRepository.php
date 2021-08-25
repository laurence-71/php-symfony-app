<?php

namespace App\Repository;

use App\Entity\SecondHandStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecondHandStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecondHandStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecondHandStock[]    findAll()
 * @method SecondHandStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecondHandStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondHandStock::class);
    }

    public function findOneByLabelBrandQuantity($label,$brand,$quantity)
    {
        return $this->createQueryBuilder('s')
        ->andWhere('s.label= :LABEL')
        ->setParameter('LABEL',$label)
        ->andWhere('s.brand= :BRAND')
        ->setParameter('BRAND',$brand)
        ->andWhere('s.quantity= :QUANTITY')
        ->setParameter('QUANTITY',$quantity)
        ->getQuery()
        ->getOneOrNullResult();
    }

    // /**
    //  * @return SecondHandStock[] Returns an array of SecondHandStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecondHandStock
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
