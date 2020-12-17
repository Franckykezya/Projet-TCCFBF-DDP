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
        //dump($request);
        $val = 0;
        $d = 0;
        $test = 0;
        if($request->request->count() > 0){
            
            $element = new GrantElement1(($_POST['interest']/100),$_POST['payments'],$_POST['graceperiod'],$_POST['maturity'],$_POST['management'], $_POST['val_management']);
            $val = $element->calculElementDonSansCommission();
            $d = $element->Calendrier_de_paiement(1000000);
            $test = 1;
            dump($d);
            // return $this->redirectToRoute('grant_element');
       // dump($element);
        }
        
        return $this->render('grant_element/index.html.twig', [
            'controller_name' => $val,
            'test' => $test,
            'tabs' => $d
        ]);
    }
    /**
     * @Route("/Calendrier_de_paiement", name ="Calendrier_de_paiement")
     */
    // public function actualisation (){
    //     $element1 = new GrantElement1((1.5/100),2,5,25);
    //     $tabs = $element1->Calendrier_de_paiement(1000000);
    //     return $this->render('grant_element/Calendrier_de_paiement.html.twig',[
    //         'tabs' => $tabs
    //     ]);
    // }


}