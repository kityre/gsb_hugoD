<h3>Visiteur à sélectionner : </h3>
<form action="index.php?uc=valideFrais&action=voirFicheAValider" method="post">
	<div class="corpsForm">
		<p>
			<label for="lstVisiteur" accesskey="n">Visiteur : </label>
			<select id="lstVisiteur" name="lstVisiteur">
				<?php
				foreach ($lesFiches as $laFiche)
				{
					$idVisiteur = $laFiche['idVisiteur'];
					$nom =  $laFiche['nom'];
					$prenom =  $laFiche['prenom'];
					if($idVisiteur == $laFicheASelectionner){
					?>
					<option selected value="<?php echo $idVisiteur ?>"><?php echo  $nom." ".$prenom ?> </option>
					<?php 
					}
					else{ ?>
					<option value="<?php echo $idVisiteur ?>"><?php echo  $nom."	".$prenom ?> </option>
					<?php 
					}
				}
			   ?>   
		    </select>
		</p>
	</div>
	<div class="piedForm">
		<p>
			<input id="ok" type="submit" value="Selectionner Visiteur" size="20" />
			<input type='hidden' name="lstMois" value="<?php echo $leMois ?>">
		</p> 	
</form>