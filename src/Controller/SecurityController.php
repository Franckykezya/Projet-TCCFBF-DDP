<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="security_login")
     */
    public function security_login(): Response
    {

        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }
    /**
     * @Route("/logout", name = "logout")
     */
    public function security_logout()
    {

    }
}
