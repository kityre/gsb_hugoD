<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];
switch($action){
	case 'selectionnerMois':{
		$lesMois=$pdo->getLesMoisAValider();
		$lesCles = array_keys( $lesMois );
		$moisASelectionner = $lesCles[0];
		include("vues/v_listeMoisAValider.php");
		break;
	}
	case 'voirVisiteurAValider' : {
		$leMois = $_REQUEST['lstMois'];
		$lesMois=$pdo->getLesMoisAValider();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisAValider.php");
		
		$lesFiches=$pdo->getLesFichesAValider($leMois);
		$lesCles = array_keys( $lesFiches );
		$laFicheASelectionner = $lesCles[0];
		include("vues/v_listeVisiteurAValider.php");
		break;
	}
	case 'voirFicheAValider' : {
		$leMois = $_POST['lstMois'];
		$lesMois=$pdo->getLesMoisAValider();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisAValider.php");
		
		$leVisiteur= $_REQUEST['lstVisiteur'];
		$lesFiches=$pdo->getLesFichesAValider($leMois);
		$laFicheASelectionner=$leVisiteur;
		include("vues/v_listeVisiteurAValider.php");

		$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);
		include("vues/v_listeFraisForfaitAValider.php");
		break ;
	}
	case'MiseAJourElementForfaitise' : {
		extract($_POST);
		$leMois = $_POST['leMois'];
		$leVisiteur= $_POST['leVisiteur'];
		
		$lesMontant[1]['id']='ETP';
		$lesMontant[2]['id']='KM';
		$lesMontant[3]['id']='NUI';
		$lesMontant[4]['id']='REP';
				
		if(!empty($_POST['ETP'])) {
			$lesMontant[1]['quantite']=$_POST['ETP'];
		}else {
			$lesMontant[1]['quantite']=0;
		}
		if(!empty($_POST['KM'])) {
			$lesMontant[2]['quantite']=$_POST['KM'];
		}else {
			$lesMontant[2]['quantite']=0;
		}
		if(!empty($_POST['NUI'])) {
			$lesMontant[3]['quantite']=$_POST['NUI'];
		}else {	
			$lesMontant[3]['quantite']=0;
		}
		if(!empty($_POST['REP'])) {
			$lesMontant[4]['quantite']=$_POST['REP'];
		}else {	
			$lesMontant[4]['quantite']=0;
		}
		$pdo->MiseAJourElementForfaitise($leMois,$leVisiteur,$lesMontant) ;
		
		$lesMois=$pdo->getLesMoisAValider();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisAValider.php");
		
		$lesFiches=$pdo->getLesFichesAValider($leMois);
		$laFicheASelectionner=$leVisiteur;
		include("vues/v_listeVisiteurAValider.php");
		
		$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);
		include("vues/v_listeFraisForfaitAValider.php");
				
		break;
	}
	
	case'RefuserElementHorsForfaitise' : {
		extract($_POST);
		$leMois = $_POST['leMois'];
		$leVisiteur= $_POST['leVisiteur'];
		$idHorsForfait= $_POST['idHorsForfait'];
		$pdo->RefuserFicheHorsForfait($idHorsForfait);
		
		$lesMois=$pdo->getLesMoisAValider();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisAValider.php");
		
		$lesFiches=$pdo->getLesFichesAValider($leMois);
		$laFicheASelectionner=$leVisiteur;
		include("vues/v_listeVisiteurAValider.php");
		
		$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);
		include("vues/v_listeFraisForfaitAValider.php");
		
		break;
	}
	
	case'ReporterElementHorsForfaitise' : {
		extract($_POST);
		$leMois = $_POST['leMois'];
		$leVisiteur= $_POST['leVisiteur'];
		$idHorsForfait= $_POST['idHorsForfait'];
		$pdo->ReporterFicheHorsForfait($idHorsForfait,$leVisiteur);
		
		$lesMois=$pdo->getLesMoisAValider();
		$moisASelectionner = $leMois;
		include("vues/v_listeMoisAValider.php");
		
		$lesFiches=$pdo->getLesFichesAValider($leMois);
		$laFicheASelectionner=$leVisiteur;
		include("vues/v_listeVisiteurAValider.php");
		
		$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);
		include("vues/v_listeFraisForfaitAValider.php");
		
		break;
	}
	case'MiseAJourElement' : {
		extract($_POST);
		$dateM= date('Y-m-d');
		$pdo->validerFicheFrais($leMois,$leVisiteur,$dateM);
		include("vues/v_FicheValider.php");
		break;
	}
}
?>
