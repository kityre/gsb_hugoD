<?php
/*
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */

class PdoGsb{
		private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=DAVID';   		
      	private static $user='DAVID' ;
      	private static $mdp='hdavid' ;
		private static $monPdo;
		private static $monPdoGsb=null;
		/*private static $serveur='mysql:host=localhost';
      	private static $bdd='dbname=gsb';   		
      	private static $user='root' ;
      	private static $mdp='' ;
		private static $monPdo;
		private static $monPdoGsb=null; */

	private function __construct(){
    	PdoGsb::$monPdo = new PDO(PdoGsb::$serveur.';'.PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
		PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
	}
	public function _destruct(){
		PdoGsb::$monPdo = null;
	}

	public  static function getPdoGsb(){
		if(PdoGsb::$monPdoGsb==null){
			PdoGsb::$monPdoGsb= new PdoGsb();
		}
		return PdoGsb::$monPdoGsb;
	}
	/*
		 * Récupere les informations d'un visiteur avec ses identifiants
		 * @param $login 
		 * @param $mdp 
		 * @return array ( id , nom , prenom , idTypeVisiteur, libelle ) 
	*/
	public function getInfosVisiteur($login, $mdp){
		$req = "select visiteur.id as id, visiteur.nom as nom, visiteur.prenom as prenom,
		visiteur.idTypeVisiteur as idTypeVisiteur, typevisiteur.libelle as libelleTypeVisiteur from visiteur, typevisiteur
		where visiteur.idTypeVisiteur=typevisiteur.id and visiteur.login='$login' and visiteur.mdp='$mdp'";
		$rs = PdoGsb::$monPdo->query($req);
		$ligne = $rs->fetch();
		return $ligne;
	}

	/*
		 * 	Recupere les éléments hors forfait pour un mois d'un visiteur	 
		 * @param $idVisiteur
		 * @param $mois
		 * @return array (id, idVisiteur, mois, libelle, dateM, montant)
	*/
	public function getLesFraisHorsForfait($idVisiteur,$mois){
       $req = "select * from lignefraishorsforfait where idVisiteur ='$idVisiteur' and mois='$mois'
	   order by id";
	   $res = PdoGsb::$monPdo->query($req);
	   $lesLignes = $res->fetchAll();
	   return $lesLignes;
	}
	/*
		 * Recupere les nombre de justificatif d'une fiche de frais
		 * @param $idVisiteur
		 * @param $mois
		 * @return nbjustificatifs 
	*/
	public function getNbjustificatifs($idVisiteur, $mois){
		$req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idVisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$laLigne = $res->fetch();
		return $laLigne['nb'];
	}
	/*
		 * 	recupere les fiche de frais forfait d'un visiteur pour un mois donnée	 
		 * @param $idVisiteur
		 * @param $mois 
		 * @return array (idfrais,libelle, quantite ) 
	*/
	public function getLesFraisForfait($idVisiteur,$mois){
       $req = "select fraisforfait.id as idfrais, fraisforfait.libelle as libelle,
	   lignefraisforfait.quantite as quantite from lignefraisforfait,
	   fraisforfait where fraisforfait.id = lignefraisforfait.idFraisForfait
	   and lignefraisforfait.idVisiteur ='$idVisiteur' and lignefraisforfait.mois='$mois'
	   order by lignefraisforfait.idFraisForfait";
	   $res = PdoGsb::$monPdo->query($req);
	   $lesLignes = $res->fetchAll();
	   return $lesLignes;
	}
	/*
		 * 	Récupere les id des frais forfait 
		 * @return id 
	*/
	public function getLesIdFrais(){
		$req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetchAll();
		return $lesLignes;
	}
	/*
		 * 	Modifie les ligne de frais forfait d'un visiteur  
		 * @param $idVisiteur
		 * @param $mois
		 * @param $lesFrais
	*/
	public function majFraisForfait($idVisiteur, $mois, $lesFrais){
		$lesCles = array_keys($lesFrais);
		foreach($lesCles as $unIdFrais){
			$qte = $lesFrais[$unIdFrais];
			$req = "update lignefraisforfait set lignefraisforfait.quantite = $qte
			where lignefraisforfait.idVisiteur = '$idVisiteur' and lignefraisforfait.mois = '$mois'
			and lignefraisforfait.idfraisforfait = '$unIdFrais'";
			PdoGsb::$monPdo->exec($req);
		}

	}
/*
 * met à jour le nombre de justificatifs de la table ficheFrais
 * pour le mois et le visiteur concerné

 * @param $idVisiteur
 * @param $mois sous la forme aaaamm
*/
	public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs){
		// Code à ajouter
	}
/*
	* Cherche a savoir si il existe une fiche de frais pour un visiteur à un mois précis
	* @param $idVisiteur 
	* @param $mois sous la forme aaaamm
	* @return true ou false
*/
	public function estPremierFraisMois($idVisiteur,$mois)
	{
            $req = "select * from fichefrais Where idVisiteur='".$idVisiteur."' and mois='".$mois."'";
            $res = PdoGsb::$monPdo->query($req);
            if($res->rowCount() != 0)
            {
                return false ;
            }
            else
            {
                return true ;
            }
	}
	/*
		 * Clot la dernier fiche de frais d'un visiteur
		 * @param $idVisiteuy
		 * @param $avantDernierMois
	*/
	public function metAJAvantDernierMoisSaisi($idVisiteur,$avantDernierMois) {
		$dateM=date('Y-m-d');
		$req="UPDATE fichefrais SET idEtat='CL', dateModif='".$dateM."' WHERE mois='".$avantDernierMois."' and idVisiteur='".$idVisiteur."' ";
        $res = PdoGsb::$monPdo->query($req);
	}
	/*
		 * Recupere la fich crééeou  en cours de saisi du dernier mois du Visiteur 
		 * @param $idVisiteur
		 * @param $mois
		 * @return array (idVisiteur, mois, nbJustificatids, montantValide, dateModif, idEtat)
	*/
	public function avantDernierMoisSaisi($idVisiteur,$mois){
			$dernierMois="";
			$req="SELECT * FROM fichefrais WHERE idVisiteur='$idVisiteur' AND mois<>'".$mois."' AND idEtat='CR' ORDER BY mois DESC";
            $res = PdoGsb::$monPdo->query($req);
            while($laFiche =$res->fetch())	
            {
                $dernierMois=$laFiche['mois'];
				
            }
			return $dernierMois ;
			
	}
	/*
		 * Crée une fiche de frais d'un visiteur pour un mois ainsi que les lignes de frais
		 * @param $idVisiteur
		 * @param $mois 
	*/
	public function creePremiereLignesFrais($idVisiteur,$mois){
				$dateM=date('Y-m-d');
                $req2="INSERT INTO fichefrais(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,IdEtat) 
				Values ('$idVisiteur','$mois',0,0,'$dateM','CR')" ;
                $res2 = PdoGsb::$monPdo->query($req2);            
                
				$fraisforfait=['ETP','KM','NUI','REP'];
				for($i = 0 ; $i < 4 ; $i++)
				{
					$forfait=$fraisforfait[$i];
					$req="INSERT INTO lignefraisforfait(idVisiteur,mois,idFraisForfait,quantite) Values ('$idVisiteur','$mois','$forfait',0)" ;
					$res = PdoGsb::$monPdo->query($req);          
				}
                      
	}
	/*
		 * 	Cloture une fiche de frais et crée une fiche de frais ainsi que les lignes de frais
		 * @param $idVisiteur
		 * @param $mois
		 * @param $ancienMois
	*/
	public function creeNouvellesLignesFrais($idVisiteur,$mois,$ancienMois){
                $dateM=date('Y-m-d');
                $req="UPDATE fichefrais SET idEtat='CL', dateModif='".$dateM."' WHERE mois='".$ancienMois."' and idVisiteur='".$idVisiteur."' ";
                $res = PdoGsb::$monPdo->query($req);
                
                $req2="INSERT INTO fichefrais(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,IdEtat) 
				Values ('$idVisiteur','$mois',0,0,'$dateM','CR')";
				$res2 = PdoGsb::$monPdo->query($req2);            
                
				$fraisforfait=array(0=>'ETP',1=>'KM',2=>'NUI',3=>'REP');
				for($i = 0 ; $i < 4 ; $i++)
				{
					$forfait=$fraisforfait[$i];
					$req="INSERT INTO lignefraisforfait(idVisiteur,mois,idFraisForfait,quantite) Values ('$idVisiteur','$mois','$forfait',0)" ;
					$res = PdoGsb::$monPdo->query($req);          
				}
                      
	}
    /*
		 * Récupere la dernier fiche de frais d'un visiteur
		 * @param $idVisiteur
		 * @return array (idVisiteur, mois, nbJustificatids, montantValide, dateModif, idEtat)
			ou
		 * @return "Premiere Fois"
	*/
        public function dernierMoisTraite($idVisiteur)
        {
			$nb=0;
            $req="SELECT * FROM fichefrais WHERE idVisiteur='$idVisiteur' ORDER BY mois DESC";
            $res = PdoGsb::$monPdo->query($req);
            while($laFiche =$res->fetch())	
            {
				$nb+=1;
                $dernierMois=$laFiche['mois'];
            }
			if($nb!=0){
				return $dernierMois ;
			}
			else{
				return "Premiere Fois";
			}
        }  
        
	/*
		 * 	Crée une ligne de Frais hors forfait pour un visiteur
		 * @param $idVisiteur
		 * @param $mois
		 * @param $libelle
		 * @param $date
		 * @param $date
		 * @param $montant
	*/
	public function creeNouveauFraisHorsForfait($idVisiteur,$mois,$libelle,$date,$montant){
		$dateM=substr( $date,6,9)."-".substr( $date,3,4)."-".substr( $date,0,1);
		$req="INSERT INTO lignefraishorsforfait(idVisiteur,mois,libelle,dateM,montant) VALUES('$idVisiteur','$mois','$libelle','$dateM',$montant)";
		$res = PdoGsb::$monPdo->query($req); 
	}
	/*
		 * Supprime une fiche de frais hors forfait
		 * @param $idFrais
	*/
	public function supprimerFraisHorsForfait($idFrais){
		$req="DELETE FROM lignefraishorsforfait where id=$idFrais";
		$res = PdoGsb::$monPdo->query($req);
	}
	/*
		 * 	Récupere les fiches de frais d'un visiteur 
		 * @param $idVisiteur
		 * @return array ( nb [mois,numAnnee,numMois] 
	*/
	public function getLesMoisDisponibles($idVisiteur){
		$req = "select * from  fichefrais where fichefrais.idVisiteur ='$idVisiteur'
		order by mois asc ";
		$res = PdoGsb::$monPdo->query($req);
                $place = 0 ;
				$lesMois =array();
                while($laLigne =$res->fetch())	{
					$mois = $laLigne['mois'];
					$numAnnee =substr( $mois,0,4);
					$numMois =substr( $mois,4,2);
					$lesMois[$place]['mois']= $mois  ;
					$lesMois[$place]['numAnnee']=$numAnnee  ;
					$lesMois[$place]['numMois']=$numMois  ;
						$place += 1 ;
				}
		$lesMois['nb']=$place;
		return $lesMois;
	}
	/*
		 *  Recupere les informations d'une fiche de frais d'un visiteur
		 * @param $idVisiteur
		 * @param $mois 
		 * @return array (idVisiteur, mois, nbJustificatids, montantValide, dateModif, idEtat, id , libelle)
	*/
	public function getLesInfosFicheFrais($idVisiteur,$mois){
		$req="SELECT *  FROM fichefrais, etat WHERE fichefrais.idEtat=etat.id and idVisiteur='$idVisiteur' and mois='$mois'";
		$res = PdoGsb::$monPdo->query($req);
		$lesLignes = $res->fetch();
		return $lesLignes ;
	}

	/*
		 * 	Met a jour l'etat d'une fiche de frai
		 * @param $idVisiteur
		 * @param $mois
		 * @param $etat
	*/
	public function majEtatFicheFrais($idVisiteur,$mois,$etat){
		$req="UPDATE fichefrais SET dateModif='$mois' and idEtat='$etat' WHERE idVisiteur='$idVisiteur'";
		$res = PdoGsb::$monPdo->query($req);
	}

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////			COMPTABLE		////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	/*
		 * 	Récupere les mois ou il existe une fiche de frais en etat clot	 
		 * @return array (nb [mois, numAnnee, numMois ] ) 
	*/
	public function getLesMoisAValider() {
		$req="SELECT * FROM fichefrais WHERE idEtat='CL' group by mois asc";
		$res = PdoGsb::$monPdo->query($req);
		$lesMois =array();
		$place = 0 ;
		while($laLigne =$res->fetch())	{          
			$mois = $laLigne['mois'];
			$numAnnee =substr( $mois,0,4);
			$numMois =substr( $mois,4,2);
			$lesMois["$place"]=array(
                "mois"=>"$mois",
                "numAnnee"  => "$numAnnee",
				"numMois"  => "$numMois" );
            $place += 1 ;
		}
		return $lesMois ;
	}
	/*
		 * Recupere les visiteurs qui ont une fiche de frais clot pour un mois donnée
		 * @param $leMois
		 * @return array ( nb [idVisiteur, nom, prenom] )
	*/
	public function getLesFichesAValider($leMois){
		$req="SELECT
		ficheFrais.idVisiteur as idVisiteur, visiteur.nom as nom, visiteur.prenom as prenom
		FROM ficheFrais, visiteur WHERE ficheFrais.idVisiteur=visiteur.id and ficheFrais.mois='$leMois' and ficheFrais.idEtat='CL' ";
		$res = PdoGsb::$monPdo->query($req);
		$lesLibelles = array();
		$nb=0;
		while($unLibelle = $res -> fetch() ){
			$lesLibelles[$nb]=array(
				"idVisiteur"=>$unLibelle["idVisiteur"],
				"nom"=>$unLibelle["nom"],
				"prenom"=>$unLibelle["prenom"]
			);
			$nb += 1 ;
		}
		return $lesLibelles;
	}
	/*
		 * 	Revupere les information d'une fiche de frais et des fiches de frais Hors Forfait d'un visiteur oiur un mois donnée	 
		 * @param $idVisiteur
		 * @param $mois 
		 * @return array ( mois , dateModif , idEtat , nbJustificatifs, montantValide, 
					lignefraisforfait [ nb [ idFraisForfait,libelleFraisForfait,montant,quantite ] ],
					lignefraisforfait [ nb [ idHorsForfait,libelleHorsForfait,dateMHorsForfait, montantHorsForfait ] ],
					montantValide ) 
	*/
	public function getLesInfoVisiteurAValider($leVisiteur,$leMois) {
		$lesInfo = array();
		
		$req1="SELECT mois as mois, dateModif as dateModif,idEtat as idEtat, nbJustificatifs as nbJustificatifs,
		montantValide as montantValide	FROM fichefrais WHERE idVisiteur='".$leVisiteur."' AND mois='".$leMois."' ";
		$res1 = PdoGsb::$monPdo->query($req1);
		$uneInfo = $res1 -> fetch();
			$lesInfo['mois']=$uneInfo['mois'];
			$lesInfo['dateModif']=$uneInfo['dateModif'];
			$lesInfo['idEtat']=$uneInfo['idEtat'];
			$lesInfo['nbJustificatifs']=$uneInfo['nbJustificatifs'];
			$lesInfo['montantValide']=0;
			
		$req2="SELECT * FROM lignefraisforfait,fraisforfait WHERE lignefraisforfait.idfraisforfait=fraisforfait.id 
		and lignefraisforfait.idVisiteur='".$leVisiteur."' AND lignefraisforfait.mois='".$leMois."'";
		$res2 = PdoGsb::$monPdo->query($req2);
		$nb=0;
		while($uneInfo = $res2 -> fetch() ){
			$lesInfo['lignefraisforfait'][$nb]['idFraisForfait'] = $uneInfo['idFraisForfait'];
			$lesInfo['lignefraisforfait'][$nb]['libelleFraisForfait'] = $uneInfo['libelle'];
			$lesInfo['lignefraisforfait'][$nb]['montant'] = $uneInfo['montant'];
			$lesInfo['lignefraisforfait'][$nb]['quantite'] = $uneInfo['quantite'];
			$lesInfo['montantValide']+=$lesInfo['lignefraisforfait'][$nb]['montant'] * $lesInfo['lignefraisforfait'][$nb]['quantite'];
			$nb += 1 ;
		}
			$lesInfo['nbFraisForfait+1']=$nb;
		$req3="SELECT * FROM lignefraishorsforfait WHERE idVisiteur='".$leVisiteur."' AND mois='".$leMois."'";
		$res3 = PdoGsb::$monPdo->query($req3);
		$nb=0;
		while($uneInfo = $res3 -> fetch() ){
			$lesInfo['lignefraishorsforfait'][$nb]['idHorsForfait'] = $uneInfo['id'];
			$lesInfo['lignefraishorsforfait'][$nb]['libelleHorsForfait'] = $uneInfo['libelle'];
			$lesInfo['lignefraishorsforfait'][$nb]['dateMHorsForfait'] = $uneInfo['dateM'];
			$lesInfo['lignefraishorsforfait'][$nb]['montantHorsForfait'] = $uneInfo['montant'];
			if(substr($lesInfo['lignefraishorsforfait'][$nb]['libelleHorsForfait'],0,7) != "REFUSER")
			{
				$lesInfo['montantValide']+=$lesInfo['lignefraishorsforfait'][$nb]['montantHorsForfait'];
			}
			$nb += 1 ;
		}
			$lesInfo['nbFraisHorsForfait+1']=$nb;
		
		return $lesInfo;
	}
	/*
		 * Modifie les quantites des lignes de frais forfait 
		 * @param $leVisiteur
		 * @param $mois
		 * @param $lesMontant
	*/
		public function MiseAJourElementForfaitise($leMois,$leVisiteur,$lesMontant) {
			FOR($i=1 ; $i<5 ; $i++) {
				$id=$lesMontant[$i]["id"];
				$req="	UPDATE lignefraisforfait
						SET quantite=".$lesMontant[$i]['quantite']."
						WHERE mois='".$leMois."' AND idVisiteur='".$leVisiteur."' AND idFraisForfait='".$id."' ";
				$res = PdoGsb::$monPdo->query($req);
			}
		}
	/*
		 * 	Refuse un element hors forfait en ajoutant "REFUSER" au debut du libelle de l'element
		 * @param idHorsForfait 
	*/
		public function RefuserFicheHorsForfait($idHorsForfait) {
			$req1="SELECT libelle FROM lignefraishorsforfait WHERE id=".$idHorsForfait." ";
			$res1 = PdoGsb::$monPdo->query($req1);
			$Info = $res1 -> fetch();
			$lelibelle="";
			if(substr($Info['libelle'],0,7) != "REFUSER")
			{
				$lelibelle="REFUSER ";
			}				
			$lelibelle.=$Info['libelle'];
			
			$req2="	UPDATE lignefraishorsforfait
					SET libelle='".$lelibelle."'
					WHERE id='".$idHorsForfait."' ";
			$res2 = PdoGsb::$monPdo->query($req2);
		}
	/*
		 * 	Met en "Validée et mise en paiement" une fiche de frais et modifie la date de modification
		 * @param $idVisiteur
		 * @param $mois 
		 * @param $dateM 
		 * @return 
	*/	
		public function validerFicheFrais($leMois,$idVisiteur,$dateM) {
			$req="	UPDATE ficheFrais
					SET idEtat='VA', dateModif='".$dateM."'
					WHERE mois='".$leMois."' AND idVisiteur='".$idVisiteur."' ";
			$res = PdoGsb::$monPdo->query($req);					
		}
	/*
		 * 	Récupere Les information des fiche de frais, des visiteur pour les fiches en etat "Saisie clôturée"
		 * @return array (nb [idVisiteur, mois,nom,prenom  ])
	*/		
		public function getInfoFicheFraisAFinir() {

			$req="SELECT * FROM fichefrais, visiteur WHERE idVisiteur=id AND idEtat='CL' ORDER BY mois, nom";
			$res = PdoGsb::$monPdo->query($req);
			$nb=0;
			$lesInfos = array() ;
			while($uneInfo = $res -> fetch() ){
				$lesInfos[$nb]['idVisiteur'] = $uneInfo['idVisiteur'] ;
				$lesInfos[$nb]['mois'] = $uneInfo['mois'] ;
				$lesInfos[$nb]['nom'] = $uneInfo['nom'] ;
				$lesInfos[$nb]['prenom'] = $uneInfo['prenom'] ;
				$nb+=1;
			}
			$lesInfos['nb']=$nb;
			return $lesInfos ;
		}
	/*
		 * 	Met l'etat d'une fiche de frais en "Remboursée" 
		 * @param $leVisiteur
		 * @param $mois
	*/		
		public function validerFicheAFinir($leVisiteur,$leMois){
			$dateM=date('Y-m-d');
			$req="	UPDATE fichefrais
					SET idEtat='RB', dateM='".$dateM."'
					WHERE idVisiteur='".$leVisiteur."' AND mois='".$leMois."' ";
			$res = PdoGsb::$monPdo->query($req);	
		}
	/*
		 * Récupere les information d'une fiche de frais pour lafficher au format PDF
		 * @param $idVisiteur
		 * @param $mois 
		 * @return 
	*/		
		public function getInfoPourPDF($leVisiteur,$leMois) {
			$req1='SELECT * FROM fichefrais WHERE idVisiteur="'.$leVisiteur.'" AND mois="'.$leMois.'" ';
			$res1 = PdoGsb::$monPdo->query($req1);
			$lesInfo = array() ;
			$lesInfo['rembourser']=0;
			$lesInfo['refuser']=0;
			$uneInfo = $res1 -> fetch();
				$lesInfo['nbJustificatifs'] = $uneInfo['nbJustificatifs'];
				$lesInfo['montantValide']= $uneInfo['montantValide'];
				$lesInfo['dateModif'] = $uneInfo['dateModif'];
				$lesInfo['idEtat'] = $uneInfo['idEtat'];
				
			$type=array(0=>'ETP',1=>'KM',2=>'NUI',3=>'REP');
			for($i=0 ; $i <4 ; $i++) {			
				$req2='SELECT * FROM lignefraisforfait, fraisforfait WHERE id=idfraisforfait AND idVisiteur="'.$leVisiteur.'" AND mois="'.$leMois.'" and id="'.$type[$i].'" '; 
				$res2 = PdoGsb::$monPdo->query($req2);
				$uneInfo = $res2 -> fetch();
					$lesInfo['libelle'.$type[$i]] = $uneInfo['libelle'] ;
					$lesInfo['Quantite'.$type[$i]] = $uneInfo['quantite'];
					$lesInfo['MontantUnitaire'.$type[$i]] = $uneInfo['montant'];
					$lesInfo['Total'.$type[$i]] = $uneInfo['montant']*$uneInfo['quantite'];
					$lesInfo['rembourser']+=$lesInfo['Total'.$type[$i]];
			}
			
			$req3 = 'SELECT dateM, libelle, montant  FROM lignefraishorsforfait WHERE idVisiteur="'.$leVisiteur.'" AND mois="'.$leMois.'" ORDER BY mois desc';
			$res3 = PdoGsb::$monPdo->query($req3);
			$i=0;
			$lesInfo['nbHF']=0;
			while($uneInfo = $res3 -> fetch() ){
				$lesInfo['date'][$i]=$uneInfo['dateM'];
				$lesInfo['libelle'][$i]=$uneInfo['libelle'];
				$lesInfo['montant'][$i]=$uneInfo['montant'];
				$i+=1;
				$lesInfo['nbHF']=$i;
				if( substr($uneInfo['libelle'],0,7)=="REFUSER"){
					$lesInfo['refuser']+=$uneInfo['montant'];
				}
				else
				{
					$lesInfo['rembourser']+=$uneInfo['montant'];
				}
			}
				

			$req4="SELECT * FROM visiteur WHERE id='".$leVisiteur."' ";
			$res4 = PdoGsb::$monPdo->query($req4);
			$leVisi=$res4 -> fetch();
			$lesInfo['prenom']=$leVisi['prenom'];
			$lesInfo['nom']=$leVisi['nom'];
			
			return $lesInfo ;
		}
	/*
		 * 	Reporte une fiche Hors forfait d'un visiteur pour le mois suivant
		 * @param $idHorsForfait
		 * @param $leVisiteur 
		 * @return 
	*/
		public function ReporterFicheHorsForfait($idHorsForfait,$leVisiteur){
			$dateM= date('Y-m-d');
			$nouveauMois= date('Ym');
			$nb=0;
			$req1="SELECT * FROM fichefrais WHERE idVisiteur='".$leVisiteur."' AND mois='".$nouveauMois."' ";
			$res1 = PdoGsb::$monPdo->query($req1);
			while($uneInfo = $res1 -> fetch() ){
				$nb+=1;
			}
			if($nb==0){
				$req2="INSERT INTO fichefrais(idVisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) VALUES 
				('".$leVisiteur."','".$nouveauMois."',0,0,'".$dateM."','CR')";
				$res2 = PdoGsb::$monPdo->query($req2);
			}
			$req3="UPDATE lignefraishorsforfait SET mois='".$nouveauMois."', dateM='".$dateM."' WHERE id=".$idHorsForfait." ";
			$res3 = PdoGsb::$monPdo->query($req3);
		}

}		
?>
