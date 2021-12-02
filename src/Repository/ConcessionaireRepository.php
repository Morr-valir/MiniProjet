<?php

namespace App\Repository;

use App\Entity\Concessionaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concessionaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concessionaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concessionaire[]    findAll()
 * @method Concessionaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcessionaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concessionaire::class);
    }

    // /**
    //  * @return Concessionaire[] Returns an array of Concessionaire objects
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
    public function findOneBySomeField($value): ?Concessionaire
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
