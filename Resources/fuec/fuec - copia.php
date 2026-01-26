<?php
require('fpdf.php');

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('img/logo-vigilado-supertransporte.png',20,5,60);
    // Arial bold 15
    $this->Ln();
}

// Pie de página
function Footer()
{
    // Posición: a 1,5 cm del final
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Número de página
    $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$mintransporte = "img/logo-mintransporte.png";
$ort = "img/logo-ort.png";

// Creación del objeto de la clase heredada
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,20,'',0,1,'C');
$pdf->Cell(120,30,$pdf->Image($mintransporte, $pdf->GetX()+5, $pdf->GetY()+5, 110),1,0,'C');
$pdf->Cell(70,30,$pdf->Image($ort, $pdf->GetX()+12, $pdf->GetY()+1, 45),'B T R',1,'C');

$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'FORMATO UNICO DE EXTRACTO DEL CONTRATO DEL SERVICIO PUBLICO','R L','1','C');
$pdf->Cell(0,5,'DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL','R L','1','C');
$pdf->Cell(0,5,'No. XXXXXXXXXXXXXXXXXXX','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Razón Social'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,'XXXXXXXXXXXXXXXXXXXXX','B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'XXXXXXXXXX-X','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Contrato No.','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,'XXXXXX','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Contratante','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,'XXXXXXXXXXXXXXXXXXXXX','B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'XXXXXXXXXX-X','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Objeto del Contrato','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,'SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECIFICO DE USUARIOS','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Origen - Destino','L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,'','R',1,'L');
$pdf->Cell(0,5,'','R L B',1,'C');

$pdf->Cell(0,1,'','R L',1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(18,5,'Convenio','L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,'6',1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(18,5,'Consorcio','L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,'6',1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,utf8_decode('Unión Temporal'),'L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,'6',1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,'Con:','',0,'L');
$pdf->Cell(83,5,'','R',1,'C');
$pdf->Cell(0,1,'','R L B',1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'VIGENCIA DEL CONTRATO','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'','L B',0,'C');
$pdf->Cell(45,5,'DIA','L B',0,'C');
$pdf->Cell(45,5,'MES','L B',0,'C');
$pdf->Cell(45,5,utf8_decode('AÑO'),'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Inicial','L B',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,'XX','L B',0,'C');
$pdf->Cell(45,5,'XX','L B',0,'C');
$pdf->Cell(45,5,'XXXX','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Vencimiento','L B',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,'XX','L B',0,'C');
$pdf->Cell(45,5,'XX','L B',0,'C');
$pdf->Cell(45,5,'XXXX','L B R',1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'CARACTERISTICAS DEL VEHICULO','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'PLACA','L B',0,'C');
$pdf->Cell(25,5,'MODELO','L B',0,'C');
$pdf->Cell(70,5,'MARCA','L B',0,'C');
$pdf->Cell(70,5,'CLASE','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(25,5,'ABC123','L B',0,'C');
$pdf->Cell(25,5,'2018','L B',0,'C');
$pdf->Cell(70,5,'XXXXXXXXXXXXXXXXXXX','L B',0,'C');
$pdf->Cell(70,5,'XXXXXXXXXXX','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'NUMERO INTERNO','L B',0,'C');
$pdf->Cell(140,5,'NUMERO DE TARJETA DE OPERACION','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'0286','L B',0,'C');
$pdf->Cell(140,5,'71285','L B R',1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'CONDUCTORES','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'','L B',0,'C');
$pdf->Cell(80,5,'NOMBRES Y APELLIDOS','L B',0,'C');
$pdf->Cell(30,5,'No. CEDULA','L B',0,'C');
$pdf->Cell(30,5,'LICENCIA','L B',0,'C');
$pdf->Cell(25,5,'VIGENCIA','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'CONDUCTOR 1','L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'CONDUCTOR 2','L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'CONDUCTOR 3','L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'CONDUCTOR 4','L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'RESPONSABLE CONTRATANTE','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Nombre','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,'XXXXXXXXXXXXXXXXXXXXX','B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'No. Cedula','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'XXXXXXXXXX','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Direccion','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,'XXXXXXXXXXXXXXXXXXXXX','B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'Telefono','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'XXXXXXXXXX','B R',1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(90,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
$pdf->Cell(90,4,'glpgerencia@ortsas.com','L R',1,'C');
$pdf->Cell(90,4,'Bogota - Colombia','L R',1,'C');

$codigo = 'ortsas';
$qr = 'phpqrcode/codigos/'.$codigo.'.png';
$code39 = 'phpbarcode39/codigos/'.$codigo.'.gif';

$pdf->Cell(90,25,$pdf->Image($code39,$pdf->GetX()+12, $pdf->GetY()+1, 65),'B L R',1,'C');


$pdf->SetXY(100,212);
$pdf->Cell(30,38,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R',0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R',1,'C');
$pdf->SetXY(130,217);
$pdf->Cell(70,28,'','R',1,'C');
$pdf->SetXY(130,245);
$pdf->Cell(2,5,'','B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
$pdf->Cell(2,5,'','B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(0,3,'',0,1,'C');
$pdf->Cell(0,4,utf8_decode('Manifiesto que he leido el presente FUEC y el mismo se encuentra correctamente elaborado, de acuerdo a la información y'),0,1,'L');
$pdf->Cell(0,4,utf8_decode('documentación que he suministrado.'),0,1,'L');

$pdf->Cell(35,5,'Nombre e Identificacion:',0,0,'L');
$pdf->Cell(155,5,'','B',1,'C');

$pdf->Cell(35,5,'Fecha:',0,0,'L');
$pdf->Cell(155,5,'','B',1,'C');

$pdf->Output();

?>