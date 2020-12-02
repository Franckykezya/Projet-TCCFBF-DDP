<?php

namespace App\Repository;

use App\Entity\Bailleur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Bailleur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bailleur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bailleur[]    findAll()
 * @method Bailleur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BailleurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bailleur::class);
    }
    public function secteur($id){
        $req = "SELECT secteur_intervention.nom FROM bailleur
            INNER JOIN bailleur_secteur_intervention ON bailleur.id = bailleur_secteur_intervention.bailleur_id
            INNER JOIN secteur_intervention ON bailleur_secteur_intervention.secteur_intervention_id = secteur_intervention.id
            WHERE bailleur.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 
    
    public function financement($id){
        $req = "SELECT type_financement.nom FROM bailleur
            INNER JOIN bailleur_type_financement ON bailleur.id = bailleur_type_financement.bailleur_id
            INNER JOIN type_financement ON bailleur_type_financement.type_financement_id = type_financement.id
            WHERE bailleur.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 

    // /**
    //  * @return Bailleur[] Returns an array of Bailleur objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('b.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Bailleur
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
      * @return bailleur[] Returns an array of bailleur objects
    */
    public function findAllVisible(): array
    {
        return $this->findVisibleQuery()
            //->orderBy('b.nomBailleur', 'ASC')
            ->getQuery()
            ->getResult(); 
    }

}
