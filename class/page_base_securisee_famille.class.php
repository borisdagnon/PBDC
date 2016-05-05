<?php
class page_base_securisee_famille extends page_base
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
		
			
			
						
				<ul>
<?php
        
        
        if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
            if ($_SESSION['type'] == 'famille') {
?><li><a href="ajout_enfant.php">Inscrire un enfant</a></li>
							<li><a href="modif_enfant.php">Modifier un enfant</a></li>
							<li><a href="supp_enfant.php">Supprimer un enfant</a></li><?php
            }
            
        }
        
        
?>
					
				</ul>
			</li>



			<?php
        
        if (isset($_SESSION['id']) && isset($_SESSION['type'])) {
            if ($_SESSION['type'] == 'famille') {
?>
				<li><a href="">Mon compte</a>
				<ul>
				<li><a href="modif_info_famille.php">Modifier mes informations</a></li></ul>
			</li><?php
            }
            
        }
?>
			
	
		<?php
        
    }
}
