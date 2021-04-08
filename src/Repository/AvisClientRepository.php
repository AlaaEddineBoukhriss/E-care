<?php

namespace App\Repository;

use App\Entity\AvisClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method AvisClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method AvisClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method AvisClient[]    findAll()
 * @method AvisClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvisClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AvisClient::class);
    }

    // /**
    //  * @return AvisClient[] Returns an array of AvisClient objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AvisClient
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
