    <?php
include_once('class/autoload.php');
$form = "";
ini_set('sendmail_from', 'borisdagnon@SRV2008.dagnon.local');
var_dump($_POST);
/*
 ********************************************************************************************
 CONFIGURATION
 ********************************************************************************************
 */
// destinataire est votre adresse mail. Pour envoyer à plusieurs à la fois, séparez-les par une virgule
$destinataire = 'borisdagnon@SRV2008.dagnon.local';

// copie ? (envoie une copie au visiteur)
$copie = 'oui'; // 'oui' ou 'non'

// Messages de confirmation du mail
$message_envoye     = "Votre message nous est bien parvenu !";
$message_non_envoye = "L'envoi du mail a échoué, veuillez réessayer SVP.";

// Messages d'erreur du formulaire
$message_erreur_formulaire   = "Vous devez d'abord <a href=\"contact.html\">envoyer le formulaire</a>.";
$message_formulaire_invalide = "Vérifiez que tous les champs soient bien remplis et que l'email soit sans erreur.";

/*
 ********************************************************************************************
 FIN DE LA CONFIGURATION
 ********************************************************************************************
 */

// on teste si le formulaire a été soumis
if (!isset($_POST['envoi']))
  {
    // formulaire non envoyé
    echo '<p>' . $message_erreur_formulaire . '</p>' . "\n";
  }
else
  {
    /*
     * cette fonction sert à nettoyer et enregistrer un texte
     */
    function Rec($text)
      {
        $text = htmlspecialchars(trim($text), ENT_QUOTES);
        if (1 === get_magic_quotes_gpc())
          {
            $text = stripslashes($text);
          }
        
        $text = nl2br($text);
        return $text;
      }
    ;
    
    /*
     * Cette fonction sert à vérifier la syntaxe d'un email
     */
    function IsEmail($email)
      {
        $value = preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $email);
        return (($value === 0) || ($value === false)) ? false : true;
      }
    
    // formulaire envoyé, on récupère tous les champs.
    $nom     = (isset($_POST['nom'])) ? Rec($_POST['nom']) : '';
    $email   = (isset($_POST['email'])) ? Rec($_POST['email']) : '';
    $objet   = (isset($_POST['objet'])) ? Rec($_POST['objet']) : '';
    $message = (isset($_POST['message'])) ? Rec($_POST['message']) : '';
    
    // On va vérifier les variables et l'email ...
    $email = (IsEmail($email)) ? $email : ''; // soit l'email est vide si erroné, soit il vaut l'email entré
    
    if (($nom != '') && ($email != '') && ($objet != '') && ($message != ''))
      {
        // les 4 variables sont remplies, on génère puis envoie le mail
        /* $headers  = 'MIME-Version: 1.0' . "\r\n";*/
        
        
        // envoyer une copie au visiteur ?
        if ($copie == 'oui')
          {
            $cible = $destinataire . ';' . $email;
          }
        else
          {
            $cible = $destinataire;
          }
        ;
        
        // Remplacement de certains caractères spéciaux
        $message = str_replace("&#039;", "'", $message);
        $message = str_replace("&#8217;", "'", $message);
        $message = str_replace("&quot;", '"', $message);
        $message = str_replace('<br>', '', $message);
        $message = str_replace('<br />', '', $message);
        $message = str_replace("&lt;", "<", $message);
        $message = str_replace("&gt;", ">", $message);
        $message = str_replace("&amp;", "&", $message);
        
        
        
        // Envoi du mail
        $headers = 'FROM: ' . $email;
        
        if (mail($destinataire, $objet, $message, $headers))
          {
            if (isset($_SESSION['id']) && isset($_SESSION['type']))
              {
                
                
                
                if ($_SESSION['type'] == 'personnel')
                  {
                    $site->js = 'jssor.core';
                    $site->js = 'jssor.utils';
                    $site->js = 'jssor.slider';
                    $site->js = 'jssor.pbdc';
                    $site     = new page_base_securisee_personnel('Envoi Mail');
                    
                    
                    echo $form .= $message_envoye;
                    
                  }
                else
                  {
                    if ($_SESSION['type'] == 'famille')
                      {
                        $site->js = 'jssor.core';
                        $site->js = 'jssor.utils';
                        $site->js = 'jssor.slider';
                        $site->js = 'jssor.pbdc';
                        $site     = new page_base_securisee_famille('Envoi Mail');
                        echo $form .= $message_envoye;
                        
                      }
                    else
                      {
                        
                      }
                  }
              }
            else
              {
                $site->js = 'jssor.core';
                $site->js = 'jssor.utils';
                $site->js = 'jssor.slider';
                $site->js = 'jssor.pbdc';
                echo $form .= $message_envoye;
              }
          }
        else
          {
            $site->js = 'jssor.core';
            $site->js = 'jssor.utils';
            $site->js = 'jssor.slider';
            $site->js = 'jssor.pbdc';
            echo $form .= $message_non_envoye;
          }
        
        
        // Envoi du mail avec gestion des erreurs
        
        
        
        
      }
    else
      {
        // une des 3 variables (ou plus) est vide ...
        echo '<p>' . $message_formulaire_invalide . ' <a href="contact.php">Retour au formulaire</a></p>' . "\n";
      }
    ;
  }
; // fin du if (!isset($_POST['envoi']))






$site->right_sidebar = $site->rempli_right_sidebar();
$site->left_sidebar  = $controleur->retourne_carroussel();
$site->left_sidebar  = $controleur->retourne_article_accueil();

$site->affiche();
?>