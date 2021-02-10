<?php

namespace App\Repository;

use App\Entity\TauxVariable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TauxVariable|null find($id, $lockMode = null, $lockVersion = null)
 * @method TauxVariable|null findOneBy(array $criteria, array $orderBy = null)
 * @method TauxVariable[]    findAll()
 * @method TauxVariable[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TauxVariableRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TauxVariable::class);
    }

    // /**
    //  * @return TauxVariable[] Returns an array of TauxVariable objects
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
    public function findOneBySomeField($value): ?TauxVariable
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
