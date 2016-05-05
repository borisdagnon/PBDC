<?php
session_start();
include_once('class/autoload.php');

$controleur = new controleur();
if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 'admin') {
        
        $site        = new page_base_securisee_admin('Modif famille');
        $site->js    = 'jquery.validate.min';
        $site->js    = 'messages_fr';
        $site->js    = 'jquery.tooltipster.min';
        $site->style = 'tooltipster';
        $site->style = 'perso';
        
        
        
        $site->right_sidebar = $site->rempli_right_sidebar();
        $site->left_sidebar  = $controleur->retourne_formulaire_famille_famille('Modif');
        
        
    } else {
        if ($_SESSION['type'] == 'famille') {
            $site        = new page_base_securisee_famille('Modif famille');
            $site->js    = 'jquery.validate.min';
            $site->js    = 'messages_fr';
            $site->js    = 'jquery.tooltipster.min';
            $site->style = 'tooltipster';
            $site->style = 'perso';
            
            
            
            $site->right_sidebar = $site->rempli_right_sidebar();
            $site->left_sidebar  = $controleur->retourne_formulaire_famille_famille('Modif');
        } else {
            $site = new page_base_securisee_personnel('Accueil');
            
            
            $site->js = 'jssor.core';
            $site->js = 'jssor.utils';
            $site->js = 'jssor.slider';
            $site->js = 'jssor.pbdc';
            
            
            $site->right_sidebar = $site->rempli_right_sidebar();
            $site->left_sidebar  = $controleur->retourne_carroussel();
            $site->left_sidebar  = $controleur->retourne_article_accueil();
        }
    }
} else {
    $site = new page_base('Accueil');
    
    
    $site->js = 'jssor.core';
    $site->js = 'jssor.utils';
    $site->js = 'jssor.slider';
    $site->js = 'jssor.pbdc';
    
    
    $site->right_sidebar = $site->rempli_right_sidebar();
    $site->left_sidebar  = $controleur->retourne_carroussel();
    $site->left_sidebar  = $controleur->retourne_article_accueil();
}



$site->affiche();

?>
