<?php
date_default_timezone_set('America/Bogota');
require('../Resources/fuec/fpdf.php');
require('../Resources/fpdf-easytable-master/exfpdf.php');
require('../Resources/fpdf-easytable-master/easyTable.php');

setlocale(LC_TIME, "C");


$logo = "logo-ort.jpg";
$cod = 1;
//print_r($empresaid);

class PDF extends exFPDF
{

    function Header()
    {
        
        $logo = "logo-ort.jpg";
        $cod = 1;
        $this->SetFont('Arial','B',11);
        $this->Cell(0,20,'',0,1,'C');
        $this->Cell(120,30,'ORDEN DE SERVICIO No. '.$cod,1,0,'C');
        $this->Cell(70,30,$this->Image("../Resources/fpdf/img/". $logo, $this->GetX()+12, $this->GetY()+1, 45),'B T R',1,'C');
        
        $this->Ln(0);

    }

    function Footer()
    {

        $this->SetY(-25);
        $this->SetFont('Arial','B',8);
        $this->Cell(0,5,'Calle 73 No. 75 - 55 Bogotá PBX 5559260',0,1,'C');
        $this->Cell(0,4,'info@ortsas.com',0,1,'C');
        $this->Cell(0,4,'Bogotá - Colombia',0,1,'C');
        $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
    }
}

$pdf = new PDF();
$pdf->AliasNbPages();

$pdf->AddPage();
$pdf->SetFont('Arial','B',11);

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DE LA ORDEN','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Tipo de Servicio'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('Compra o Adquisición de Equipos'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Fecha Creación'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,date('d-m-Y H:i a'),'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Área Solicitante'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('Sistemas'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Persona Solicitante'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('German Daniel Vasquez'),'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Válida Desde'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,date('d-m-Y'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Válida Hasta'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,date("d-m-Y",strtotime(date('d-m-Y')."+ 7 days")),'B R',1,'L');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DE LA EMPRESA','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Razón Social'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('ORGANIZACIÓN ORT S.A.S'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,'830.099.803-4','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Dirección'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('CALLE 73 No. 75 - 55'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Teléfono'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,'5559260','B R',1,'L');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'DATOS DEL PROVEEDOR','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Razón Social'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('NETCOM WIRELESS'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,'900.116.426-8','B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Dirección'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,utf8_decode('Carrera 51 No. 96 - 27'),'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30,5,utf8_decode('Teléfono'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(65,5,'6460420','B R',1,'L');

$table = new easyTable($pdf, '%{5,55,15,10,15}', 'font-size: 9; font-family:Arial; align:{C};');

$table->easyCell('No.', 'border:1; font-style:B;');
$table->easyCell('ITEM', 'border:1; font-style:B; align:C;');
$table->easyCell('VALOR UNIDAD', 'border:1; font-style:B; align:C;');
$table->easyCell('CANT', 'border:1; font-style:B; align:C;');
$table->easyCell('SUBTOTAL', 'border:1; font-style:B; align:C;');
$table->printRow();

$table->easyCell('1','border:1; font-size: 9');
$table->easyCell(utf8_decode('Teléfono IP Ref. GXP 1610'), 'border:1; font-size:9; align:C;');
$table->easyCell('$ '.number_format('119804',0,',','.'), 'border:1; align:C; font-size:9; align:C;');
$table->easyCell('5', 'border:1; font-size:9; align:C;');
$table->easyCell('$ '.number_format('599022',0,',','.'), 'border:1; align:C; font-size:9; align:C;');
$table->printRow();

$table->easyCell('2','border:1; font-size: 9');
$table->easyCell(utf8_decode('Hora Soporte Presencial'), 'border:1; font-size:9; align:C;');
$table->easyCell('$ '.number_format('150000',0,',','.'), 'border:1; align:C; font-size:9; align:C;');
$table->easyCell('1', 'border:1; font-size:9; align:C;');
$table->easyCell('$ '.number_format('150000',0,',','.'), 'border:1; align:C; font-size:9; align:C;');
$table->printRow();

$table->easyCell('','border:B L; font-size: 9; font-style:B;');
$table->easyCell(utf8_decode('SUBTOTAL'), 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('$ '.number_format('749022',0,',','.'), 'border:1;align:C;font-size:9;font-style:B;');
$table->printRow();

$table->easyCell('','border:B L; font-size: 9; font-style:B;');
$table->easyCell(utf8_decode('IVA'), 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('$ '.number_format('142314',0,',','.'), 'border:1;align:C;font-size:9;font-style:B;');
$table->printRow();

$table->easyCell('','border:B L; font-size: 9; font-style:B;');
$table->easyCell(utf8_decode('TOTAL'), 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('', 'border:B; font-size:9;align:C;font-style:B;');
$table->easyCell('$ '.number_format('891337',0,',','.'), 'border:1;align:C;font-size:9;font-style:B;');
$table->printRow();

$table->endTable(1);

$table = new easyTable($pdf, '%{100}', 'font-size: 9; font-family:Arial; align:{C};');
$table->easyCell('OBSERVACIONES', 'border:1; font-style:B;');
$table->printRow();
$table->easyCell(utf8_decode('Aprobación segun cotización No. 11854B del 18 de Marzo de 2020'), 'border:1;');
$table->printRow();
$table->endTable(30);

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,'',0,0,'C');
$pdf->Cell(90,5,'Firma y Sello','T',0,'C');
$pdf->Cell(50,5,'',0,1,'C');

$pdf->Output();
?>