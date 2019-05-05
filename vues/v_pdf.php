<?php
$annee=substr($leMois,0,4);
$moisNb=substr($leMois,4,2);
$moisLI=array('01'=>'Janvier','02'=>'Fevrier','03'=>'Mars','04'=>'Avril','05'=>'Mai','06'=>'Juin',
'07'=>'Juillet','08'=>'Aout','09'=>'Septembre','10'=>'Octobre','11'=>'Novembre','12'=>'Decembre');
$mois=$moisLI[$moisNb];

require('tfpdf/pdf.php');
ob_start();
$pdf=new tFPDF();

$pdf->AddPage();

$pdf->SetFont('Arial','B',16);
$pdf->SetFillColor(110, 110, 110);

$pdf->SetXY(2, 5);

$pdf->Image('images/logo.jpg',10,10, 64, 48);

$pdf->SetXY(15, 40);

$pdf->Cell(15,20,"REMBOURSEMENT DE FRAIS ENGAGES");
$pdf->SetFont('Arial');
$pdf->SetXY(15, 70);

$pdf->SetFont('Arial',"",12);
$pdf->Cell(10,10,"Visiteur: ".$lesInfo['prenom']." ".$lesInfo['nom']);
$pdf->SetXY(15, 80);
$pdf->Cell(10,10,"$mois - $annee");
$pdf->SetXY(10, 100);


$pdf->Cell(45,10,"Libelle",1,0,"",TRUE);
$pdf->Cell(45,10,"Quantite",1,0,"",TRUE);
$pdf->Cell(45,10,"Montant unitaire",1,0,"",TRUE);
$pdf->Cell(45,10,"Total",1,1,"",TRUE);


$type=array(0=>'ETP',1=>'KM',2=>'NUI',3=>'REP');
for($i=0 ; $i < sizeof($type) ; $i++){
	$leType=$type[$i];
	if(!empty($lesInfo['libelle'.$leType]) ){

		$pdf->Cell(45,10,$lesInfo['libelle'.$leType],1,0,"");
		$pdf->Cell(45,10,$lesInfo['Quantite'.$leType],1,0,"");
		$pdf->Cell(45,10,$lesInfo['MontantUnitaire'.$leType]."e"   ,1,0,"");
		$pdf->Cell(45,10,$lesInfo['Total'.$leType]."e",1,1,"");
	}
}

$pdf->ln();
$pdf->ln();
$pdf->ln();
$pdf->Cell(10,10,'Frais Engages Hors Forfait :');
$pdf->ln();
if($lesInfo['nbHF']>0){
	$pdf->Cell(45,10,"Date",1,0,"",TRUE);
	$pdf->Cell(90,10,"Libelle",1,0,"",TRUE);
	$pdf->Cell(45,10,"Total",1,1,"",TRUE);


	for($i=0 ; $i < $lesInfo['nbHF'] ; $i++) {
		if( substr($lesInfo['libelle'][$i],0,7)=="REFUSER"){
					$pdf->SetTextColor(200,0,0);
					$pdf->Cell(45,10,$lesInfo['date'][$i],1,0,"",false);
					$pdf->Cell(90,10,$lesInfo['libelle'][$i],1,0,"",false);
					$pdf->Cell(45,10,$lesInfo['montant'][$i],1,1,"",false);
					$pdf->SetTextColor(0,0,0);
				}
				else
				{
					$pdf->Cell(45,10,$lesInfo['date'][$i],1,0,"",false);
				$pdf->Cell(90,10,$lesInfo['libelle'][$i],1,0,"",false);
				$pdf->Cell(45,10,$lesInfo['montant'][$i],1,1,"",false);
				}
	}
}


$pdf->ln();


$pdf->Cell(50,10,"Montant valide: ".$lesInfo['rembourser'] );
$pdf->ln();
$pdf->Cell(50,10,"Montant refuse: ".$lesInfo['refuser'] );

$pdf->Output();
?>