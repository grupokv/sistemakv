<?php
require('../Resources/fpdf/fpdf.php');

$pdf = new FPDF('P','mm','A4');
$pdf->SetAutoPageBreak(false);
$pdf->AddPage();

for($a=1;$a<=3;$a++){

$pdf->SetFillColor(234,234,234);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(40,12,$pdf->Image('../Resources/fpdf/img/logo-lp.png',$pdf->GetX()+11, $pdf->GetY()+1, 20),1,0,'C');
$pdf->Cell(100,12,'ORDEN DE SERVICIO No. SK-LP-000000001',1,0,'C');
$pdf->Cell(50,12,'Fecha: 26/10/2020',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,4,'Cliente:',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,4,'Empresa:',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(110,4,'Dirección:',1,0,'L');
$pdf->Cell(80,4,'Teléfono:',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(110,4,'Conductor:',1,0,'L');
$pdf->Cell(80,4,'Vehículo:',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(110,4,'CLASE DE SERVICIO',1,0,'C',1);
$pdf->Cell(80,4,'VALOR',1,1,'C',1);

for($i=1;$i<=6;$i++){
$pdf->SetFont('Arial','B',8);
$pdf->Cell(110,4,'',1,0,'C');
$pdf->Cell(80,4,'',1,1,'C');
}

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,4,'KMS',1,0,'C',1);
$pdf->Cell(60,4,'',1,0,'C');
$pdf->Cell(25,4,'TOTAL',1,0,'C',1);
$pdf->Cell(80,4,'',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,4,'Hora Inicio',1,0,'C');
$pdf->Cell(60,4,'',1,0,'C');
$pdf->Cell(25,4,'Hora Fin',1,0,'C');
$pdf->Cell(80,4,'',1,1,'C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,12,'Observaciones',1,0,'C');
$pdf->Cell(160,12,'',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(30,9,'Firma Cliente',1,0,'C');
$pdf->Cell(65,9,'',1,0,'L');
$pdf->Cell(30,9,'Firma Conductor',1,0,'C');
$pdf->Cell(65,9,'',1,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(190,4,'Calle 73 No. 75 - 55 Teléfono 5559260 / 5559261 / 5559265 Bogotá D.C. Colombia',1,1,'C');

if($a != 3){
$pdf->Cell(190,4,'--------------------------------------------------------------------------------------------------------------------',0,1,'C');
}

}

$pdf->Output();
?>
