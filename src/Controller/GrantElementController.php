<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\GrantElement1;
use App\Repository\BailleurRepository;
use App\Repository\ProjetRepository;

class GrantElementController extends AbstractController
{
    /**
     * @Route("/grantelementcalcul", name="grant_element")
     */
    public function index(Request $request,ProjetRepository $projetRepository): Response
    {
        //dump($request);
        $val  = 0; $vallumpsum = 0;
        $d = 0; $dlumpsum = 0;$valiny = 0;
        $test = 0;
        if($request->request->count() > 0){
            
           // $element = new GrantElement1(($_POST['interest']/100),$_POST['payments'],$_POST['graceperiod'],$_POST['maturity'],$_POST['management'], $_POST['val_management'],$_POST['commission']);
           $element = new GrantElement1(0.77,2,4,14,0,0,16.43);
            //$val = $element->calculElementDonSansCommission();
            $val = $element->calculeElementDon($_POST['face'],0);
            $d = $element->Calendrier_de_paiement($_POST['face']);
            $test = 1;

            $vallumpsum = $element->calculeElementDon_lump_sum($_POST['face'],0);
            $dlumpsum = $element->Calendrier_de_paiement_lump_sum($_POST['face']);

            $valiny = $element->calculeInterestrate($_POST['face']);
            
            dump($valiny);
            // return $this->redirectToRoute('grant_element');
       // dump($element);
        }
        //maka bailleur
        $projets = $projetRepository->findAll();
       // dump($projets);
        return $this->render('grant_element/index.html.twig', [
            'controller_name' => $val,
            'Eir' => $valiny,
            'test' => $test,
            'tabs' => $d,
            'vallumpsum' => $vallumpsum,
            'dlumpsum' => $dlumpsum,
            'projets' => $projets
        ]);
    }
     
    /**
     * @Route("/selectoption/{id}", name ="selectoption")
     */
    public function selectoption($id, ProjetRepository $projetRepository,BailleurRepository $bailleurRepository){
        $projet = $projetRepository->find($id);
        $bailleur = $bailleurRepository->projetbailleur($id);
            
        //$data = array();
        $data = array($projet->getMaturiteFacilite());
        array_push($data, $projet->getPeriodeGrace());
        $ba = array();
        dump($bailleur);
        // foreach ($bailleur as  $value) {
            
        //     $ba = array_push($ba, $value);
        // }
        
         return $this->json([
             'code' => 200,
             'projet' => $data,
             //'bailleur' => $ba

         ],200);
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
    /**
     * @Route("/van", name ="van")
     */  
    public function van()
    {  
        $tauxactualisation = 0.026;
        $CF = array(7500,7500,7500,7500,7500,7500,7500,7500,7500,7500,32500,32313,32125,31938,31750,31563,31375,31188,31000,30813,30625,30438,30250,30063,29875,29688,29500,29313,29125,28938,28750,28563,28375,28188,28000,27813,27625,27438,27250,27063,26875,26688,26500,26313,26125,25938,25750,25563,25375,25188); 
        $v = 0 ;
        for($i = 0; $i < 50 ; $i++){
            $fva =  pow(1 + $tauxactualisation, $i);
            $v += $CF[$i] / $fva;
        }
        return $this->render('grant_element/testvan.html.twig',[
                    'v' => round($v)
        ]);
        
    }
    /**
     * @Route("/tri", name = "tri")
     */
    public function tri(){
//         $element = new GrantElement1(0.77,2,4,14,0,0,16.43);
       
//         dump($valiny);
//         return $this->render('grant_element/testvan.html.twig',[
//             'v' => round($valiny,3)
// ]);
    }

}