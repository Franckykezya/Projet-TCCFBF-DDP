<?php
namespace App;
class GrantElement1 
{
    private $R,$A,$INT,$M,$I = 0.026,$D;
    

    public function __construct($R,$A,$INT,$M)
    {
        $this->R = $R;
        $this->A = $A;
        $this->INT = $INT;
        $this->M = $M;

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
            //dump( $outstanding[$i+1] );

        }
        $tab = array ($indice_annee, $interest_rate,$payment,$free,$interest,$pricipal,$outstanding);
        return $tab;
    }
     public function van ($tauxactualisation,$faceValue){
         $N = ($this->M*$this->A);
         //$N=5;
         //$CF = array(2000,2500,3000,3000,3000);
         $CF = array(7500,7500,7500,7500,7500,7500,7500,7500,7500,7500,32500,32313,32125,31938,31750,31563,31375,31188,31000,30813,30625,30438,30250,30063,29875,29688,29500,29313,29125,28938,28750,28563,28375,28188,28000,27813,27625,27438,27250,27063,26875,26688,26500,26313,26125,25938,25750,25563,25375,25188);
         
         $sum = 0;
         for ($i=0 ; $i < $N ; $i++){
            $sum = $sum + (($CF[$i]) / (pow((1+($tauxactualisation)),$i+1)));
            dump($sum);
         }
         //plus ganrd
         $van = -$faceValue + $sum+5000;
         dump($van);
         return $van;
     }
    /**
     * $Gelment = ((c6+c7-c32)/(c6+c7));
     * c6 = face value (vola indramina)
     * c7 = Grant(as part of financing package, in curency units)
     * c32 = van(c27;H26:H225)+c30
     * c27 = discount rate per period
     */
    public function calculeElementDon($faceValue, $grant){
       $GrantElement  =  (($faceValue + $grant - 632562) / ($faceValue + $grant));
       //dump($this->van($this->I,$faceValue));
       return $GrantElement*100;    
    }


}