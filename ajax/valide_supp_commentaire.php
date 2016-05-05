<?php

session_start();

include_once('../class/autoload.php');

$errors          = array();
$data            = array();
$data['success'] = false;


$tab                    = array();
$mypdo                  = new mypdo();
$tab['dateCommentaire'] = $_POST['dateCommentaire'];
$tab['idEnfant']        = $_POST['idEnfant'];

$data = $mypdo->supp_commentaire($tab);

echo json_encode($data);
?>