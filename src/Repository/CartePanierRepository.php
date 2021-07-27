<?php

namespace App\Repository;

use App\Entity\CartePanier;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CartePanier|null find($id, $lockMode = null, $lockVersion = null)
 * @method CartePanier|null findOneBy(array $criteria, array $orderBy = null)
 * @method CartePanier[]    findAll()
 * @method CartePanier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CartePanierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CartePanier::class);
    }

    // /**
    //  * @return CartePanier[] Returns an array of CartePanier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CartePanier
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
