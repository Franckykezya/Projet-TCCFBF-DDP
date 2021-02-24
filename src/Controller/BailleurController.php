<?php

namespace App\Controller;

use App\Entity\Bailleur;
use App\Form\BailleurType;
use App\Repository\BailleurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/bailleur")
 */
class BailleurController extends AbstractController
{
    /**
     * @Route("/", name="bailleur_index", methods={"GET"})
     */
    public function index(BailleurRepository $bailleurRepository): Response
    {
        return $this->render('bailleur/index.html.twig', [
            'bailleurs' => $bailleurRepository->findAll(),
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

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($bailleur);
            $entityManager->flush();

            return $this->redirectToRoute('bailleur_index');
        }

        return $this->render('bailleur/new.html.twig', [
            'bailleur' => $bailleur,
            'form' => $form->createView(),
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
     * @Route("/{id}/edit", name="bailleur_edit", methods={"GET","POST"})
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
     * @Route("/{id}", name="bailleur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Bailleur $bailleur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$bailleur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($bailleur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('bailleur_index');
    }
}
