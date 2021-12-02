<?php

namespace App\Repository;

use App\Entity\Concessionnaire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Concessionnaire|null find($id, $lockMode = null, $lockVersion = null)
 * @method Concessionnaire|null findOneBy(array $criteria, array $orderBy = null)
 * @method Concessionnaire[]    findAll()
 * @method Concessionnaire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcessionnaireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Concessionnaire::class);
    }

    // /**
    //  * @return Concessionnaire[] Returns an array of Concessionnaire objects
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
    public function findOneBySomeField($value): ?Concessionnaire
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
