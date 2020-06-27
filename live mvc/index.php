<?php
require_once "models/ietudiants.php";
require_once "models/etudiants.php";
$etudiants= new etudiants([
    'matricule'=>'A6',
    'nom'=>'goudj',
    'prenom'=>'bakiso',
    'email'=>'bagi@gmail.com',
    'tel'=>'781117635',
    'datenaiss'=>'02/12/45',
]);
echo '<pre>';
var_dump($etudiants);
echo'</pre>';
