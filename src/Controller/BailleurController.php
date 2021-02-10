<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bailleur;
use App\Entity\TauxFixe;
use App\Entity\TauxVariable;
use App\Entity\SecteurIntervention;
use App\Form\BailleurType;
use App\Form\TauxFixeType;
use App\Form\TauxVariableType;
use App\Form\SecteurInterventionType;
use App\Form\TypeFinancementType;
use App\Repository\BailleurRepository;
use App\Repository\SecteurInterventionRepository;
use App\Repository\TypeFinancementRepository;
use App\Repository\TauxInteretRepository;
use App\GrantElement1;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Validator\Constraints\Length;

class BailleurController extends AbstractController
{
    /**
      * @var BailleurRepository
      */

    private $bailleurRepository;

    public function __construct(BailleurRepository $bailleurRepository)
    {
        $this->bailleurRepository = $bailleurRepository;
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
            return $this->render('bailleur/index.html.twig', [
                'controller_name' => 'BlogController',
            ]);

        }
        
    }
    /**
     * @Route("/bailleur/ajout", name="create_bailleur")
     */
    public function ajout_bailleur(Request $request)
    {
        ////// Bailleur //////////
        //  if($bailleur == null){
        //      $bailleur = new Bailleur();
        //  }
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        $tauxfixe = new TauxFixe();
        $formfixe = $this->createForm(TauxFixeType::class, $tauxfixe);
        $formfixe->handleRequest($request);

        $tauxvariable = new TauxVariable();
        $formVariable = $this->createForm(TauxVariableType::class, $tauxvariable);
        $formVariable->handleRequest($request);

       
        if($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getManager();
            //ajout element don
            $somme_commission = $bailleur->getDifferentielInteret()+$bailleur->getFraisGestion()+$bailleur->getCommissionEngagement()+$bailleur->getCommissionService()+$bailleur->getCommissionInitiale()+$bailleur->getCommissionArrangement()+$bailleur->getCommissionAgent()+$bailleur->getMaturiteLettreCredit()+$bailleur->getFraisLiesLettreCredit()+$bailleur->getFraisLiesRefinancement();
            $element = new GrantElement1(0.015,2,$bailleur->getPeriodeGrace(),$bailleur->getMaturiteFacilite(),"In percent of outstanding loan",0,$somme_commission);
            $val = $element->calculeElementDonBailleur(100,0);
            dump($val);
            $bailleur->setElementDon($val);

            $repo->persist($bailleur);
            $repo->persist($tauxfixe);
            $repo->persist($tauxvariable);
            $repo->flush();
            return $this->redirectToRoute('liste_bailleur');
            }

        return $this->render("bailleur/createbailleur.html.twig",[
            'formBailleur' => $form->createView(),
            'formTauxFixe' => $formfixe->createView(),
            'formTauxVariable' => $formVariable->createView(),
        ]);
    }

    /**
     * @Route("/bailleur/liste", name = "liste_bailleur")
     */
    public function liste_bailleur(Request $request, PaginatorInterface $paginator, BailleurRepository $bailleurRepository) : Response
    {
        //$donnees = $this->getDoctrine()->getRepository(Bailleur::class)->findyBy();
        $bailleurs = $paginator->paginate($this->bailleurRepository->findAll(), $request->query->getInt('page', 1), 12);
        
        //$bailleurs = $bailleurRepository->findAll();
        //dump($bailleurs);
        return $this->render("bailleur/listebailleur.html.twig",[
            'bailleurs' => $bailleurs
        ]);
    }

    /**
     * @Route("/afficheBAILLEUR/{id}",name = "affiche_bailleur")
     */
    public function affiche_bailleur($id,BailleurRepository $bailleurRepository){
        $bailleur = $bailleurRepository->find($id);
        $secteurs = $bailleurRepository->secteur($id);
        $financements = $bailleurRepository->financement($id);
        $tauxinteretfixe = $bailleurRepository->tauxinteretfixe($id);

        return $this->render("bailleur/affichebailleur.html.twig",[
            'bailleur' => $bailleur,
            'secteurs' => $secteurs,
            'financements' => $financements,
            'tauxinteretfixe' => $tauxinteretfixe
        ]);


    }

    /**
     * @Route("/editerBAILLEUR/{id}", name="modifier_bailleur")
     */
    public function editer_bailleur(Request $request, Bailleur $bailleur, TauxFixe $tauxfixe)
    {
        $formBailleur = $this->createForm(BailleurType::class, $bailleur);
        $formBailleur->handleRequest($request);

        $formfixe = $this->createForm(TauxFixeType::class, $tauxfixe);
        $formfixe->handleRequest($request);

        // $formVariable = $this->createForm(TauxVariableType::class, $tauxvariable);
        // $formVariable->handleRequest($request);

        if ($formBailleur->isSubmitted() && $formBailleur->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Le groupe a bien été modifié');

            return $this->redirectToRoute('liste_bailleur');
        }
        return $this->render('bailleur/edit.html.twig',[
            'bailleur' => $bailleur,
            'tauxfixe' => $tauxfixe,
            // 'tauxvariable' => $tauxvariable,
            'formBailleur' => $formBailleur->createView(),
            'formTauxFixe' => $formfixe->createView(),
            // 'formTauxVariable' => $formVariable->createView()
        ]);
    }
    /**
     * @Route("supprimerBAILLEUR/{id}", name="supprimer_bailleur", methods={"DELETE"})
     */
    public function delete(Request $request, Bailleur $bailleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bailleur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bailleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('liste_bailleur');
    }

    /**
     * @Route("/grantelement", name="grantelement")
     */
    public function elementdon(){
        //$R,$A,$INT,$M
        $element = new GrantElement1(0.015,2,5,25,"In percent of outstanding loan",0,0);
        $val = $element->calculeElementDon(1000000, 0,632562);
       // dump($element);
       
        return $this->render("bailleur/elementdon.html.twig",[
            'val' => $val
        ]);
    }

      /**
     * @Route("/bailleur/tableaucomparatif", name="tableau_comparatif")
     */
    //public function tableaucomparatif(BailleurRepository $bailleurrep, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep, TauxInteretRepository $tauxinteretrep) : Response
    public function tableaucomparatif(BailleurRepository $bailleurrep, SecteurInterventionRepository $secteurInterventionrep, TypeFinancementRepository $typefinancementrep) : Response
    {   
        $bailleurs = $bailleurrep->findAll();
        $secteur = $secteurInterventionrep->findAll();
        $typefinancement = $typefinancementrep->findAll();
        //$tauxinteret = $tauxinteretrep->findAll();


        return $this->render("bailleur/tableau_comparatif.html.twig",[
            'bailleurs' => $bailleurs,
            'secteur' => $secteur,
            'typefinancement' => $typefinancement,
            //'tauxinteret' => $tauxinteret,
        ]);
    }
}
