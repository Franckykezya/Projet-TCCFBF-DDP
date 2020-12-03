<?php

namespace App\Controller;

use App\Entity\TypeFinancement;
use App\Form\TypeFinancementType;
use App\Repository\TypeFinancementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/financement")
 */
class TypeFinancementController extends AbstractController
{
    /**
     * @Route("/", name="type_financement_index", methods={"GET","POST"})
     * @Route("/ajout", name="type_financement_new", methods={"GET","POST"})
     */
    public function index(Request $request, TypeFinancementRepository $typeFinancementRepository): Response
    {

        $typeFinancement = new TypeFinancement();
        $form = $this->createForm(TypeFinancementType::class, $typeFinancement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeFinancement);
            $entityManager->flush();

            return $this->redirectToRoute('type_financement_index');
        }

        return $this->render('type_financement/index.html.twig', [
            'type_financements' => $typeFinancementRepository->findAll(),
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ajout", name="type_financement_new", methods={"GET","POST"})
     */
    public function ajout(Request $request): Response
    {
        $typeFinancement = new TypeFinancement();
        $form = $this->createForm(TypeFinancementType::class, $typeFinancement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($typeFinancement);
            $entityManager->flush();

            return $this->redirectToRoute('type_financement_index');
        }

        return $this->render('type_financement/new.html.twig', [
            'type_financement' => $typeFinancement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_financement_show", methods={"GET"})
     */
    public function show(TypeFinancement $typeFinancement): Response
    {
        return $this->render('type_financement/show.html.twig', [
            'type_financement' => $typeFinancement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="type_financement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, TypeFinancement $typeFinancement): Response
    {
        $form = $this->createForm(TypeFinancementType::class, $typeFinancement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_financement_index');
        }

        return $this->render('type_financement/edit.html.twig', [
            'type_financement' => $typeFinancement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_financement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, TypeFinancement $typeFinancement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeFinancement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($typeFinancement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('type_financement_index');
    }
}
