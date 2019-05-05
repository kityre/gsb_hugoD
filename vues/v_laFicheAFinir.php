<div id='infoFiche'>
<h3>Fiche de frais à valider du mois <?php echo $numMois."-".$numAnnee?> :</h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $lesInfoVisiteur['idEtat'] ?> depuis le <?php echo $lesInfoVisiteur['dateModif']?> <br> Montant validé : <?php echo $lesInfoVisiteur['montantValide']?>
    </p>
	<form method='POST' action="index.php?uc=suivrePaiement&action=validerFicheAFinir">
		<input type='hidden' class='leVisiteur' name='leVisiteur' value='<?php echo $leVisiteur ; ?>'>
		<input type='hidden' class='leMois' name='leMois' value='<?php echo $leMois ; ?>'>
		<?php if( ($lesInfoVisiteur['nbFraisForfait+1']==0) ) {
				echo "<center><h3>Aucune Fiche Forfait</h3></center>";
			} else {?>
				<table class="listeLegere">
					<caption>Eléments forfaitisés </caption>
					<tr>
						<?php
						for($i=0 ; $i < $lesInfoVisiteur['nbFraisForfait+1'] ; $i++)
						{
							$libelle = $lesInfoVisiteur['lignefraisforfait'][$i]['libelleFraisForfait'];
							?><th> <?php echo $libelle?></th><?php
						}
						?>
					</tr>
					<tr>
						<?php
						
						for($i=0 ; $i < $lesInfoVisiteur['nbFraisForfait+1'] ; $i++)
						{
								$quantite = $lesInfoVisiteur['lignefraisforfait'][$i]['quantite'];
						?>
								<td class="qteForfait">
									<center><?php echo $quantite ; ?></center>
								</td>
						 <?php
						}
						?>
					</tr>
				</table>
		<br><br>
	<?php }	if($lesInfoVisiteur['nbFraisHorsForfait+1']==0) {
		?><center><h3>Pas de fiche hors forfait</h3></center><?php
	} else {?>
		<table class="listeLegere">
		   <caption>Descriptif des éléments hors forfait -<?php echo $lesInfoVisiteur['nbJustificatifs'] ?> justificatifs reçus -
		   </caption>
				 <tr>
					<th class="date">Date</th>
					<th class="libelle">Libellé</th>
					<th class='montant'>Montant</th>
				 </tr>
			<?php      
				$nb=0;
			  for($i=0 ; $i < $lesInfoVisiteur['nbFraisHorsForfait+1'] ; $i++) 
			  {
				$id = $lesInfoVisiteur['lignefraishorsforfait'][$i]['idHorsForfait'];
				$date = $lesInfoVisiteur['lignefraishorsforfait'][$i]['dateMHorsForfait'] ;
				$libelle = $lesInfoVisiteur['lignefraishorsforfait'][$i]['libelleHorsForfait'];
				$montant = $lesInfoVisiteur['lignefraishorsforfait'][$i]['montantHorsForfait'];
				$nb+=1;
			?>
				<tr>
					<?php 
						if(substr($libelle,0,7)=="REFUSER")
						{
							echo "
							<td><font color='red'>".$date."</font></td>
							<td><font color='red'>".$libelle."</font></td>
							<td><font color='red'>".$montant."</font></td>";
						}
						else
						{?>
							<td><?php echo $date ?></td>
							<td><?php echo $libelle ?></td>
							<td><?php echo $montant ?></td>
						<?php }?>
				 </tr>
			<?php 
			  }
			  if($nb==0){ echo "<center><h3>Aucune Fiche Hors Forfait</h3></center>"; }
			?>
		</table>
		<?php } ?>
		<br>
		<center> 
			<input type="submit" value="Valider Fiche Frais" style="width:150px;height:50px;" name="validerFicheFrais"> 
			<button class="afficherPDF"  style="width:150px;height:50px;" >Telecharger PDF</button>
		</center>
		
	</form>
  </div>
  </div>
  <script>
$(document).ready(function(){
	$('.afficherPDF').click(function(){
		var leVisiteur = $('.leVisiteur').val();
		var leMois = $('.leMois').val();
		window.open('index.php?uc=suivrePaiement&action=afficherPdfFiche&v='+ leVisiteur + "&m=" + leMois );
		return false;
	});
	
});
</script>