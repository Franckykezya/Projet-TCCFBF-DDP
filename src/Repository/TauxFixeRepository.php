<?php

namespace App\Repository;

use App\Entity\TauxFixe;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TauxFixe|null find($id, $lockMode = null, $lockVersion = null)
 * @method TauxFixe|null findOneBy(array $criteria, array $orderBy = null)
 * @method TauxFixe[]    findAll()
 * @method TauxFixe[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TauxFixeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TauxFixe::class);
    }

    // /**
    //  * @return TauxFixe[] Returns an array of TauxFixe objects
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
    public function findOneBySomeField($value): ?TauxFixe
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
