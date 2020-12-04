<?php 
namespace App;
class GrantElement 
{
    /**
     * M = maturity (Input)
     * G = Grace periode (Input)
     * A = Number of repayments per year// nombre de payments par ans ex : par semestre (Input)
     * INT = G - 1/A (intervale entre le temps de payement)
     * DR = M - INT (durée de rembourssement)
     * I = discount rate (taux de remise) (10% = 0.1)
     * R1 = taux d'interet pendent la période de grâce (Input)
     * R2 = taux d'interet pendent periode de repayement (Input)
     * D = ((1+I)^(1/A))-1 taux d'actualisation par periode
     * NR = A*DR total de nombre de repayement 
     * C1 = (1+I)^INT 
     * C2 = (1+I)^DR
     * 
     * GE = Grant Element
     */

    private $M, $G, $A, $R1, $R2;
    private $INT, $DR, $I, $D, $NR, $C1, $C2;
    private $payementProfile;
    public function __construct($M, $G, $A, $R, $payementProfile)
    {
        $this->M = $M;
        $this->G = $G;
        $this->A = $A;
        $this->R1 = $R;
        $this->R2 = $R;

        //calcul INT
        $this->INT = (($this->G)-(1/$this->A));

        //calcul DR
        $this->DR = ($this->M - $this->INT);

        //I initial default 10%
        $this->I = 0.026;

        //calcule taux d'actualisation par periode
        $this->D = (pow((1+$this->I),(1/$this->A))-1);

        //calcul total de nbr de repayement
        $this->NR = $this->A * $this->DR ;

        //calcule C1 et C2
        $this->C1 = pow((1+$this->I),$this->INT);
        $this->C2 = pow((1+$this->I),$this->DR);

        $this->payementProfile = $payementProfile;



    }

    public function calcule_element_don (){
        if($this->payementProfile === "Equal Principal Payment"){
            $ZG =( $this->R1 ) * (1-(1/$this->C1))/ ($this->A * $this->D);
            $ZM = (1/$this->NR) * (1/$this->C1) * ((1-(1/$this->C2))/$this->D);
            $ZX = ($this->R2/($this->A * $this->NR)) * (1/$this->C1) * ((1/$this->C2)-1+$this->D * $this->NR) / ($this->D * $this->D);

            $GE = 100 * (1 - $ZG - $ZM - $ZX );
            return round($GE,1);

        }elseif ($this->payementProfile === "Annuity") {

            $ZGa = ($this->R1) * (1 - (1/$this->C1)) / ($this->A * $this->D);
            $ZMa = (1 / ((pow((1 + $this->R2/$this->A),$this->NR)) - 1)) + 1;
            $ZXa = ($this->R2 / $this->A) * ($ZMa) * (1/$this->C1) * ((1 - 1/$this->C2) / $this->D) ; 

            $GEa = 100 * (1 - $ZGa - $ZXa);
            return round($GEa,1);

        }elseif ($this->payementProfile === "Lump Sum Principal & Interest") {

            //$GEl = 100 * ( 1 - 1 + ($this->R1 * $this->G) / pow(1 + $this->I , $this->M));
            $GEl1 = (1 - ((1+($this->R1 * $this->M)) / (pow(1 + $this->I, $this->M)))) * 100;

            return round($GEl1);
        }
        return $this->null;
    }

}