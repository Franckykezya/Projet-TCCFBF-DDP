<?php

namespace App\Repository;

use App\Entity\TauxInteretType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TauxInteretType|null find($id, $lockMode = null, $lockVersion = null)
 * @method TauxInteretType|null findOneBy(array $criteria, array $orderBy = null)
 * @method TauxInteretType[]    findAll()
 * @method TauxInteretType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TauxInteretTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TauxInteretType::class);
    }

    // /**
    //  * @return TauxInteretType[] Returns an array of TauxInteretType objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TauxInteretType
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
