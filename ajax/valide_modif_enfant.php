<?php

session_start();

include_once('../class/autoload.php');

$errors          = array();
$data            = array();
$data['success'] = false;




$tab   = array();
$mypdo = new mypdo();

$tab['prenom']   = $_POST['prenom'];
$tab['id_eleve'] = $_SESSION['id_eleve'];


$data = $mypdo->modif_enfant($tab);



echo json_encode($data);
?>