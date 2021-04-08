<?php

namespace App\Repository;

use App\Entity\Pharmacie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Pharmacie|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pharmacie|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pharmacie[]    findAll()
 * @method Pharmacie[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PharmacieRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pharmacie::class);
    }

    // /**
    //  * @return Pharmacie[] Returns an array of Pharmacie objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Pharmacie
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
