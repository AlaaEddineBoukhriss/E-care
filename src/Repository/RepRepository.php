<?php

namespace App\Repository;

use App\Entity\Rep;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Rep|null find($id, $lockMode = null, $lockVersion = null)
 * @method Rep|null findOneBy(array $criteria, array $orderBy = null)
 * @method Rep[]    findAll()
 * @method Rep[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Rep::class);
    }

    // /**
    //  * @return Rep[] Returns an array of Rep objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Rep
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
