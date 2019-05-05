<div id="contenu">
	<h2>Selectionner une fiche frais parmi celles à valider et mises en paiement :</h2>
    <div class="corpsForm">
	<p>
	<?php
	if($lesInfoFicheFraisAFinir['nb']==0)
	{
		echo "<center><h3>Aucune fiche a valider</h3></center>";
	}
	else {
		?><center>
			<select id="leMois_Id" name="leMois_Id">
				<option value="" >Selectionner Mois / Visiteur :</option>
			<?php
				FOR($nb=0 ; $nb < $lesInfoFicheFraisAFinir['nb'] ; $nb++) {
					$mois=$lesInfoFicheFraisAFinir[$nb]['mois'];
					$mMois=substr( $mois,4,2);
					$aMois=substr( $mois,0,4);
					$nom=$lesInfoFicheFraisAFinir[$nb]['nom'];
					$prenom=$lesInfoFicheFraisAFinir[$nb]['prenom'];
					$id=$lesInfoFicheFraisAFinir[$nb]['idVisiteur'];
					if(	($mois == $moisASelectionner )	&&	($id == $idASelectionner )	)	{
						?><option selected value="<?php echo $mois."/".$id ?>"><?php echo  $mMois."/".$aMois." - ".$nom." ".$prenom ?> </option><?php 
					} else { 
						?><option value="<?php echo $mois."/".$id ?>"><?php echo  $mMois."/".$aMois." - ".$nom." ".$prenom ?> </option><?php 
					}
				}?>
			</select>
		</center>
		<?php } ?>
		</p>
			</div>
				
	</form>
	<script>
	$(document).ready(function(){
		$('#leMois_Id').change(function() {
			var choix = $('#leMois_Id').val();
			choix = choix.split('/') ;
			
			$(location).attr('href','index.php?uc=suivrePaiement&action=afficherFicheAFinir&mois=' + choix[0] + '&visiteur=' + choix[1] );
		});
	});
	</script>