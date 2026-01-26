<?php 
require('../../Resources/fuec/fpdf.php');
require("../../Modelo/General.php");


class PDF extends FPDF{
	
	function Header(){
        $this->Image('../../Resources/fpdf/img/logo-ort.jpg', 10,5,30);
		$this->Image('../../Resources/fpdf/img/logo-vigilado-supertransporte.png',150,6,45);
		$this->SetFont('Arial','',14);	
		$this->SetDrawColor(191, 216, 239);	
		$this->SetLineWidth(0.4);
		$this->Cell(0, 20,'', 'B', 1, '');
		$this->Ln(7);
    }
    
    function Footer(){
        $this->Ln(108);	
        $this->SetDrawColor(191, 216, 239);
		$this->SetLineWidth(0.4);
		$this->Cell(0, 13,'', 'B', 1, '');
        $this->Image('../../Resources/fpdf/img/logo-ort.jpg', 10,255,30);
        $this->SetTextColor(113, 113, 113);
        $this->SetFont('Arial','',9);
        $this->Ln(2);	
        $this->Cell(32, 5, '', 0,'0','J');	
        $this->Cell(147, 5, utf8_decode('Calle 73 N. 75-55. Santa Maria del Lago'), 0,'1','J');
        $this->Cell(32, 5, '', 0,'0','J');	
        $this->Cell(147, 5, utf8_decode('Info@ortsas.com - www.ortsas.com'), 0,'1','J');
        $this->Cell(32, 5, '', 0,'0','J');	
        $this->Cell(147, 5, utf8_decode('PBX. 5559265/60/61 Ext. 100'), 0,'1','J');
        $this->Cell(32, 5, '', 0,'0','J');	
        $this->Cell(147, 5, utf8_decode('Bogotá, D.C - Colombia'), 0,'1','J');
	}

}

$pdf = new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Ln(8);

$dia = date('d');
$mes = date('m');
$año = date('Y');

$pdf->SetFont('Arial','',7.5);
$pdf->Cell(23, 4, '', 0, '0','FJ');
$pdf->Cell(144, 4, utf8_decode("BOGOTÁ ") . $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 0, '0','FJ');
$pdf->Cell(23, 4, '', 0, '1','FJ');

$pdf->Cell(23, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','',7);
$pdf->Cell(13, 4, utf8_decode("AFILIADO"), 0, '0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell(141, 4, "123456789", 0, '0','FJ');
$pdf->Cell(23, 4, '', 0, '1','FJ');

$pdf->Ln(13);

$pdf->SetFont('Arial','B',12);
$pdf->Cell(190, 10, "PAZ Y SALVO", 0, '1','C');

$pdf->Ln(19);


$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(20, 4, "La empresa", 0, '0','FJ');
$pdf->SetFont('Arial','B',7.5);
$pdf->Cell(41, 4, utf8_decode("ORGANIZACIÓN ORT SAS"), 'B', '0','C');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(13, 4, "con NIT", 0, '0','J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(23, 4, "900461872-8", 'B', '0','C');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(38, 4, utf8_decode("hace constar que el móvil"), 0, '0','FJ');
$pdf->SetFont('Arial','B',8.5);
$pdf->Cell(15, 4, "1066", 'B', '0','C');
$pdf->Cell(20, 4, '', 0, '1','FJ');

$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(15, 4, utf8_decode("de placas"), 0, '0','J');
$pdf->SetFont('Arial','B',7.5);
$pdf->Cell(15, 4, "WHT352", 'B', '0','C');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(22, 4, "a nombre de", 0, '0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(56, 4, utf8_decode("EVELYN CAJALES ARCHBOLD"), 'B', '0','C');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(23, 4, "se encuentra a", 0, '0','FJ');
$pdf->SetFont('Arial','B',7.5);
$pdf->Cell(19, 4, "PAZ Y SALVO", 0, '0','FJ');
$pdf->Cell(20, 4, '', 0, '1','FJ');


$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','',9.4);
$pdf->Cell(74, 4, utf8_decode("por todo concepto., Costos de operación hasta el"), 0, '0','FJ');
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(35, 4, $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 'B', '0','C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(41, 4, utf8_decode("y pólizas RCC-RCE hasta el"), 0, '0','FJ');
$pdf->Cell(20, 4, '', 0, '1','FJ');


$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','B', 7.5);
$pdf->Cell(35, 4, $dia ." DE " . strtoupper(mes($mes)) . " DEL " . $año, 'B', '0','C');
$pdf->SetFont('Arial','', 9.4);
$pdf->Cell(106, 4, utf8_decode(", por constancia y afirmación de lo anterior fimo en Bogotá D.C el día"), 0, '0','C');
$pdf->SetFont('Arial','B', 7.5);
$pdf->Cell(9, 4, utf8_decode($dia ." DE "), 0, '0','J');
$pdf->Cell(20, 4, '', 0, '1','FJ');


$pdf->SetFont('Arial','B', 7.5);
$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->Cell(45, 4, strtoupper(mes($mes)) . " DEL " . $año . ".", 0, '0','FJ');


$pdf->Ln(17);


$pdf->SetFont('Arial','',9);
$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->Cell(190, 4, "Cordialmente,", 0, '1','FJ');

$pdf->Ln(15);

$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','', 8);
$pdf->Cell(50, 4, utf8_decode("NOMBRE ENCARGADO"), 0, '0','C');
$pdf->Cell(50, 4, utf8_decode("NOMBRE ENCARGADO"), 0, '0','C');
$pdf->Cell(50, 4, utf8_decode("NOMBRE ENCARGADO."), 0, '0','C');
$pdf->Cell(20, 4, '', 0, '1','FJ');

$pdf->Cell(20, 4, '', 0, '0','FJ');
$pdf->SetFont('Arial','B',7.5);
$pdf->Cell(50, 4, utf8_decode("CARTERA."), 0, '0','C');
$pdf->Cell(50, 4, utf8_decode("JURIDICA"), 0, '0','C');
$pdf->Cell(50, 4, utf8_decode("TESORERIA."), 0, '0','C');
$pdf->Cell(20, 4, '', 0, '1','FJ');

$pdf->Output();

?>