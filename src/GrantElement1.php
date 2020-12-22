<?php
namespace App;

use Symfony\Component\Validator\Constraints\Length;

class GrantElement1 
{
    private $R,$A,$INT,$M,$I = 0.026,$D,$management,$val_management;
    private $don, $commission;
    

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

    public function Calendrier_de_paiement($capital)
    {
        $N = ($this->M*$this->A);
        $outstanding[-1] = $capital;
        $j = 1;
        for ($i = 0 ; $i < $N ; $i++)
        {    
            $indice_annee[$i] = $N-$i ; 
            $interest_rate [$i]= ($this->R / $this->A) * 100;
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

        //calcul VAN
        $van = 0;
        for($i = 0; $i < $N ; $i++){
            $fva = 1 / pow(1 + $this->I, $i);
            $van += $pricipal[$i] * $fva;
        }
        $this->don = $van+($capital * $this->commission/100);
        $c30 = $capital * $this->commission/100;
        dump($c30);
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
    //    $GrantElement  =  (($faceValue + $grant - 632562) / ($faceValue + $grant));

      // dump($this->don);
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
            
            $tauxAct[$i] = pow(1 + $interest_rate[$i], - $indice_annee[$i]);
            
            if((1 - $tauxAct[$i]) == 0):
            return 0;
            endif;
            
            $vpm[$i] = ( ( ($outstanding[$i-1] + $vc * $tauxAct[$i]) * $interest_rate[$i] / (1 - $tauxAct[$i]) ) / (1 + $interest_rate[$i] * $type) ) / 100;
       
        }
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
             $somme = $nb1 + $nb2;
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
}