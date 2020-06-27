<?php
class nonboursiers extends etudiants {
    private $adresse;

    public function __construct($row=null){
        $this->initialize($row);
        
     }
     public function initialize ($row=null){
     if($row!=null){
         $this->adresse=$row['adresse'];
       
     }
     }
}