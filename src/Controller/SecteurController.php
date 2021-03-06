<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\SecteurIntervention;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SecteurInterventionType;
use App\Repository\SecteurInterventionRepository;
use Symfony\Component\HttpFoundation\Response;

class SecteurController extends AbstractController
{
    /**
     * @Route("/secteur/ajout", name="create_secteur_intervention")
     */
    public function ajout_secteur_intervention(Request $request)
    {
        $secteurIntervention = new SecteurIntervention;
        $form = $this->createForm(SecteurInterventionType::class, $secteurIntervention);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($secteurIntervention);
            $em->flush();
            return $this->redirectToRoute('secteur_liste');
        }
        return $this->render("secteur/createsecteurintervention.html.twig",[
            'formSecteurIntervention' => $form->createView()
        ]);
    }
    /**
     * @Route("/secteur/liste", name ="secteur_liste")
     */
    public function liste_secteur_intervention(SecteurInterventionRepository $secteur_repo, Request $request): Response
    {

        //Creation secteur intervention
        $secteurIntervention = new SecteurIntervention;
        $form = $this->createForm(SecteurInterventionType::class, $secteurIntervention);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($secteurIntervention);
            $em->flush();
            return $this->redirectToRoute('secteur_liste');
        }

        $secteurs = $secteur_repo->findAll();
        return $this->render("secteur/liste_secteur_intervention.html.twig", [
            "secteurs" => $secteurs,
            'formSecteurIntervention' => $form->createView(),
        ]);
    }
    /**
     * @Route("/secteur_editer/{id}", name = "secteur_editer", methods={"GET","POST"})
     */
    public function affiche_secteur_intervention(SecteurIntervention $secteur, Request $request)
    {


        $form = $this->createForm(SecteurInterventionType::class, $secteur);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('secteur_liste');
        }
        
        return $this->render("secteur/edit_secteur_intervention.html.twig",[
            "secteurs" => $secteur,
            "form" => $form->createView(),
            
        ]);
    }

    /**
     * @Route("/secteur/delete/{id}", name="secteur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SecteurIntervention $secteur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$secteur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($secteur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secteur_liste');
    }
}