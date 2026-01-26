<?php 

ob_start();
include ("Sesion/autenticar.php");
require('../../Resources/fuec/fpdf.php');
require('../../Resources/fpdf-easytable-master/exfpdf.php');
require('../../Resources/fpdf-easytable-master/easyTable.php');
require('../../Modelo/Usuario.php');
require('../../Modelo/General.php');
date_default_timezone_set('America/Bogota');


$capacidad = $_POST['capacidad_do'];
$tipo_vehiculo = $_POST['tipo_vehiculo_do'];
$modelo = $_POST['modelo_do'];
$departamento = $_POST['departamento_do'];
$ciudad = $_POST['ciudad_do'];

if ($_POST) {

    if($capacidad != ''){
        $capacidad = $capacidad;
    }else{
        $capacidad = '%%';
    }

    if($tipo_vehiculo != '0'){
        $tipo_vehiculo = $tipo_vehiculo;
    }else{
        $tipo_vehiculo = '%%';
    }

    if($modelo != ''){
        $modelo = $modelo;
    }else{
        $modelo = '%%';
    }

    if($departamento != ''){
        $departamento = $departamento;
    }else{
        $departamento = '%%';
    }

    if($ciudad != ''){
        $ciudad = $ciudad;
    }else{
        $ciudad = '%%';
    }

}else{
    $capacidad = '%%';
    $tipo_vehiculo = '%%';
    $modelo = '%%';
    $departamento = '%%';
    $ciudad = '%%';
}

$filtrarReporteDataOperativa = filtroDataOperativa($capacidad, $tipo_vehiculo, $modelo, $departamento, $ciudad);



class PDF extends exFPDF{

    function  Header(){
        $this->SetFont('Arial','B',11);
        $this->Cell(20, 10, "", 0, '0','J');
		$this->Cell(145,27,$this->Image("../../Resources/fpdf/img/logo-ort.jpg", $this->GetX()+6, $this->GetY()+1, 40),0,1,'J');
        $this->SetFont('Arial','B',8.1);
        $this->Cell(20, 5, "", 0, '0','J');
        $this->Cell(51, 5, utf8_decode("ORGANIZACIÓN ORT SAS"), 0, '0','C');
        $this->Cell(119, 5, "", 0, '1','J');
        $this->Cell(20, 5, "", 0, '0','J');
        $this->Cell(51, 5, utf8_decode("NIT: ") . "830099803", 0, '0','C');
        $this->Cell(119, 5, "", 0, '1','J');
	    $this->Ln(7);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0, 10,'Pag '.$this->PageNo().'/{nb}', 0, '0','C');
    }

}


$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->Ln(8);
$pdf->SetFont('Arial','B',10);
$pdf->Cell(190, 12, utf8_decode("DATA OPERATIVA"), 'T,L,R,B', '1','C');
$pdf->SetFont('Arial','B',7.5);

$pdf->Ln(1);
$table = new easyTable($pdf, '{30, 20, 20, 45, 25, 15, 18, 17}', 'font-size: 7; font-family:Arial;');
    $table->easyCell('NOMBRE Y APELLIDO', 'border: T,L,B; align:C;');
    $table->easyCell('CELULAR', 'border: T,L,B; align:C;');
    $table->easyCell('FIJO', 'border: T,L,B; align:C;');
    $table->easyCell(utf8_decode('CORREO ELECTRÓNICO'), 'border: T,L,B; align:C;');
    $table->easyCell(utf8_decode('TIPO VEHÍCULO'), 'border: T,L,B; align:C;');
    $table->easyCell(utf8_decode('MODELO'), 'border: T,L,B; align:C;');
    $table->easyCell(utf8_decode('CAPACIDAD'), 'border: T,L,B; align:C;');
    $table->easyCell('CIUDAD', 'border: T,L,B,R; align:C;');

    $table->printRow();

$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Arial','',8.1);
foreach ($filtrarReporteDataOperativa as $frdo) {
    $table = new easyTable($pdf, '{30, 20, 20, 45, 25, 15, 18, 17}', 'font-size: 7; font-family:Arial;');
        $table->easyCell(strtoupper($frdo['nombres_apellidos']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['telefono_celular']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['telefono_fijo']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['correo_electronico']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['tipo_vehiculo']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['modelo']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['capacidad']), 'border: T,L,B; align:C;');
        $table->easyCell(strtoupper($frdo['ciudad']), 'border: T,L,B,R; align:C;');

        $table->printRow();

    $table->endTable(0);
}

$pdf->Output();

?>