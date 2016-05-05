<?php

session_start();

include_once('../class/autoload.php');

$errors = array();
$data   = array();



$data['success'] = false;




$tab   = array();
$mypdo = new mypdo();


$tab['prenom'] = $_POST['prenom'];
/*
$tab['nom']=$_POST['nom'];
*/

if ($_SESSION['type'] == 'famille') {
    $tab['idFam'] = $_SESSION['id'];
} else {
    $tab['idFam'] = $_SESSION['aka'];
}





$data = $mypdo->insert_enfant_admin($tab);



echo json_encode($data);
?>