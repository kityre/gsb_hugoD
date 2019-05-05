<?php
include("vues/v_sommaire.php");
$action = $_REQUEST['action'];
$idVisiteur = $_SESSION['idVisiteur'];



switch($action){
	case 'selectionnerFicheAFinir':{
		$lesInfoFicheFraisAFinir=$pdo->getInfoFicheFraisAFinir();
		$lesClesMois = $lesInfoFicheFraisAFinir[0]['mois'];
		$moisASelectionner = $lesClesMois[0];
		$lesClesID = $lesInfoFicheFraisAFinir[0]['idVisiteur'];
		$idASelectionner = $lesClesID[0];
		include("vues/v_listeFicheAFinir.php");
		break;
	}
	case 'afficherFicheAFinir':{
		$leMois = $_GET['mois'];
		$leVisiteur = $_GET['visiteur'];
		$lesInfoFicheFraisAFinir=$pdo->getInfoFicheFraisAFinir();
		$moisASelectionner = $leMois;
		$idASelectionner = $leVisiteur;
		include("vues/v_listeFicheAFinir.php");
		
		$numMois = substr($leMois,4,2);
		$numAnnee = substr($leMois,0,4);
		$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);		
		include("vues/v_laFicheAFinir.php");
		break;
	}
	case 'validerFicheAFinir' : {
		extract($_POST);
		$leMois = $_POST['leMois'];
		$leVisiteur = $_POST['leVisiteur'];
		if(!empty($validerFicheFrais)) {
			$lesInfoFicheFraisAFinir=$pdo->getInfoFicheFraisAFinir();
			$moisASelectionner = $leMois;
			$idASelectionner = $leVisiteur;
			include("vues/v_listeFicheAFinir.php");
			
			$pdo->validerFicheAFinir($leVisiteur,$leMois);
			include("vues/v_ficheRembourse.php");
			
			$numMois = substr($leMois,4,2);
			$numAnnee = substr($leMois,0,4);
			$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);		
			include("vues/v_laFicheAFinir.php");
		}
		break;
	}
	
	case 'afficherPdfFiche' : {
			extract($_GET);
			$leMois = $_GET['m'];
			$leVisiteur = $_GET['v'];
			ob_get_clean(); 
			$lesInfo=$pdo->getInfoPourPDF($leVisiteur,$leMois);
			include("vues/v_pdf.php");
		break;
	}
	
	
	
	
}


?>