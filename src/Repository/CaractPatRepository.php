<?php

namespace App\Repository;

use App\Entity\CaractPat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CaractPat|null find($id, $lockMode = null, $lockVersion = null)
 * @method CaractPat|null findOneBy(array $criteria, array $orderBy = null)
 * @method CaractPat[]    findAll()
 * @method CaractPat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CaractPatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CaractPat::class);
    }

    // /**
    //  * @return CaractPat[] Returns an array of CaractPat objects
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
    public function findOneBySomeField($value): ?CaractPat
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
