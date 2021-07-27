<?php

namespace App\Repository;

use App\Entity\Set;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Set|null find($id, $lockMode = null, $lockVersion = null)
 * @method Set|null findOneBy(array $criteria, array $orderBy = null)
 * @method Set[]    findAll()
 * @method Set[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Set::class);
    }

    // /**
    //  * @return Set[] Returns an array of Set objects
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
    public function findOneBySomeField($value): ?Set
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findSoon()
    {
        return $this->createQueryBuilder('soon')
        ->andWhere('soon.date_parution> :today')
        ->setParameter('today', date("Y-m-d"))
        ->orderBy("soon.date_parution", 'ASC')
        ->setMaxResults(2)
        ->getQuery()
        ->getResult()
        ;
    }

    public function findNouveau()
    {
        return $this->createQueryBuilder('nouveau')
        ->andWhere('nouveau.date_parution < :today')
        ->setParameter('today', date("Y-m-d"))
        ->orderBy("nouveau.date_parution", 'Desc')
        ->setMaxResults(2)
        ->getQuery()
        ->getResult()
        ;
    }



}