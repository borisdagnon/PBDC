<?php
session_start();
include_once('class/autoload.php');

		$controleur=new controleur();
		
	$site = new page_base('Réglement');
	if(isset($_SESSION['id']) && isset($_SESSION['type'])){
		if ($_SESSION['type']=='famille'){
			$site = new page_base_securisee_famille('Accueil');
		}
		else
		{
			if ($_SESSION['type']=='admin'){
			$site = new page_base_securisee_admin('Accueil');
		}
		else
		{
			if ($_SESSION['type']=='personnel'){
			$site = new page_base_securisee_personnel('Accueil');
		}
		}
		
	}
}


	$site-> right_sidebar=$site->rempli_right_sidebar();
	$site-> left_sidebar=$controleur->retourne_reglement();

	
	$site->affiche();
?>