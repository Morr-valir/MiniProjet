<?php

namespace App\Repository;

use App\Entity\ConcessionnaireAPI;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ConcessionnaireAPI|null find($id, $lockMode = null, $lockVersion = null)
 * @method ConcessionnaireAPI|null findOneBy(array $criteria, array $orderBy = null)
 * @method ConcessionnaireAPI[]    findAll()
 * @method ConcessionnaireAPI[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ConcessionnaireAPIRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ConcessionnaireAPI::class);
    }

    // /**
    //  * @return ConcessionnaireAPI[] Returns an array of ConcessionnaireAPI objects
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
    public function findOneBySomeField($value): ?ConcessionnaireAPI
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
