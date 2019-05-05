    <!-- Division pour le sommaire -->
    <div id="menuGauche">
     <div id="infosUtil">
    
        <h2>
    
</h2>
    
      </div>  
        <ul id="menuList">
			<li >
				<?php echo $_SESSION['libelleType']." : " ;?>
				<br>
				<?php echo $_SESSION['prenom']."  ".$_SESSION['nom'] ?>
			</li>
			
			<?php if($_SESSION['typeVisiteur']=="VI")
			{ ?>
		
           <li class="smenu">
              <a href="index.php?uc=gererFrais&action=saisirFrais" title="Saisie fiche de frais ">Saisie fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=etatFrais&action=selectionnerMois" title="Consultation de mes fiches de frais">Mes fiches de frais</a>
           </li>
		   
			<?php } 
			if($_SESSION['typeVisiteur']=="CO")
			{?>
			 <li class="smenu">
              <a href="index.php?uc=valideFrais&action=selectionnerMois" title="Saisie fiche de frais ">Valider fiche de frais</a>
           </li>
           <li class="smenu">
              <a href="index.php?uc=suivrePaiement&action=selectionnerFicheAFinir" title="Consultation de mes fiches de frais">Suivre paiement fiche frais</a>
           </li>
			<?php } ?>
			
			<li class="smenu">
              <a href="index.php?uc=connexion&action=deconnexion" title="Se déconnecter">Déconnexion</a>
           </li>
         </ul>
        
    </div>
    