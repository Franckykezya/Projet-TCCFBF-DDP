<?php

namespace App\Repository;

use App\Entity\HistoriqueDecaissement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HistoriqueDecaissement|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistoriqueDecaissement|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistoriqueDecaissement[]    findAll()
 * @method HistoriqueDecaissement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistoriqueDecaissementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistoriqueDecaissement::class);
    }

    public function findProjetId($id){
        return $this->createQueryBuilder('p')
            ->andWhere('p.projet = :val')
            ->setParameter('val', $id)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return HistoriqueDecaissement[] Returns an array of HistoriqueDecaissement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HistoriqueDecaissement
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
