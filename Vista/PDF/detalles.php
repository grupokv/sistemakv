<?php 
require_once('../../Resources/fpdf/fpdf.php');
require_once('../../Modelo/DetalleOperacion.php');
require_once('../../Modelo/DetalleGastoPersonal.php');


class PDF extends FPDF{
 
    function Header(){
    	$this->SetFont('Arial','',14);
		$this->Cell(0, 22,'', '', 1, '');
	}

    function Footer(){
        $this->SetFont('Arial','',14);
		$this->Cell(88, 24, '', 0,'0','C');

		// Posición: a 1,5 cm del final
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
    }
}


$fecha_inicio = $_POST['fecha_inicio'];
$fecha_final = $_POST['fecha_final'];
$informe_operacion = $_POST['informe_operacion'];

date_default_timezone_set('America/Bogota');
$fecha = date('Y-m-d');

$detalleOperacion = new DetalleOperacion();
$listar = $detalleOperacion->filtrarPDF($fecha_inicio, $fecha_final);
$precioTotal = $detalleOperacion->valorTotalFiltroPDF($fecha_inicio, $fecha_final);
$listarDetallesFinalizadosPDF = $detalleOperacion->listarDetallesFinalizadosPDF($fecha_inicio, $fecha_final);
/*
print_r($listarDetallesFinalizadosPDF);*/
/*GASTO PERSONAL*/
$detalleGastoPersonal = new DetalleGastoPersonal();
$listarDGP = $detalleGastoPersonal->filtrarDGPDF($fecha_inicio, $fecha_final);
$precioTotalDG = $detalleGastoPersonal->valorTotalFiltroDGPDF($fecha_inicio, $fecha_final);
$listarDGFinalizadosPDF = $detalleGastoPersonal->listarDGFinalizadosPDF($fecha_inicio, $fecha_final);

$pdf = new PDF();
$pdf->AddPage('L');
$pdf->AliasNbPages();

$pdf->setFont('Arial', 'B', 9);

$pdf->SetFillColor(255,255,255);
$pdf->Cell(10, 10, '', 0, 0, 'C', 1);
$pdf->Cell(46,5,'Detalle del Reporte PDF: ',0,1,'R');

$pdf->setFont('Arial', '', 9);

$pdf->Cell(16, 10, '', 0, 0, 'C', 1);
$pdf->Cell(170,5,'Informe correspondiente a los procesos realizados a cada vehiculo.',0 ,1 ,'J');
$pdf->setFont('Arial', 'B', 9);
$pdf->Cell(16, 10, '', 0, 0, 'C', 1);
$pdf->Cell(20,5,'Fecha inicio:', 0, 0,'J');
$pdf->setFont('Arial', '', 9);
$pdf->Cell(19,5, $_POST['fecha_inicio'] ,0,0,'J');
$pdf->setFont('Arial', 'B', 9);
$pdf->Cell(20,5,'Fecha final:', 0, 0,'J');
$pdf->setFont('Arial', '', 9);
$pdf->Cell(17,5,  $_POST['fecha_final'], 0, 1,'J');
$pdf->Cell(16, 10, '', 0, 0, 'C', 1);
$pdf->setFont('Arial', 'B', 9);
$pdf->Cell(47,5, utf8_decode('Fecha de emición del informe:'), 0, 0, 'J');
$pdf->setFont('Arial', '', 9);
$pdf->Cell(22,5, $fecha . "." , 0, 1,'J');
$pdf->Ln(5);



$pdf->setFont('Arial', '', 7);

/*MOSTRAR TODAS LAS OERACIONES VIGENTES*/
if ($informe_operacion == 1) {

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(15, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(80, 10, 'VEHICULO - PERSONAL', 1, 0, 'C', 1);
    $pdf->Cell(80, 10, utf8_decode('OPERACIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'FECHA', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'COSTO/VALOR', 1, 1, 'C', 1);

    foreach ($listarDGP as $ldgp) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(15, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(80, 7, utf8_decode($ldgp['nombre_persona']), 1, 0, 'C', 0);
        $pdf->Cell(80, 7, $ldgp['descripcion'] , 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $ldgp['fecha_detalle'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($ldgp['precio']), 1, 1, 'C', 0);
    }

    foreach ($listar as $l) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(15, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(80, 7, $l['placa'] , 1, 0, 'C', 0);
        $pdf->Cell(80, 7, utf8_decode($l['nombre_operacion']), 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $l['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($l['precio']), 1, 1, 'C', 0);
    }

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(45, 10, 'PRECIO TOTAL', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'CANTIDAD DE OPERACIONES', 1, 1, 'C', 1);
    $pdf->setFont('Arial', '', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->Cell(45, 7,  "$" . number_format($precioTotalDG[0]['total'] + $precioTotal[0]['total']), 1, 0, 'C');
    $pdf->Cell(45, 7, count($listar) + count($listarDGP), 1, 1, 'C');

/*MOSTRAR TODAS LAS OPERACIONES PERSONALES */
}else if ($informe_operacion == 2) {

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(15, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(60, 10, 'PERSONAL', 1, 0, 'C', 1);
    $pdf->Cell(95, 10, utf8_decode('OPERACIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'FECHA', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'COSTO/VALOR', 1, 1, 'C', 1);

    foreach ($listarDGP as $ldgp) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(15, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(60, 7, $ldgp['descripcion'] , 1, 0, 'C', 0);
        $pdf->Cell(95, 7, utf8_decode($ldgp['nombre_persona']), 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $ldgp['fecha_detalle'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($ldgp['precio']), 1, 1, 'C', 0);
    }

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(45, 10, 'PRECIO TOTAL', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'CANTIDAD DE OPERACIONES', 1, 1, 'C', 1);
    $pdf->setFont('Arial', '', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->Cell(45, 7,  "$" . number_format($precioTotalDG[0]['total']), 1, 0, 'C');
    $pdf->Cell(45, 7, count($listarDGP), 1, 1, 'C');

/*MOSTRAR TODAS LAS OPERACIONES VEHICULARES*/

}else if ($informe_operacion == 3) {

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(30, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(45, 10, 'VEHICULO', 1, 0, 'C', 1);
    $pdf->Cell(95, 10, utf8_decode('OPERACIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'FECHA', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'COSTO/VALOR', 1, 1, 'C', 1);

    foreach ($listar as $l) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(30, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(45, 7, $l['placa'] , 1, 0, 'C', 0);
        $pdf->Cell(95, 7, utf8_decode($l['nombre_operacion']), 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $l['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($l['precio']), 1, 1, 'C', 0);
    }

    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(45, 10, 'PRECIO TOTAL', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'CANTIDAD DE OPERACIONES', 1, 1, 'C', 1);
    $pdf->setFont('Arial', '', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(170, 10, '', 0, 0, 'C', 1);
    $pdf->Cell(45, 7,  "$" . number_format($precioTotal[0]['total']), 1, 0, 'C');
    $pdf->Cell(45, 7, count($listar), 1, 1, 'C');
       
/*MOSTRAR TODAS LAS OPERACIONES FINALIZADAS*/
}else if ($informe_operacion == 4) {
    
    $pdf->setFont('Arial', 'B', 7);
    $pdf->SetFillColor(255,255,255);
    $pdf->Cell(15, 10, '', 0, 0, 'C', 1);
    $pdf->SetDrawColor(255,255,255);
    $pdf->SetFillColor(199,219,255);
    $pdf->Cell(80, 10, 'VEHICULO - PERSONAL', 1, 0, 'C', 1);
    $pdf->Cell(80, 10, utf8_decode('OPERACIÓN'), 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'FECHA', 1, 0, 'C', 1);
    $pdf->Cell(45, 10, 'COSTO/VALOR', 1, 1, 'C', 1);

    /* OPERACIONES PERSONALES*/
    foreach ($listarDGFinalizadosPDF as $ldgf) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(15, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(80, 7, $ldgf['nombre_persona'] , 1, 0, 'C', 0);
        $pdf->Cell(80, 7, utf8_decode($ldgf['descripcion']), 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $ldgf['fecha_detalle'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($ldgf['precio']), 1, 1, 'C', 0);
    }

    /* OPERACIONES VEHICULARES */
    foreach ($listarDetallesFinalizadosPDF as $ldfpdf) {

        $pdf->SetFillColor(255,255,255);
        $pdf->Cell(15, 7, '', 0, 0, 'C', 1);
        $pdf->Cell(80, 7, $ldfpdf['placa'] , 1, 0, 'C', 0);
        $pdf->Cell(80, 7, utf8_decode($ldfpdf['nombre_operacion']), 1, 0, 'C', 0);
        $pdf->Cell(45, 7, $ldfpdf['fecha'], 1, 0, 'C', 0);
        $pdf->Cell(45, 7, '$' . number_format($ldfpdf['precio']), 1, 1, 'C', 0);
    }
    
}


$pdf->Output();
/*

 ?>