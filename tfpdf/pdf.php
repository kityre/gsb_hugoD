<?php 
require"tfpdf.php" ;

class PDF extends tFPDF{
	
	private $leVisiteur;
	private $leMois;
	
	private $QuantitésETP ;
	private $MontantUnitaireETP ;
	private $TotalETP ;
	
	private $QuantitésKM ;
	private $MontantUnitaireKM ;
	private $TotalKM ;
	
	private $QuantitésNUI ;
	private $MontantUnitaireNUI ;
	private $TotalNUI ;
	
	private $QuantitésREP ;
	private $MontantUnitaireREP ;
	private $TotalREP ;
	
	private $dateHs ;
	private $libelleHs ;
	private $montantHS ;
	
	private $montantFF ;
	private $montantHF ;
	private $montantTotal ;
	
	function __construct($leVisiteur,$leMois,$lesInfo) {
		$this->leVisiteur=$leVisiteur;
		$this->leMois=$leMois;
		
		$this->QuantitésETP = $lesInfo['QuantitésETP'] ;
		$this->MontantUnitaireETP = $lesInfo['MontantUnitaireETP'] ;
		$this->TotalETP = $lesInfo['QuantitésETP'] * $lesInfo['MontantUnitaireETP'] ;
		
		$this->QuantitésKM = $lesInfo['QuantitésKM'] ;
		$this->MontantUnitaireKM = $lesInfo['MontantUnitaireKM'] ;
		$this->TotalKM = $lesInfo['QuantitésKM'] * $lesInfo['MontantUnitaireKM'];
		
		$this->QuantitésNUI = $lesInfo['QuantitésNUI'] ;
		$this->MontantUnitaireNUI = $lesInfo['MontantUnitaireNUI'] ;
		$this->TotalNUI = $lesInfo['QuantitésNUI'] * $lesInfo['MontantUnitaireNUI'] ;
		
		$this->QuantitésREP = $lesInfo['QuantitésREP'] ;
		$this->MontantUnitaireREP = $lesInfo['MontantUnitaireREP'] ;
		$this->TotalREP = $lesInfo['QuantitésREP'] *  $lesInfo['MontantUnitaireREP'] ;
		
		$this->montantHF=0;
		for($i = 0 ; $i <= $lesInfo['nbHF'] ; $i++ ) {
			$this->dateHs[$i]=$lesInfo['date'][$i];
			$this->libelleHS[$i] = $lesInfo['libelle'][$i];
			$this->montantHS[$i] = $lesInfo['montant'][$i];
			if( substr($libelleHs[$i],0,9)!='[REFUSER]' ) {	$this->montantHF += $lesInfo['montantHS'][$i] ;}
		}
		
		$this->montantFF = $this->TotalETP + $this->TotalKM + $this->TotalNUI + $this->TotalREP ; 
		$this->montantTotal = $this->montantFF + $this->montantHF;
		
	}
	function header() {
		$this->Image('images/logo.jpg',75,6,60);
		$this->SetFont('Times','',18);
		$this->Cell(75,30,'Remboursement de Frais Engagés',0,0,'C');
		$this->Ln();
		$this->SetFont('times','',12);
	}
	function footer(){
		$this->SetY(-15);
		$this->SetFont('times','',8);
		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	}
	function Visi_Mois() {
		$this->SetFont('times','',14);
		$this->Cell(30,10,'Visiteur : '.$this->leVisiteur,0,0,'C');
		$this->Ln();
		$this->Cell(30,10,'Mois : '.$this->leMois,0,0,'C');
		$this->Ln();
	}	
	function HeaderTableFF() {
		$this->SetFont('times','',12);
		$this->Cell(45,10,'Frais Forfaitaires',1,0,'C');
		$this->Cell(30,10,'Quantités',1,0,'C');
		$this->Cell(45,10,'Montant Unitaire',1,0,'C');
		$this->Cell(30,10,'Total',1,0,'C');
		$this->Ln();
	}
	function viewtableFF() {
			$this->SetFont('times','',12);
			
			$this->Cell(45,10,'Forfait Etape',1,0,'C');
			$this->Cell(30,10,$this->QuantitésETP,1,0,'C');
			$this->Cell(45,10,$this->MontantUnitaireETP,1,0,'C');
			$this->Cell(30,10,$this->TotalETP,1,0,'C');
			$this->Ln();
		
			$this->Cell(45,10,'Frais Kilométrique',1,0,'C');
			$this->Cell(30,10,$this->QuantitésKM,1,0,'C');
			$this->Cell(45,10,$this->MontantUnitaireKM,1,0,'C');
			$this->Cell(30,10,$this->TotalKM,1,0,'C');
			$this->Ln();
			
			$this->Cell(45,10,'Nuitée Hôtel',1,0,'C');
			$this->Cell(30,10,$this->QuantitésNUI,1,0,'C');
			$this->Cell(45,10,$this->MontantUnitaireNUI,1,0,'C');
			$this->Cell(30,10,$this->TotalNUI,1,0,'C');
			$this->Ln();
			
			$this->Cell(45,10,'Repas Restaurant',1,0,'C');
			$this->Cell(30,10,$this->QuantitésREP,1,0,'C');
			$this->Cell(45,10,$this->MontantUnitaireREP,1,0,'C');
			$this->Cell(30,10,$this->TotalREP,1,0,'C');
			$this->Ln();
	}
	function HeaderTableHF(){
		$this->SetFont('times','',12);
		$this->Cell(30,10,'Date',1,0,'C');
		$this->Cell(50,10,'Libelle',1,0,'C');
		$this->Cell(30,10,'Montant',1,0,'C');
		$this->Ln();
	}
	function viewTableHF(){
		for($i = 0 ; $i <= count($libelleHs)  ; $i++) {
			$this->SetFont('times','',10);
			$this->Cell(30,10,$this->dateHs[$i],1,0,'C');
			$this->Cell(50,10,$this->libelle[$i],1,0,'C');
			$this->Cell(30,10,$this->montant[$i],1,0,'C');
			$this->Ln();
		}
	}
	function total(){
		$this->Cell(30,10,'Total : '.$this->montantTotal,0,0,'C');
	}
}
























