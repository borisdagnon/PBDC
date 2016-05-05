<?php
class mypdo extends PDO
{
    
    private $PARAM_hote = 'localhost'; // le chemin vers le serveur
    private $PARAM_utilisateur = 'boris'; // nom d'utilisateur pour se connecter
    private $PARAM_mot_passe = 'boris1995'; // mot de passe de l'utilisateur pour se connecter
    private $PARAM_nom_bd = 'bd_pbdc';
    
    private $connexion;
    
    public function __construct()
    {
        try {
            
            $this->connexion = new PDO('mysql:host=' . $this->PARAM_hote . ';dbname=' . $this->PARAM_nom_bd, $this->PARAM_utilisateur, $this->PARAM_mot_passe, array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ));
            //echo '<script>alert ("ok connex");</script>)';echo $this->PARAM_nom_bd;
        }
        catch (PDOException $e) {
            echo 'hote: ' . $this->PARAM_hote . ' ' . $_SERVER['DOCUMENT_ROOT'] . '<br />';
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N° : ' . $e->getCode();
            $this->connexion = false;
            //echo '<script>alert ("pbs acces bdd");</script>)';
        }
    }
    public function __get($propriete)
    {
        switch ($propriete) {
            case 'connexion': {
                return $this->connexion;
                break;
            }
        }
    }
    
    public function connect($tab)
    {
        if ($tab['categ'] == 'famille') {
            $requete = 'select * from famille where identifiant="' . $tab['id'] . '" and mp=MD5("' . $tab['mp'] . '");';
        }
        if ($tab['categ'] == 'admin') {
            $requete = 'select * from administrateur where identifiant="' . $tab['id'] . '" and mp=MD5("' . $tab['mp'] . '");';
        }
        if ($tab['categ'] == 'personnel') {
            $requete = 'select * from personnel where identifiant="' . $tab['id'] . '" and mp="' . $tab['mp'] . '";';
        }
        $result = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 1) {
                return ($result);
            }
        }
        return null;
    }
    public function trouve_famille($idfamille)
    {
        $requete = 'select * from famille where id_famille=' . $idfamille . ';';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 1) {
                return ($result->fetch(PDO::FETCH_OBJ));
            }
        }
        return null;
    }
    public function trouve_famille_famille($idfamille)
    {
        $requete = 'select * from famille where identifiant="' . $idfamille . '";';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 1) {
                return ($result->fetch(PDO::FETCH_OBJ));
            }
        }
        return null;
    }
    
    
    public function trouve_enfant($idenfant)
    {
        $requete = 'select * from enfant e INNER JOIN famille f ON e.id_famille=f.identifiant where id=' . $idenfant . ' ;';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 1) {
                return ($result->fetch(PDO::FETCH_OBJ));
            }
        }
        return null;
    }
    
    
    public function supprime_famille_admin($identifiant)
    {
        $errors = array();
        $data   = array();
        
        $req       = 'select count(id) as C from enfant WHERE id_famille =  "' . $identifiant . '";';
        $resultReq = $this->connexion->query($req);
        $donnees   = $resultReq->fetch(PDO::FETCH_OBJ);
        if ($donnees->C == 0) {
            $requete  = "DELETE FROM famille WHERE identifiant = '" . $identifiant . "';";
            $nblignes = $this->connexion->exec($requete);
        } else {
            $errors['requete'] = 'Enfants présent pas de suppression possible';
        }
        
        
        
        
        
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Suppression famille ok!';
        }
        
        return $data;
    }
    public function supprime_enfant_famille($identifiant)
    {
        $errors = array();
        $data   = array();
        
        $requete = "DELETE FROM enfant WHERE id = '" . $identifiant . "';";
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Pbs suppression enfant :' . $requete;
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Suppression enfant ok!';
        }
        return $data;
        
        
    }
    
    public function insert_enfant_admin($tab)
    {
        $errors  = array();
        $data    = array();
        $requete = 'INSERT INTO enfant (prenom, id_famille) VALUES (' . $this->connexion->quote($tab['prenom']) . ',' . $this->connexion->quote($tab['idFam']) . ');';
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Pbs insertion enfant :' . $requete;
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Insertion enfant ok!';
        }
        return $data;
        
        $_SESSION['aka'] = array();
        session_destroy($_SESSION['aka']);
        
    }
    
    
    
    
    public function affiche_commentaire($id_eleve)
    {
        $errors  = array();
        $data    = array();
        $requete = 'SELECT * FROM commentaire c INNER JOIN enfant e ON c.id_enfant=e.id INNER JOIN famille f ON f.identifiant=e.id_famille WHERE id_enfant = ' . $id_eleve . ' ORDER BY commentaire_date DESC;';
        
        $result = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    
    public function insert_commentaire($tab)
    {
        $errors  = array();
        $data    = array();
        $requete = 'INSERT INTO commentaire (commentaire_text, id_enfant, commentaire_date) VALUES (' . $this->connexion->quote($tab['commentaire']) . ',' . $this->connexion->quote($tab['identifiant']) . ', NOW());';
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Un commentaire à déjà été posté aujourd\'hui';
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Insertion commentaire ok!';
        }
        return $data;
        
    }
    
    
    public function supp_commentaire($tab)
    {
        $errors  = array();
        $data    = array();
        $requete = 'DELETE FROM commentaire WHERE id_enfant=' . $this->connexion->quote($tab['idEnfant']) . ' AND  commentaire_date=' . $this->connexion->quote($tab['dateCommentaire']) . ';';
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Suppression du commentaire impossible';
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Suppression Commentaire OK!';
        }
        return $data;
        
    }
    
    
    public function insert_famille_admin($tab)
    {
        
        $errors = array();
        $data   = array();
        
        // attention le mot de passe est en clair tant que le mail de confirmation  n'est pas envoyé
        $requete = 'INSERT INTO famille (identifiant,mp,nom1,prenom1,adresse11,adresse12,cp1,ville1,mail1,tel11,tel12,tel13,fonction1, nom2,prenom2,adresse21,adresse22,cp2,ville2,mail2,tel21,tel22,tel23,fonction2)
        VALUES (' . $this->connexion->quote($tab['identifiant']) . ',' . 'MD5(' . $this->connexion->quote($tab['mp']) . '),' . $this->connexion->quote($tab['nom1']) . ',' . $this->connexion->quote($tab['prenom1']) . ',' . $this->connexion->quote($tab['adresse11']) . ',' . $this->connexion->quote($tab['adresse12']) . ',' . $this->connexion->quote($tab['cp1']) . ',' . $this->connexion->quote($tab['ville1']) . ',' . $this->connexion->quote($tab['mail1']) . ',' . $this->connexion->quote($tab['tel11']) . ',' . $this->connexion->quote($tab['tel12']) . ',' . $this->connexion->quote($tab['tel13']) . ',' . $this->connexion->quote($tab['fonction1']) . ',' . $this->connexion->quote($tab['nom2']) . ',' . $this->connexion->quote($tab['prenom2']) . ',' . $this->connexion->quote($tab['adresse21']) . ',' . $this->connexion->quote($tab['adresse22']) . ',' . $this->connexion->quote($tab['cp2']) . ',' . $this->connexion->quote($tab['ville2']) . ',' . $this->connexion->quote($tab['mail2']) . ',' . $this->connexion->quote($tab['tel21']) . ',' . $this->connexion->quote($tab['tel22']) . ',' . $this->connexion->quote($tab['tel23']) . ',' . $this->connexion->quote($tab['fonction2']) . ');';
        
        
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Pbs insertion famille :' . $requete;
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Insertion famille ok!';
        }
        return $data;
    }
    
    public function modif_enfant($tab)
    {
        $errors = array();
        $data   = array();
        
        $requete  = 'UPDATE enfant SET ' . 'prenom=' . $this->connexion->quote($tab['prenom']) . ' ' . ' WHERE id=' . $this->connexion->quote($tab['id_eleve']) . ';';
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Pas de modifications d\'information :' . $requete;
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Modification enfant ok!';
        }
        return $data;
        
    }
    
    public function modif_famille_admin($tab)
    {
        
        
        $errors = array();
        $data   = array();
        
        $requete = 'update famille ' . 'set nom1=' . $this->connexion->quote($tab['nom1']) . ',' . 'prenom1=' . $this->connexion->quote($tab['prenom1']) . ',' . 'adresse11=' . $this->connexion->quote($tab['adresse11']) . ',' . 'adresse12=' . $this->connexion->quote($tab['adresse12']) . ',' . 'cp1=' . $this->connexion->quote($tab['cp1']) . ',' . 'ville1=' . $this->connexion->quote($tab['ville1']) . ',' . 'mail1=' . $this->connexion->quote($tab['mail1']) . ',' . 'tel11=' . $this->connexion->quote($tab['tel11']) . ',' . 'tel12=' . $this->connexion->quote($tab['tel12']) . ',' . 'tel13=' . $this->connexion->quote($tab['tel13']) . ',' . 'fonction1=' . $this->connexion->quote($tab['fonction1']) . ',' . 'nom2=' . $this->connexion->quote($tab['nom2']) . ',' . 'prenom2=' . $this->connexion->quote($tab['prenom2']) . ',' . 'adresse21=' . $this->connexion->quote($tab['adresse21']) . ',' . 'adresse22=' . $this->connexion->quote($tab['adresse22']) . ',' . 'cp2=' . $this->connexion->quote($tab['cp2']) . ',' . 'ville2=' . $this->connexion->quote($tab['ville2']) . ',' . 'mail2=' . $this->connexion->quote($tab['mail2']) . ',' . 'tel21=' . $this->connexion->quote($tab['tel21']) . ',' . 'tel22=' . $this->connexion->quote($tab['tel22']) . ',' . 'tel23=' . $this->connexion->quote($tab['tel23']) . ',' . 'fonction2=' . $this->connexion->quote($tab['fonction2']) . ' where identifiant=' . $this->connexion->quote($tab['identifiant']) . ';';
        
        $nblignes = $this->connexion->exec($requete);
        if ($nblignes != 1) {
            $errors['requete'] = 'Pas de modifications d\'information :' . $requete;
        }
        
        
        
        if (!empty($errors)) {
            $data['success'] = false;
            $data['errors']  = $errors;
        } else {
            
            $data['success'] = true;
            $data['message'] = 'Modification famille ok!';
        }
        return $data;
    }
    
    
    
    public function liste_famille()
    {
        $requete='';
        if($_SESSION['$type']=='Ajout')
        {
          $requete = 'SELECT * FROM famille WHERE id_famille="'.$_SESSION['id'].'" ORDER BY identifiant ASC ;';

        }
        else
        {
          $requete = 'SELECT * FROM famille ORDER BY identifiant ASC ;';
        }
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    
    public function liste_enfant_famille($identifiant)
    {
        if ($_SESSION['type'] == 'famille') {
            
            $id = $_SESSION['id'];
            
        }
        
        $requete = 'select * from enfant e INNER JOIN famille f ON e.id_famille=f.identifiant WHERE id="' . $identifiant . '";';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    
    public function liste_enfant_famille_famille($identifiant)
    {
        
        
        $requete = 'select * from enfant e INNER JOIN famille f ON e.id_famille=f.identifiant WHERE f.identifiant="' . $identifiant . '";';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    
    public function liste_enfant_famille_admin($identifiant)
    {
        $requete = 'SELECT * FROM famille as f
INNER JOIN enfant as e ON e.id_famille = f.identifiant
WHERE f.id_famille =  "' . $identifiant . '";';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    public function liste_enfant()
    {
        $requete = 'select * from enfant e INNER JOIN famille f ON e.id_famille=f.identifiant;';
        $result  = $this->connexion->query($requete);
        if ($result) {
            if ($result->rowCount() == 0) {
                return false;
            }
            return $result;
            
        }
        return false;
    }
    
}
?>
