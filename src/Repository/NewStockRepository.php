<?php

namespace App\Repository;

use App\Entity\NewStock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method NewStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method NewStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method NewStock[]    findAll()
 * @method NewStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewStock::class);
    }

    public function findOneByLabelBrand($label, $brand)
    {
        return $this->createQueryBuilder('n')
        ->andWhere('n.label= :LABEL')
        ->setParameter('LABEL',$label)
        ->andWhere('n.brand= :BRAND')
        ->setParameter('BRAND',$brand)
      
        ->getQuery()
        ->getOneOrNullResult();
    }

    public function findByLabel($label)
    {
        return $this->createQueryBuilder('n')
        ->andWhere('n.label LIKE :LABEL')
        ->orderBy('n.label','ASC')
        ->setParameter('LABEL','%' . $label . '%')
        ->getQuery()->getResult();
    }

    // /**
    //  * @return NewStock[] Returns an array of NewStock objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?NewStock
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
