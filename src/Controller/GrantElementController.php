<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\GrantElement1;

class GrantElementController extends AbstractController
{
    /**
     * @Route("/grantelementcalcul", name="grant_element")
     */
    public function index(Request $request): Response
    {
        dump($request);
        $val = 0;
        if($request->request->count() > 0){
            
            $element = new GrantElement1(($_POST['interest']/100),$_POST['payments'],$_POST['graceperiod'],$_POST['maturity']);
            $val = $element->calculElementDonSansCommission();
            // return $this->redirectToRoute('grant_element');
       // dump($element);
        }
        return $this->render('grant_element/index.html.twig', [
            'controller_name' => $val,
        ]);
    }
}
