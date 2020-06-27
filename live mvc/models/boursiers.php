<?php
class boursiers extends  etudiants {
    private $typebourses;
   
    public function __construct($row=null){
        $this->initialize($row);
     }
     public function initialize ($row=null){
     if($row!=null){
         $this->typebourses=$row['typebourses'];
         $this->nom=$row['nom'];
         $this->prenom=$row['prenom'];
         $this->email=$row['email'];
         $this->tel=$row['tel'];
         $this->datenaiss=$row['datenaiss'];
     }
     }

}