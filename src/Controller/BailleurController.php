<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Bailleur;
use App\Entity\SecteurIntervention;
use App\Form\BailleurType;
use App\Form\SecteurInterventionType;
use App\Form\TypeFinancementType;
use App\Repository\BailleurRepository;
use App\GrantElement1;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Knp\Component\Pager\Event\PaginationEvent;
use Knp\Component\Pager\PaginatorInterface;


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
        //  if($bailleur == null){
        //      $bailleur = new Bailleur();
        //  }
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $repo = $this->getDoctrine()->getManager();
             //ajout element don
            $element = new GrantElement1(0.015,2,$bailleur->getPeriodeGrace(),$bailleur->getMaturiteFacilite());
            $val = $element->calculElementDonSansCommission();
            dump($val);
            $bailleur->setElementDon($val);
            $repo->persist($bailleur);
            $repo->flush();
            return $this->redirectToRoute('liste_bailleur');
        }
        return $this->render("bailleur/createbailleur.html.twig",[
            'formBailleur' => $form->createView(),

        ]);
    }

    /**
     * @Route("/bailleur/liste", name = "liste_bailleur")
     */
    public function liste_bailleur(Request $request, PaginatorInterface $paginator, BailleurRepository $bailleurRepository) : Response
    {
        //$donnees = $this->getDoctrine()->getRepository(Bailleur::class)->findyBy();
        $bailleurs = $paginator->paginate($this->bailleurRepository->findAll(), $request->query->getInt('page', 1), 6);
        
        //$bailleurs = $bailleurRepository->findAll();
        //dump($bailleurs);
        return $this->render("bailleur/listebailleur.html.twig",[
            'bailleurs' => $bailleurs
        ]);
    }

    /**
     * @Route("/bailleur/affiche/{id}",name = "affiche_bailleur")
     */
    public function affiche_bailleur($id,BailleurRepository $bailleurRepository){
        $bailleur = $bailleurRepository->find($id);
        $secteurs = $bailleurRepository->secteur($id);
        $financements = $bailleurRepository->financement($id);
        //dump($financements);

        return $this->render("bailleur/affichebailleur.html.twig",[
            'bailleur' => $bailleur,
            'secteurs' => $secteurs,
            'financements' => $financements
        ]);


    }

    /**
     * @Route("/bailleur/editer/{id}", name="modifier_bailleur")
     */
    public function editer_bailleur(Request $request, Bailleur $bailleur)
    {
        $formBailleur = $this->createForm(BailleurType::class, $bailleur );
        $formBailleur->handleRequest($request);

        if ($formBailleur->isSubmitted() && $formBailleur->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('liste_bailleur');
        }
        return $this->render('bailleur/edit.html.twig',[
            'bailleur' => $bailleur,
            'formBailleur' => $formBailleur->createView()
        ]);
    }
    /**
     * @Route("/{id}", name="supprimer_bailleur", methods={"DELETE"})
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
        //$M, $G, $A, $R, $payementProfile
        $element = new GrantElement1(0.015,2,5,25);
        $val = $element->calculElementDonSansCommission();
       // dump($element);

        return $this->render("bailleur/elementdon.html.twig",[
            'val' => $val
        ]);
    }
}
