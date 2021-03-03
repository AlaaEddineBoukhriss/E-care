<?php

namespace App\Repository;

use App\Entity\RepresentantPara;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RepresentantPara|null find($id, $lockMode = null, $lockVersion = null)
 * @method RepresentantPara|null findOneBy(array $criteria, array $orderBy = null)
 * @method RepresentantPara[]    findAll()
 * @method RepresentantPara[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RepresentantParaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RepresentantPara::class);
    }

    // /**
    //  * @return RepresentantPara[] Returns an array of RepresentantPara objects
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
    public function findOneBySomeField($value): ?RepresentantPara
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
