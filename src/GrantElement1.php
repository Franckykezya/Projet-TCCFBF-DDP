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

}