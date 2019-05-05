 <div id="contenu">
      <h2>Mes fiches de frais</h2>
      <h3>Mois à sélectionner : </h3>
      <form action="index.php?uc=etatFrais&action=voirEtatFrais" method="post">
      <div class="corpsForm">
         
      <p>
	 
        <label for="lstMois" accesskey="n">Mois : </label>
        <select id="lstMois" name="lstMois">
            <?php
			for($nb=0 ; $nb < $lesMois['nb'] ; $nb++ )
			{
			    $mois = $lesMois[$nb]['mois'];
				$numAnnee =  $lesMois[$nb]['numAnnee'];
				$numMois =  $lesMois[$nb]['numMois'];
				if($mois == $moisASelectionner){
					?><option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option><?php 
				} else { 
					?><option value="<?php echo $mois ?>"><?php echo  $numMois."/".$numAnnee ?> </option><?php 
				}
			}
		   ?>    
            
        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        
      </form>