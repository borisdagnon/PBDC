<?php
class page_base_securisee_admin extends page_base_securisee_famille
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

                      
		
					<li><a href="">Gestion des Familles </a>
						<ul>
							<li><a href="liste_famille.php">Liste familles</a></li>
							<li><a href="ajout_famille.php">Inscrire une famille</a></li>
							<li><a href="modif_famille.php">Modifier une famille</a></li>
							<li><a href="supp_famille.php">Supprimer une famille</a></li>
						</ul>
					</li>
<li><a href="">Gestion des commentaires </a>
						<ul>
							
							<li><a href="ajout_commentaire.php">Voir les commentaires</a></li>
							<li><a href="voir_commentaire.php">Gerer les commentaires</a></li>
							<li><a href="supp_commentaire.php">Supprimer les commentaires</a></li>
						</ul>
					</li>


				<li><a href="">Gestion des enfants </a>
				<ul>

							<li><a href="ajout_enfant.php">Inscrire un enfant</a>
							</li><li><a href="modif_enfant.php">Modifier un enfant</a>
							</li><li><a href="supp_enfant.php">Supprimer un enfant</a></li>
						

					
				</ul>
			</li>
			
	
				
	
		<?php
        
    }
}
