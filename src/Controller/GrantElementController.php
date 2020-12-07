<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GrantElementController extends AbstractController
{
    /**
     * @Route("/grantelementcalcul", name="grant_element")
     */
    public function index(): Response
    {
        return $this->render('grant_element/index.html.twig', [
            'controller_name' => 'GrantElementController',
        ]);
    }
}
