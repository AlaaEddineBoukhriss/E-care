<?php

namespace App\Repository;

use App\Entity\Categorief;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Categorief|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorief|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorief[]    findAll()
 * @method Categorief[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoriefRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Categorief::class);
    }

    // /**
    //  * @return Categorief[] Returns an array of Categorief objects
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
    public function findOneBySomeField($value): ?Categorief
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
