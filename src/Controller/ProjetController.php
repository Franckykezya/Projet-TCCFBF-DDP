<?php

namespace App\Controller;

use App\Entity\HistoriqueDecaissement;
use App\Form\HistoriqueDecaissementType;
use App\Repository\HistoriqueDecaissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Projet;
use App\Entity\BailleurRecherche;
use App\Entity\ProjetRecherche;
use App\Entity\TauxFixe;
use App\Entity\TauxVariable;
use App\Entity\SecteurIntervention;
use App\Form\ProjetRechercheType;
use App\Form\ProjetType;
use App\Form\TauxFixeType;
use App\Form\TauxVariableType;
use App\Form\SecteurInterventionType;
use App\Form\TypeFinancementType;
use App\Repository\ProjetRepository;
use App\Repository\BailleurRepository;
use App\Repository\SecteurInterventionRepository;
use App\Repository\TypeFinancementRepository;
use App\Repository\TauxInteretRepository;
use App\GrantElement1;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Constraints\Length;
use App\Form\BailleurRechercheType;


class ProjetController extends AbstractController
{
    /**
      * @var ProjetRepository
      */

    private $projetRepository;

    public function __construct(ProjetRepository $projetRepository)
    {
        $this->projetRepository = $projetRepository;
    }


    /**
     * @Route("/", name="blog")
     */
    public function index(): Response
    {
        if ($this->getUser() === null){
            return $this->redirectToRoute('security_login');
        }else
        {
            return $this->render('projet/index.html.twig', [
                'controller_name' => 'BlogController',
            ]);

        }
        
    }
    /**
     * @Route("/projet/ajout", name="create_bailleur")
     */
    public function ajout_projet(Request $request)
    {
        ////// Bailleur //////////
        //  if($bailleur == null){
        //      $bailleur = new Bailleur();
        //  }
        $projet = new Projet();
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        $tauxfixe = new TauxFixe();
        $formfixe = $this->createForm(TauxFixeType::class, $tauxfixe);
        $formfixe->handleRequest($request);

        // $tauxvariable = new TauxVariable();
        // $formVariable = $this->createForm(TauxVariableType::class, $tauxvariable);
        // $formVariable->handleRequest($request);

        
        if($form->isSubmitted() && $form->isValid())
         {
            dump("test enregistrer");
            $repo = $this->getDoctrine()->getManager();
            //ajout element don
            $somme_commission = $projet->getDifferentielInteret()+$projet->getFraisGestion()+$projet->getCommissionEngagement()+$projet->getCommissionService()+$projet->getCommissionInitiale()+$projet->getCommissionArrangement()+$projet->getCommissionAgent()+$projet->getMaturiteLettreCredit()+$projet->getFraisLiesLettreCredit()+$projet->getFraisLiesRefinancement();
           $element = new GrantElement1(0.01,2,$projet->getPeriodeGrace(),$projet->getMaturiteFacilite(),"In percent of outstanding loan",0,$somme_commission);
            //calcule decaissement

             $de_taux =  $projet->getDeMontantAccord()*100 /$projet->getMoMontant() ;
             $projet->setDeTaux($de_taux);

             $de_equivalent_usd =  ($projet->getMoEquivalentUsd() * $de_taux ) / 100;
             $projet->setDeEquivalentUsd($de_equivalent_usd);

             $de_reste_decaisser = $projet->getMoMontant() - $projet->getDeMontantAccord();
             $projet->setDeResteDecaisser($de_reste_decaisser);
             $de_reste_decaisser_usd = $projet->getMoEquivalentUsd() - $projet->getDeEquivalentUsd();
             $projet->setDeRestDecaisserUsd($de_reste_decaisser_usd);

            

            // $element = new GrantElement1($projet->getTauxFixe()->getValeurElementDon(), 2,$projet->getPeriodeGrace(),$projet->getMaturiteFacilite(),"In percent of outstanding loan",0,$somme_commission);
            $val = $element->calculeElementDonBailleur(100,0);
            
            $projet->setElementDon($val);

            $repo->persist($tauxfixe);
            // $repo->persist($tauxvariable);
            
            $repo->persist($projet);
            
            $repo->flush();
            return $this->redirectToRoute('liste_projet');
         }

        return $this->render("projet/createbailleur.html.twig",[
            'formBailleur' => $form->createView(),
            'formTauxFixe' => $formfixe->createView(),
            // 'formTauxVariable' => $formVariable->createView(),
        ]);
    }

    /**
     * @Route("/projet/liste", name = "liste_projet")
     */
    public function liste_projet(Request $request, PaginatorInterface $paginator, ProjetRepository $projetRepository) : Response
    {
        $recherche = new ProjetRecherche();
        $form = $this->createForm(ProjetRechercheType::class, $recherche);
        $form->handleRequest($request);

        $bailleur_recherche = $projetRepository->findAllVisibleQuery($recherche);
        $projets = $paginator->paginate($bailleur_recherche, $request->query->getInt('page', 1), 13);

        //$donnees = $this->getDoctrine()->getRepository(Projet::class)->findyBy();
        $pjt = $paginator->paginate($this->projetRepository->findAll(), $request->query->getInt('page', 1), 13  );
        
        //$bailleurs = $bailleurRepository->findAll();
        dump($projets);
        return $this->render("projet/listebailleur.html.twig",[
            'projets' => $projets,
            'projet' => $pjt,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/afficheprojet/{id}",name = "affiche_bailleur")
     */
    public function affiche_bailleur($id,ProjetRepository $projetRepository){
        $projet = $projetRepository->find($id);
        $bailleur = $projetRepository->bailleur($id);
        $secteurs = $projetRepository->secteur($id);
        $financements = $projetRepository->financement($id);
        $tauxinteretfixes = $projetRepository->tauxinteretfixe($id);
        $tauxinteretvariables = $projetRepository->tauxinteretvariable($id);
        //dump($tauxinteretvariable);

        return $this->render("projet/affichebailleur.html.twig",[
            'projet' => $projet,
            'bailleurs' => $bailleur,
            'secteurs' => $secteurs,
            'financements' => $financements,
            'tauxinteretfixes' => $tauxinteretfixes,
            'tauxinteretvariables' =>$tauxinteretvariables
        ]);


    }

    /**
     * @Route("/editerprojet/{id}", name="modifier_bailleur")
     */
    public function editer_projet(Request $request, Projet $projet, TauxFixe $tauxfixe)
    {
        $formProjet = $this->createForm(ProjetType::class, $projet);
        $formProjet->handleRequest($request);

        $formfixe = $this->createForm(TauxFixeType::class, $tauxfixe);
        $formfixe->handleRequest($request);

        // $formVariable = $this->createForm(TauxVariableType::class, $tauxvariable);
        // $formVariable->handleRequest($request);

        if ($formProjet->isSubmitted() && $formProjet->isValid()) {
            //calcule decaissement

            $de_taux =  $projet->getDeMontantAccord()*100 /$projet->getMoMontant() ;
            $projet->setDeTaux($de_taux);

            $de_equivalent_usd =  ($projet->getMoEquivalentUsd() * $de_taux ) / 100;
            $projet->setDeEquivalentUsd($de_equivalent_usd);

            $de_reste_decaisser = $projet->getMoMontant() - $projet->getDeMontantAccord();
            $projet->setDeResteDecaisser($de_reste_decaisser);
            $de_reste_decaisser_usd = $projet->getMoEquivalentUsd() - $projet->getDeEquivalentUsd();
            $projet->setDeRestDecaisserUsd($de_reste_decaisser_usd);

            //add historique decaissement projet

            /*
                if($projet->getDeMontantAccord() != $_POST['']){
                    $hi_decaiss = new HistoriqueDecaissement();
                    $hi_decaiss->setHiDate();
                    $hi_decaiss->setHiMontantAccord();
                    $hi_decaiss->setHiTaux();
                    $hi_decaiss->setHiResteDecaisser();
                    $hi_decaiss->setHiResteDecaisserUsd();

                }
                */





            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le groupe a bien été modifié');

            return $this->redirectToRoute('liste_projet');
        }
        return $this->render('projet/edit.html.twig',[
            'bailleur' => $projet,
            'tauxfixe' => $tauxfixe,
            // 'tauxvariable' => $tauxvariable,
            'formBailleur' => $formProjet->createView(),
            'formTauxFixe' => $formfixe->createView(),
            // 'formTauxVariable' => $formVariable->createView()
        ]);
    }
    //decaissement cummelé

    /**
     * @param Request $request
     * @param Projet $projet
     * @Route("nouveaudecaissement/{id}", name="nouveau_decaissement")
     */
    public function  decaissement(Request $request,  Projet $projet, HistoriqueDecaissementRepository $historiqueDecaissementRepository){
        $historiqueDecaissement = new HistoriqueDecaissement();
        $formhistorique = $this->createForm(HistoriqueDecaissementType::class,$historiqueDecaissement );
        $formhistorique->handleRequest($request);
        if($formhistorique->isSubmitted() && $formhistorique->isValid()){
            $em = $this->getDoctrine()->getManager();
            /**
             *  $de_taux =  $projet->getDeMontantAccord()*100 /$projet->getMoMontant() ;
            $projet->setDeTaux($de_taux);

            $de_equivalent_usd =  ($projet->getMoEquivalentUsd() * $de_taux ) / 100;
            $projet->setDeEquivalentUsd($de_equivalent_usd);

            $de_reste_decaisser = $projet->getMoMontant() - $projet->getDeMontantAccord();
            $projet->setDeResteDecaisser($de_reste_decaisser);
            $de_reste_decaisser_usd = $projet->getMoEquivalentUsd() - $projet->getDeEquivalentUsd();
            $projet->setDeRestDecaisserUsd($de_reste_decaisser_usd);
             */

            $historiqueDecaissement->setProjet($projet);

            $taux = $historiqueDecaissement->getHiMontantAccord()*100 / $projet->getMoMontant();
            $historiqueDecaissement->setHiTaux($taux);

            $equivUsd = ($projet->getMoEquivalentUsd()* $taux) / 100;
            $historiqueDecaissement->setHiEquivalentUsd($equivUsd);
            //mila manova le montant principale
            $rest = $projet->getDeResteDecaisser() - $historiqueDecaissement->getHiMontantAccord();
            $historiqueDecaissement->setHiResteDecaisser($rest);
            $restdecaisserusd = $projet->getDeRestDecaisserUsd() - $historiqueDecaissement->getHiResteDecaisserUsd();
            $historiqueDecaissement->setHiResteDecaisserUsd($restdecaisserusd);

            //manova le ani @ projet actualisena
            $Montantdecaisser = $projet->getDeMontantAccord() + $historiqueDecaissement->getHiMontantAccord();
            $projet->setDeMontantAccord($Montantdecaisser);
            $de_taux =  $projet->getDeMontantAccord()*100 /$projet->getMoMontant() ;
            $projet->setDeTaux($de_taux);

            $de_equivalent_usd =  ($projet->getMoEquivalentUsd() * $de_taux ) / 100;
            $projet->setDeEquivalentUsd($de_equivalent_usd);

            $de_reste_decaisser = $projet->getMoMontant() - $projet->getDeMontantAccord();
            $projet->setDeResteDecaisser($de_reste_decaisser);
            $de_reste_decaisser_usd = $projet->getMoEquivalentUsd() - $projet->getDeEquivalentUsd();
            $projet->setDeRestDecaisserUsd($de_reste_decaisser_usd);


            //bdb projet
            $em->persist($projet);

            //bdb historique
            $em->persist($historiqueDecaissement);
            $em->flush();

        }
        //liste des historiques
        $historiquetabs = $historiqueDecaissementRepository->findProjetId($projet->getId());
        //dump($historiquetab);

        return $this->render('decaissement/nouveaudecaissement.html.twig',[
            'historiquetabs' => $historiquetabs,
            'projetId' => $projet->getId(),
            'formhistorique' => $formhistorique->createView()
        ]
        );
    }
    /**
     * @Route("supprimerprojet/{id}", name="supprimer_bailleur", methods={"DELETE"})
     */
    public function delete(Request $request, Projet $projet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$projet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($projet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste_projet');
    }

    /**
     * @Route("/grantelement", name="grantelement")
     */
    public function elementdon(){
        //$R,$A,$INT,$M
        $element = new GrantElement1(0.015,2,5,25,"In percent of outstanding loan",0,0);
        $val = $element->calculeElementDon(1000000, 0,632562);
       // dump($element);
       
        return $this->render("projet/elementdon.html.twig",[
            'val' => $val
        ]);
    }

    /**
     * @Route("/projet/tableaucomparatif", name="tableau_comparatif")
     */
    //public function tableaucomparatif(BailleurRepository $bailleurrep, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep, TauxInteretRepository $tauxinteretrep) : Response
    public function tableaucomparatif(ProjetRepository $projetrep, BailleurRepository $bailleurRepository,  Request $request, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep) : Response
    {   
        $projets = $projetrep->findAll();
        $secteur = $secteurInterventionrep->findAll();
        $typefinancement = $typefinancementrep->findAll();
        //$tauxinteret = $tauxinteretrep->findAll();
        $makarehetra = $projetrep->makarehetra();
        dump($makarehetra);

        
        $recherche = new BailleurRecherche();
        $form = $this->createForm(BailleurRechercheType::class, $recherche);
        $form->handleRequest($request);


        // $bailleur_recherche = $bailleurRepository->findAllVisibleQuery($recherche);

        return $this->render("projet/tableau_comparatif.html.twig",[
            'bailleurs' => $projets,
            'secteur' => $secteur,
            'typefinancement' => $typefinancement,
            
            // 'bailleurs_recherche' => $bailleur_recherche,
            // 'form' => $form->createView()
            
            //'tauxinteret' => $tauxinteret,
        ]);
    }
     //----------------------------------------excel-----------------------------------//

    /**
     * @Route("/projet/tableaucomparatif_Excel", name="tableaucomparatif_Excel", methods={"GET"})
     */
    public function tableaucomparatif_Excel() : Response
    {   

        return $this->render("projet/tableau_comparatif_excel.html.twig");
    }

    //--------------------------------------Test anle tableau comparatif fotsiny io---------------------------//

    /**
     * @Route("/testtableau", name="testtableau", methods={"GET"})
     */
    public function testtableau(ProjetRepository $projetrep, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep) : Response
    {   
        $projets = $projetrep->findAll();
        $secteur = $secteurInterventionrep->findAll();
        $typefinancement = $typefinancementrep->findAll();
        //$tauxinteret = $tauxinteretrep->findAll();


        return $this->render("projet/testtableau.html.twig",[
            'bailleurs' => $projets,
            'secteur' => $secteur,
            'typefinancement' => $typefinancement,
            //'tauxinteret' => $tauxinteret,
        ]);
    }

    
      //----------------------------------------excel-----------------------------------//

    /**
     * @Route("/projet/tableaucomparatif_Exel", name="")
     */
    //public function tableaucomparatif(BailleurRepository $bailleurrep, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep, TauxInteretRepository $tauxinteretrep) : Response
    public function tbl_comp_excel(ProjetRepository $projetrep, BailleurRepository $bailleurRepository,  Request $request, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep) : Response
    {   
        $projets = $projetrep->findAll();
        $secteur = $secteurInterventionrep->findAll();
        $typefinancement = $typefinancementrep->findAll();
        //$tauxinteret = $tauxinteretrep->findAll();
        $makarehetra = $projetrep->makarehetra();
        dump($makarehetra);

        
        $recherche = new BailleurRecherche();
        $form = $this->createForm(BailleurRechercheType::class, $recherche);
        $form->handleRequest($request);


        // $bailleur_recherche = $bailleurRepository->findAllVisibleQuery($recherche);

        return $this->render("projet/tbl_comp_excel.html.twig",[
            'bailleurs' => $projets,
            'secteur' => $secteur,
            'typefinancement' => $typefinancement,
            
            // 'bailleurs_recherche' => $bailleur_recherche,
            // 'form' => $form->createView()
            
            //'tauxinteret' => $tauxinteret,
        ]);
    }
}
