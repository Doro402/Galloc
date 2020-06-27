<?php
class etudiants implements ietudiants {
private $matricule;
private $nom;
private $prenom;
private $email;
private $tel;
private $datenaiss;

public function __construct($row=null){
   $this->initialize($row);
}
public function initialize ($row=null){
if($row!=null){
    $this->matricule=$row['matricule'];
    $this->nom=$row['nom'];
    $this->prenom=$row['prenom'];
    $this->email=$row['email'];
    $this->tel=$row['tel'];
    $this->datenaiss=$row['datenaiss'];
}
}
}
