<?php
include_once('class/autoload.php');


if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    
    
    
    if ($_SESSION['type'] == 'admin') {
        page_base_securisee_admin('Acceuil');
        
        $site = new page_base_securisee_personnel('Accueil');
        
        
        $site->js = 'jssor.core';
        $site->js = 'jssor.utils';
        $site->js = 'jssor.slider';
        $site->js = 'jssor.pbdc';
        
        
        $site->right_sidebar = $site->rempli_right_sidebar();
        $site->left_sidebar  = $controleur->retourne_carroussel();
        $site->left_sidebar  = $controleur->retourne_article_accueil();
        
    } else {
        if ($_SESSION['type'] == 'famille') {
            
            $site = new page_base_securisee_famille('Accueil');
            
            
            $site->js = 'jssor.core';
            $site->js = 'jssor.utils';
            $site->js = 'jssor.slider';
            $site->js = 'jssor.pbdc';
            
            
            $site->right_sidebar = $site->rempli_right_sidebar();
            $site->left_sidebar  = $controleur->retourne_carroussel();
            $site->left_sidebar  = $controleur->retourne_article_accueil();
            
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
    $site = new page_base('Connect');
    
    $site->js            = 'jquery.validate.min';
    $site->js            = 'messages_fr';
    $site->js            = 'jquery.tooltipster.min';
    $site->style         = 'tooltipster';
    $site->style         = 'perso';
    $controleur          = new controleur();
    $site->right_sidebar = $site->rempli_right_sidebar();
    $site->left_sidebar  = $controleur->retourne_formulaire_login();
    
}


$site->affiche();
?>