<?php

namespace App\Controller;

use App\Entity\Bailleur;
use App\Entity\BailleurRecherche;
use App\Form\BailleurType;
use App\Repository\BailleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\BailleurRechercheType;
/**
 * @Route("/bailleur")
 */
class BailleurController extends AbstractController
{
    /**
     * @Route("/", name="bailleur_index", methods={"GET"})
     */
    public function index(BailleurRepository $bailleurRepository, Request $request): Response
    {

        $recherche = new BailleurRecherche();
        $form = $this->createForm(BailleurRechercheType::class, $recherche);
        $form->handleRequest($request);

        $bailleur_recherche = $bailleurRepository->findAllVisibleQuery($recherche);

        return $this->render('bailleur/index.html.twig', [
            
            'bailleurs' => $bailleur_recherche,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/new", name="bailleur_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $bailleur = new Bailleur();
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        // $formNew = $this->createForm(BailleurType::class, $bailleur);
        // $formNew->handleRequest($request);

        // if ($formNew->isSubmitted() && $formNew->isValid()) {
        //     return $this->redirectToRoute('bailleur_new');
        // }

        if ($form->isSubmitted() && $form->isValid()) {
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bailleur);
            $entityManager->flush();

            return $this->redirectToRoute('bailleur_index');
        }

        return $this->render('bailleur/new.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form->createView(),
            // 'formNew' => $formNew->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="bailleur_show", methods={"GET"})
     */
    public function show(Bailleur $bailleur): Response
    {
        return $this->render('bailleur/show.html.twig', [
            'bailleur' => $bailleur,
        ]);
    }

    /**
     * @Route("_edit/{id}", name="bailleur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Bailleur $bailleur): Response
    {
        $form = $this->createForm(BailleurType::class, $bailleur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('bailleur_index');
        }

        return $this->render('bailleur/edit.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/secteur/delete/{id}", name="bailleur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bailleur $bailleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$$bailleur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bailleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('secteur_liste');
    }





}








