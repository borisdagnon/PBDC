<?php

session_start();

include_once('../class/autoload.php');

$errors          = array();
$data            = array();
$data['success'] = false;




$tab   = array();
$mypdo = new mypdo();


$data = $mypdo->supprime_enfant_famille($_SESSION['id_eleve']);



echo json_encode($data);
?>