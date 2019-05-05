<?php
require 'fpdf\pdf.php' ;
ob_get_clean(); 
$pdf-> new FPDF($leVisiteur,$leMois,$lesInfo) ;
$pdf->AliasNbpage() ;
$pdf->AddPage() ;
	$pdf->header();
	$pdf->Visi_Mois();
	$pdf->HeaderTableFF();
	$pdf->viewtableFF();
	$pdf->HeaderTableHF();
	$pdf->viewTableHF();
	$pdf->total();	
$pdf->Output();

?>