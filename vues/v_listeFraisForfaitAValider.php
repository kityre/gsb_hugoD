<h3>Fiche de frais à valider du mois <?php echo $numMois."-".$numAnnee?> :</h3>
    <div class="encadre">
    <p>
        Etat : <?php echo $lesInfoVisiteur['idEtat'] ?> depuis le <?php echo $lesInfoVisiteur['dateModif']?> <br> Montant validé : <?php echo $lesInfoVisiteur['montantValide']?>
    </p>
	<form method='POST' action="index.php?uc=valideFrais&action=MiseAJourElementForfaitise">
	<?php if( ($lesInfoVisiteur['nbFraisForfait+1']==0) ) {
				echo "<center><h3>Aucune Fiche Forfait</h3></center>";
			} else {				
				?>
		<table class="listeLegere">
		   <caption>Eléments forfaitisés </caption>
			<tr>
			 <?php
			 for($i=0 ; $i < $lesInfoVisiteur['nbFraisForfait+1'] ; $i++)
			 {
				$libelle = $lesInfoVisiteur['lignefraisforfait'][$i]['libelleFraisForfait'];
			?>	
				<th> <?php echo $libelle?></th>
			 <?php
			}
			?>
				<th> </th>
			</tr>
			<tr>
			<?php
			$nn=0;
			for($i=0 ; $i < $lesInfoVisiteur['nbFraisForfait+1'] ; $i++)
			  {
					$quantite = $lesInfoVisiteur['lignefraisforfait'][$i]['quantite'];
			?>
					<td class="qteForfait">
						<select name='<?php echo $lesInfoVisiteur['lignefraisforfait'][$i]["idFraisForfait"]; ?>'>
							<?php
							for($nb=0 ; $nb<31 ; $nb++)
							{
								$selected="";
								if($nb==$quantite){$selected="selected";}
								echo "<option value='".$nb."' ".$selected.">".$nb."</option>";
							}?>
						</select>
					</td>
			 <?php
				$nn+=1;
			  }
			  if($nb==0){ echo "<center><h3>Aucune Fiche  Forfait</h3></center>"; }
			?>
				<td>
					<input type='hidden' name='leMois' value='<?php echo $leMois  ; ?>' >
					<input type='hidden' name='leVisiteur' value='<?php echo $leVisiteur  ; ?>' >
					<center><input type='submit' value=' Modifier' size='7'></center>
				</td>
			</tr>
		</table>
	</form>
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
					<th></th>
					<th></th>
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
							<td><font color='red'>".$montant."</font></td>
							<td></td>
							<td></td>";
						}
						else
						{?>
							<td><?php echo $date ?></td>
							<td><?php echo $libelle ?></td>
							<td><?php echo $montant ?></td>
						
							<td>
								<form method='POST' action="index.php?uc=valideFrais&action=RefuserElementHorsForfaitise">
								<input type='hidden' name='leMois' value='<?php echo $leMois  ; ?>' >
								<input type='hidden' name='leVisiteur' value='<?php echo $leVisiteur  ; ?>' >
								<input type='hidden' name='idHorsForfait' value='<?php echo $id  ; ?>' >
								
								<center><input type="submit" value="Refuser"  ></center>
								
								</form>
							</td>
							<td>
								<form method='POST' action="index.php?uc=valideFrais&action=ReporterElementHorsForfaitise">
								<input type='hidden' name='leMois' value='<?php echo $leMois  ; ?>' >
								<input type='hidden' name='leVisiteur' value='<?php echo $leVisiteur  ; ?>' >
								<input type='hidden' name='idHorsForfait' value='<?php echo $id  ; ?>' >
								
								<center><input type="submit" value="Reporter"  ></center>
								
								</form>
							</td>
						<?php }?>
					</tr>
			<?php 
			  }
			  if($nb==0){ echo "<center><h3>Aucune Fiche Hors Forfait</h3></center>"; }
			?>
		</table>
	<?php } ?>
	<form method='POST' action="index.php?uc=valideFrais&action=MiseAJourElement">
		<input type='hidden' name='leMois' value='<?php echo $leMois  ; ?>' >
		<input type='hidden' name='leVisiteur' value='<?php echo $leVisiteur  ; ?>' >
		<input type='hidden' name='nom' value='<?php echo $nom  ; ?>' >
		<input type='hidden' name='numAnnee' value='<?php echo $numAnnee  ; ?>' >
		<input type='hidden' name='numMois' value='<?php echo $numMois  ; ?>' >
		<input type='hidden' name='prenom' value='<?php echo $prenom  ; ?>' >
		
		<br>
		<center> <input type="submit" value="Valider Fiche Frais" style="width:150px;height:50px;"> </center>
	</form>
  </div>
  </div>
 