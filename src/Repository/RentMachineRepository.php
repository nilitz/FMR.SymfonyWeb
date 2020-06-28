<?php

namespace App\Repository;

use App\Entity\RentMachine;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RentMachine|null find($id, $lockMode = null, $lockVersion = null)
 * @method RentMachine|null findOneBy(array $criteria, array $orderBy = null)
 * @method RentMachine[]    findAll()
 * @method RentMachine[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RentMachineRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RentMachine::class);
    }

    // /**
    //  * @return RentMachine[] Returns an array of RentMachine objects
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
    public function findOneBySomeField($value): ?RentMachine
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
