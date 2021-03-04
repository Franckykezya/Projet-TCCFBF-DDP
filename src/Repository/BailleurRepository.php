<?php

namespace App\Repository;

use App\Entity\Bailleur;
use App\Entity\BailleurRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Migrations\Query\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
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
    public function projetbailleur($id){
        $req = "SELECT bailleur.nom FROM projet
            INNER JOIN projet_bailleur ON projet.id = projet_bailleur.projet_id
            INNER JOIN bailleur ON projet_bailleur.bailleur_id = bailleur.id
            WHERE projet.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 

    /**
     * @return Bailleur[]
     */
    public function findAllVisibleQuery(BailleurRecherche $recherche): Array
    {   
        if ($recherche->getNomBailleur())
        {//mitady par nom bailleur
                return $this->findVisibleQuery()
                ->where('b.nom LIKE :nombailleur' )
                ->setParameter('nombailleur',  '%' .$recherche->getNomBailleur(). '%')
                ->getQuery()
                ->getResult(); 
        }

        else
        {
            return $this->findVisibleQuery()
                        ->getQuery()
                        ->getResult();
        }
    }

    public function findAllQuery(): array
    {
        return $this->findVisibleQuery()
                    ->getQuery()
                    ->getResult();
    }

   
    private function findVisibleQuery(): ORMQueryBuilder
    {
        return $this->createQueryBuilder('b');
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
}
