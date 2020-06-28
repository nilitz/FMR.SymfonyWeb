<?php

namespace App\Repository;

use App\Entity\RentTool;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentTool|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentTool|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentTool[]    findAll()
 * @method RentTool[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentToolRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentTool::class);
    }

    // /**
    //  * @return RentTool[] Returns an array of RentTool objects
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
    public function findOneBySomeField($value): ?RentTool
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
