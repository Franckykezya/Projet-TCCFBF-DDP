<?php
namespace App;
use IRRCalculator;
use Symfony\Component\Validator\Constraints\Length;
// use App\Iir;
// use IRRCalculator;


class GrantElement1
{
    private $R,$A,$INT,$M,$I = 0.026,$D,$management,$val_management;
    private $don, $commission,$pay;
    

    public function __construct($R,$A,$INT,$M,$management,$val_management,$commission)
    {
        $this->R = $R;
        $this->A = $A;
        $this->INT = $INT;
        $this->M = $M;
        $this->management = $management;
        $this->val_management = $val_management;
        $this->commission = $commission;

        $this->D = (pow((1+$this->I),(1/$this->A))-1);

    }
    
     //(1-((1+$C$11)^(1/$C$13)-1)/C27)*
     //(1-( (1/((1+C27)^(C13*C14))) - (1/((1+C27)^(C13*C12))) )/(C27*(C13*C12-C13*C14)))
    
    public function calculElementDonSansCommission(){

        // $p1 = (1 - ( pow ( ( 1+$this->R ) , ( 1/$this->A ) ) -1 ) ) / $this->I; 
        // $p2 = (1/(pow((1+$this->I),($this->A*$this->INT))));
        // $p3 = (1/(pow((1+$this->I),($this->A*$this->M))));
        // $p4 = ($this->I*(($this->A*$this->M)-($this->A*$this->INT)));

        // $Gel = $p1 * ((1 -($p2 - $p3))/$p4);

        $Gel = ((1-(pow((1+$this->R),(1/$this->A))-1))/$this->I) * (1 - ((1/(pow((1+$this->I),($this->A*$this->INT)))) - 
        (1/(pow((1+$this->I),($this->A*$this->M))))) /($this->I*(($this->A*$this->M)-($this->A*$this->INT))));
    
        return round($Gel,1);
    }
    //equal pp
    public function Calendrier_de_paiement($capital)
    {
        $N = ($this->M*$this->A);
        $outstanding[-1] = $capital;
        $j = 1;
        for ($i = 0 ; $i < $N ; $i++)
        {    
            $indice_annee[$i] = $N-$i ; 
           // $interest_rate [$i]= ($this->R / $this->A) * 100;
            $interest_rate [$i] = ((pow((1+$this->R),(1/$this->A))-1)*100);
            $pricipal[$i] = 0;
            if( $i < $this->INT*$this->A)
            {
                $pricipal[$i] = 0 ;
            }else{
                $pricipal[$i] = $capital / (($this->M - $this->INT) * $this->A);
            }
            $payment[$i] = 0;
            $free[$i] = 0;
            $interest[$i] = 0;
           
            $outstanding[$i] = $outstanding[$i-1] - $pricipal[$i];
            //$outstanding[$i] = 1000000 - $pricipal[$i];

        }

        //interest
         $interest = $this->CalculInteret($interest_rate, $indice_annee, $outstanding,$N);
        //fees
        $free = $this->CalculFees($indice_annee, $outstanding,$N,$this->management,$this->val_management,$this->A);
        //Payments per period
        $payment = $this->CalculPaymentPeriod($pricipal, $interest, $free, $N);
        $this->pay = $this->CalculPaymentPeriod($pricipal, $interest, $free, $N);

        //calcule IIR

        //$pay = $this->CalculPaymentPeriod($pricipal, $interest, $free, $N);
        //$ex = new IRRCalculator();
        //$pay = array( 42623250.0,-221350.0,-196350.0,-221350.0,-196350.0,-221350.0,-196350.0,-221350.0,-196350.0,-2771350.0,-2736532.5,-2751715.0,-2716897.5,-2732080.0,-2697262.5,-2712445.0,-2677627.5,-2692810.0,-2657992.5,-2673175.0,-2638357.5,-2653540.0,-2618722.5,-2633905.0,-2599087.5,-2614270.0,-2579452.5,-2594635.0,-2559817.5);
        // array_splice($pay,0, 0, $capital);
        // dump($pay);
        //$exiir = $ex->calculateFromCashFlow($pay);
        //$iir = IRRCalculator::calculateFromCashFlow($payment,100000);
        //dump($exiir * 100);
        //(1 + TRI(N25:N225/1000000) ) ^ 2-1
        //$tri = (1+pow(($exiir*100),2)) - 1;
        //dump(round($tri,2));
        
        //calcul VAN
        $van = 0;
        for($i = 0; $i < $N ; $i++){
            $fva = 1 / pow(1 + $this->I, $i);
            $van += $payment[$i] * $fva;
        }
        $this->don = $van+($capital * $this->commission/100);
        

        $c30 = $capital * $this->commission/100;
        //dump($this->don);

        //dump($c30);
        $tab = array ($indice_annee, $interest_rate,$payment,$free,$interest,$pricipal,$outstanding);
        //return $van;
        return $tab;
    }
    //lump-sum
    public function Calendrier_de_paiement_lump_sum($capital)
    {
        $N = ($this->M*$this->A);
        $outstanding[-1] = $capital;
        $j = 1;
        for ($i = 0 ; $i < $N; $i++)
        {    
            $indice_annee[$i] = $N-$i ;
            
            $interest_rate [$i] = (pow((1+$this->R),(1/$this->A))-1)*100;
            $pricipal[$i] = 0;
            // if( $i < $this->INT*$this->A)
            // {
            //     $pricipal[$i] = 0 ;
            // }else{
            //     $pricipal[$i] = $capital / (($this->M - $this->INT) * $this->A);
            // }
            //if($indice_annee[$i] > 0){
            if($indice_annee[$i] > 0){                                  
                if($indice_annee[$i] > ($indice_annee[$i]-($indice_annee[$i]-1))){
                    $pricipal[$i] = 0;
                }else{
                    $pricipal[$i] = $capital;
                   // dump($indice_annee[$i]); 
                }
            }
            //dump($principal[$i]);
            // $payment[$i] = 0;
            // $free[$i] = 0;
            // $interest[$i] = 0;
           
            $outstanding[$i] =round( $outstanding[$i-1] - $pricipal[$i],5);
            //dump()
            //$outstanding[$i] = 1000000 - $pricipal[$i];

        }
        $payment[$i] = 0;
        $free[$i] = 0;
        $interest[$i] = 0;
        //interest
         $interest = $this->CalculInteret($interest_rate, $indice_annee, $outstanding,$N);
        //fees
        $free = $this->CalculFees($indice_annee, $outstanding,$N,$this->management,$this->val_management,$this->A);
        //Payments per period
        $payment = $this->CalculPaymentPeriod($pricipal, $interest, $free, $N);

        //calcul VAN
        $van = 0;
        for($i = 0; $i < $N ; $i++){
            $fva = 1 / pow(1 + $this->I, $i);
            $van += $payment[$i] * $fva;
        }
        $this->don = $van+($capital * $this->commission/100);
        $c30 = $capital * $this->commission/100;
        //dump($this->don);
        //dump($c30);
        $tab = array ($indice_annee, $interest_rate,$payment,$free,$interest,$pricipal,$outstanding);
        //return $van;
        return $tab;
    }

    /**
     * $Gelment = ((c6+c7-c32)/(c6+c7));
     * c6 = face value (vola indramina)
     * c7 = Grant(as part of financing package, in curency units)
     * c32 = van(c27;H26:H225)+c30
     * c27 = discount rate per period
     */
    public function calculeElementDon($faceValue, $grant){
       //$GrantElement  =  (($faceValue + $grant - 632562) / ($faceValue + $grant));
       $this->Calendrier_de_paiement($faceValue,$this->commission);

      // $van = $this->don;
       $GrantElement  =  (($faceValue + $grant - $this->don) / ($faceValue + $grant));
      // $GrantElement  =  (($faceValue + $grant - 1396168) / ($faceValue + $grant));

      // dump($this->don);
       return $GrantElement*100;    
    }
    //calcul element-don lump-sum
    public function calculeElementDon_lump_sum($faceValue, $grant){
        //$GrantElement  =  (($faceValue + $grant - 632562) / ($faceValue + $grant));
        $this->Calendrier_de_paiement_lump_sum($faceValue,$this->commission);
       // $van = $this->don;
        $GrantElement  =  (($faceValue + $grant - $this->don) / ($faceValue + $grant));
       // $GrantElement  =  (($faceValue + $grant - 1396168) / ($faceValue + $grant));
 
       // dump($this->don);
        return $GrantElement*100;    
     }

     /**calcule Efective interest rat**/

     public function calculeInterestrate($faceValue){
        $ex = new IRRCalculator();
        $this->Calendrier_de_paiement($faceValue);
        $tab = $this->pay;
        
        $pay = array( 42623250.0,-221350.0,-196350.0,-221350.0,-196350.0,-221350.0,-196350.0,-221350.0,-196350.0,-2771350.0,-2736532.5,-2751715.0,-2716897.5,-2732080.0,-2697262.5,-2712445.0,-2677627.5,-2692810.0,-2657992.5,-2673175.0,-2638357.5,-2653540.0,-2618722.5,-2633905.0,-2599087.5,-2614270.0,-2579452.5,-2594635.0);
        //manisy negatif
        for($i=0 ; $i< count($tab) ; $i++){
            $tab[$i] = round(-$tab[$i],1);
        }
        //face - (face * Up commision)
        $face = $faceValue -($faceValue * ($this->commission/100));
        array_splice($tab,0, 0, floatval($face));
        // dump($pay);
        dump($tab);
        dump($pay);

        $exiir = $ex->calculateFromCashFlow($tab);
        
        dump($exiir * 100);
        //(1 + TRI(N25:N225/1000000) ) ^ 2-1
        $tri = (1+pow(($exiir*100),2)) - 1;
        dump(round($tri,2));
        return $tri;
     }


     //annuity
     
    //calcul element-don ajout Bailleur test
    public function calculeElementDonBailleur($faceValue, $grant){
        $this->Calendrier_de_paiement($faceValue,$this->commission);
        $GrantElement  =  (($faceValue + $grant - $this->don) / ($faceValue + $grant));
        return $GrantElement*100;    
     }

    public function CalculInteret($interest_rate, $indice_annee, $outstanding, $N, $vc = 0, $type = 0){
        for($i=0 ; $i < $N; $i++){
            if(!is_numeric($interest_rate[$i]) || !is_numeric($indice_annee[$i]) || !is_numeric($outstanding[$i]) || !is_numeric($vc) || !is_numeric($type)):
            return false;
            endif;
            
            if($type > 1|| $type < 0):
            return false;
            endif;
            
            $tauxAct[$i] = round( pow(1 + $interest_rate[$i], - $indice_annee[$i]),1);
                        
            if((1 - $tauxAct[$i]) == 0):
            //if((1- $interest_rate[$i]) == 0):
            return 0;
            endif;
            if(($indice_annee[$i] == 0)){
                $vpm[$i] = (( ( ($outstanding[$i-1] + $vc * $tauxAct[$i]) * $interest_rate[$i] / (1 - $tauxAct[$i]) ) / (1 + $interest_rate[$i] * $type) ) / 100);
            }else{
                $moy = ($outstanding[$i-1]+$outstanding[$i])/2;
                $vpm[$i] = (( ( ($moy + $vc * $tauxAct[$i]) * $interest_rate[$i] / (1 - $tauxAct[$i]) ) / (1 + $interest_rate[$i] * $type) ) / 100);
            }
            //$vpm[$i] = ( ( ($outstanding[$i-1] + $vc * $interest_rate[$i]) * $interest_rate[$i] / (1 - $interest_rate[$i]) ) / (1 + $interest_rate[$i] * $type) ) / 100;
            
        }
        //dump($vpm);
        return $vpm;
    }
    
    public function CalculPaymentPeriod($pricipal, $interest, $free, $N){
      
        for($i=0 ; $i < $N; $i++){
            $cpp[$i] = ((floatval( $pricipal[$i]) + floatval($interest[$i])) + floatval($free[$i]));
        }
        return $cpp;
    }
    public function moyenne($nb1,$nb2) { 
        $somme = 0;
         for($i = 0 ; $i < 2 ; $i++){
             $somme = round(($nb1 + $nb2),0);
         }
         return $somme/2;
     }
    public function CalculFees($indice_annee, $outstanding,$N, $management, $val,$pay){
        
        for($i=0 ; $i < $N; $i++){
            if($indice_annee[$i] > 0){
                if($management == 'Per payment period'){
                    $res_free[$i] = $val;
                } else if ($management == 'In percent of outstanding loan' && $i <= 0){
                    $res_free[$i] = (($val / 100) * (floatval($outstanding[$i]) / $pay));
                   // $i = $this->R;
                }else if($management == 'In percent of outstanding loan' && $i > 0){
                    $res_free[$i] =round( (($val / 100) * ($this->moyenne( (floatval($outstanding[$i-1])) ,(floatval($outstanding[$i]))) / $pay)));
                }
            }
            else{
                echo $res_free[$i] = '...' ;
            }

        }
        return $res_free;
    }
                        
    public function van()
    {  
        $tauxactualisation = 0.026;
        $CF = array(7500,7500,7500,7500,7500,7500,7500,7500,7500,7500,32500,32313,32125,31938,31750,31563,31375,31188,31000,30813,30625,30438,30250,30063,29875,29688,29500,29313,29125,28938,28750,28563,28375,28188,28000,27813,27625,27438,27250,27063,26875,26688,26500,26313,26125,25938,25750,25563,25375,25188); 
        $v = 0 ;
        for($i = 0; $i < 50 ; $i++){
            $fva = 1 / pow(1 + $tauxactualisation, $i);
            $v += $CF[$i] * $fva;
        }
        return $v;
    }
    // public function effective_interest_rate(){
    //     $interest = $this->CalculPaymentPeriod();
    // }
}