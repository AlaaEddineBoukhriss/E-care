<?php

namespace App\Repository;

use App\Entity\RepresentantClinique;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepresentantClinique|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentantClinique|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentantClinique[]    findAll()
 * @method RepresentantClinique[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentantCliniqueRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepresentantClinique::class);
    }

    // /**
    //  * @return RepresentantClinique[] Returns an array of RepresentantClinique objects
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
    public function findOneBySomeField($value): ?RepresentantClinique
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
