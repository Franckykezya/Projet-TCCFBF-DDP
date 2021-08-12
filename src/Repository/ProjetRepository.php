<?php

namespace App\Repository;

use App\Entity\Projet;
use App\Entity\ProjetRecherche;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Migrations\Query\Query;
use Doctrine\ORM\Query as ORMQuery;
use Doctrine\ORM\QueryBuilder as ORMQueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Projet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Projet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Projet[]    findAll()
 * @method Projet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjetRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Projet::class);
    }

    public function secteur($id){
        $req = "SELECT secteur_intervention.nom FROM projet
            INNER JOIN projet_secteur_intervention ON projet.id = projet_secteur_intervention.projet_id
            INNER JOIN secteur_intervention ON projet_secteur_intervention.secteur_intervention_id = secteur_intervention.id
            WHERE projet.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 
    
    public function financement($id){
        $req = "SELECT type_financement.nom FROM projet
            INNER JOIN projet_type_financement ON projet.id = projet_type_financement.projet_id
            INNER JOIN type_financement ON projet_type_financement.type_financement_id = type_financement.id
            WHERE projet.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 

    public function bailleur($id){
        $req = "SELECT bailleur.nom FROM projet
            INNER JOIN projet_bailleur ON projet.id = projet_bailleur.projet_id
            INNER JOIN bailleur ON projet_bailleur.bailleur_id = bailleur.id
            WHERE projet.id = $id
        ";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();

    } 

    public function tauxinteretfixe($id){
       $req = "SELECT taux_fixe.base,taux_fixe.valeur,taux_fixe.valeur_element_don FROM projet
                INNER JOIN taux_fixe ON projet.id = taux_fixe.id
                WHERE projet.id = $id";
        $a = $this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();
       
       
    } 
    public function tauxinteretvariable($id){
        $req = "SELECT taux_variable.base,taux_variable.valeur,taux_variable.marge,taux_variable.total,taux_variable.valeur_element_don,taux_variable.valeur_calcul_element_don FROM projet
                 INNER JOIN taux_variable ON projet.id = taux_variable.id
                 WHERE projet.id = $id";
         $a = $this->getEntityManager()->getConnection()->prepare($req);
         $a->execute([]);
         return $a->fetchAll();
        
        
     } 

    public function makarehetra (){
        $req = "SELECT * FROM projet";
        $a=$this->getEntityManager()->getConnection()->prepare($req);
        $a->execute([]);
        return $a->fetchAll();
    }

    /**
     * @return Projet[]
     */
    public function findAllVisibleQuery(ProjetRecherche $recherche): Array
    {   
        if ($recherche->getNomProjet())
        {//mitady par nom bailleur
                return $this->findVisibleQuery()
                ->where('b.nom LIKE :nomprojet' )
                ->setParameter('nomprojet', '%' .$recherche->getNomProjet(). '%')
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
