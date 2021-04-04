<?php

namespace App\Repository;

use App\Entity\CliniqueLike;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method CliniqueLike|null find($id, $lockMode = null, $lockVersion = null)
 * @method CliniqueLike|null findOneBy(array $criteria, array $orderBy = null)
 * @method CliniqueLike[]    findAll()
 * @method CliniqueLike[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CliniqueLikeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CliniqueLike::class);
    }

    // /**
    //  * @return CliniqueLike[] Returns an array of CliniqueLike objects
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
    public function findOneBySomeField($value): ?CliniqueLike
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
