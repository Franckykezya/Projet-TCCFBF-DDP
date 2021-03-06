<?php

namespace App\Repository;

use App\Entity\SecteurIntervention;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecteurIntervention|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecteurIntervention|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecteurIntervention[]    findAll()
 * @method SecteurIntervention[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecteurInterventionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecteurIntervention::class);
    }

    // /**
    //  * @return SecteurIntervention[] Returns an array of SecteurIntervention objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SecteurIntervention
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
