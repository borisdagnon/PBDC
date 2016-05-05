<?php
class page_base_securisee_personnel extends page_base
{
    
    public function __construct($p)
    {
        parent::__construct($p);
    }
    public function affiche()
    {
        
        parent::affiche();
        
    }
    public function affiche_menu()
    {
        
        parent::affiche_menu();
?>

			<li><a href="">Gestion des commentaires </a>
				<ul>
				<li><a href="ajout_commentaire.php">Poster un commentaire</a></li>
				<li><a href="voir_commentaire.php">Voir les commentaires</a></li>
				</ul>
			</li>
	
		<?php
        
    }
}
