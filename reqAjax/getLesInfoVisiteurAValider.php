<?php 
require ("../include/class.pdogsb.inc.php");
$pdo = PdoGsb::getPdoGsb();
$leVisiteur = $_GET['visiteur'];
$leMois = $_GET['mois'];
$lesInfoVisiteur=$pdo->getLesInfoVisiteurAValider($leVisiteur,$leMois);
echo json_encode( $lesInfoVisiteur );
?>