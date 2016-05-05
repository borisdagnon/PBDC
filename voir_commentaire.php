<?php
session_start();
include_once('class/autoload.php');

if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
    
    
    
    if ($_SESSION['type'] == 'personnel') {
        
        $site = new page_base_securisee_personnel('Voir Commentaires enfant');
        
        
        $site->js    = 'jquery.validate.min';
        $site->js    = 'messages_fr';
        $site->js    = 'jquery.tooltipster.min';
        $site->style = 'tooltipster';
        $site->style = 'perso';
        
        
        $controleur          = new controleur();
        $site->right_sidebar = $site->rempli_right_sidebar();
        $site->left_sidebar  = $controleur->affiche_liste_enfant('VoirCommentaire');
        if (isset($_POST["nom_checkbox"])) {
            foreach ($_POST["nom_checkbox"] as $index => $value) {
                $_SESSION['id_eleve'] = $value;
                $site->left_sidebar   = $controleur->retourne_commentaire('VoirCommentaire', $value);
                break;
            }
        }
    }
    
    
    else {
        if ($_SESSION['type'] == 'admin') {
            
            $site = new page_base_securisee_admin('Ajout enfant');
            
            
            
            $site->js    = 'jquery.validate.min';
            $site->js    = 'messages_fr';
            $site->js    = 'jquery.tooltipster.min';
            $site->style = 'tooltipster';
            $site->style = 'perso';
            
            
            $controleur          = new controleur();
            $site->right_sidebar = $site->rempli_right_sidebar();
            $site->left_sidebar  = $controleur->affiche_liste_enfant('VoirCommentaire');
            if (isset($_POST["nom_checkbox"])) {
                foreach ($_POST["nom_checkbox"] as $index => $value) {
                    $_SESSION['id_eleve'] = $value;
                    $site->left_sidebar   = $controleur->retourne_commentaire('VoirCommentaire', $value);
                    
                    break;
                }
            }
        } else {
            $site = new page_base('Accueil');
            
            
            $site->js = 'jssor.core';
            $site->js = 'jssor.utils';
            $site->js = 'jssor.slider';
            $site->js = 'jssor.pbdc';
            
            $controleur          = new controleur();
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
    
    $controleur          = new controleur();
    $site->right_sidebar = $site->rempli_right_sidebar();
    $site->left_sidebar  = $controleur->retourne_carroussel();
    $site->left_sidebar  = $controleur->retourne_article_accueil();
    
}


$site->affiche();
?>

