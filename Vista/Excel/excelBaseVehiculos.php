<?php 

require_once ('../../Resources/PHPExcel-1.8/Classes/PHPExcel.php');
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Conductor.php");

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$vehiculo = new vehiculo();
$listarV = $vehiculo->listar();

$usuario = new Usuario();
$tipovehiculo = new TipoVehiculo();
$conductor = new Conductor();

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objPHPExcel = new PHPExcel();
// Establecer propiedades

$objPHPExcel->getProperties()
->setCreator("Desarrollo - SistemaKV")
->setLastModifiedBy("Desarrollo - SistemaKV")
->setTitle("Documento Excel - Base Vehículos")
->setSubject("Documento Excel Base Vehículos")
->setDescription("Plantilla Base Vehículos SistemaKV.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("VEHICULOS - BASE VEHÍCULOS KV");

/* ---------------------------------------------------- */
/* -------------------- ESTILOS ----------------------- */
/* ---------------------------------------------------- */

$objPHPExcel->cellColor('A1:AA3', '274054');

$objPHPExcel->getActiveSheet()->getStyle('A1:AA3')->getFont()->setBold(true)
    ->setName('Verdana')
    ->setSize(10)
    ->getColor()->setRGB('FFFFFF');   
    
foreach(range('A','Z') as $columnID) {
    $objPHPExcel->getActiveSheet()->getStyle($columnID)
        ->getAlignment()->setWrapText(true);
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setWidth(30);
}

$objPHPExcel->getActiveSheet()->getStyle('AA')
    ->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('AA')
->setWidth(30);

$objPHPExcel->getActiveSheet()->setAutoFilter('A1:AA3');
$objPHPExcel->getActiveSheet()->getStyle('A1:AA3')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/* ---------------------------------------------------- */
/* ---------------------------------------------------- */
/* ---------------------------------------------------- */

/* **************************************************** */

/* --------------------------------------------------- */
/* -------------------- HEADER ----------------------- */
/* --------------------------------------------------- */

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'No.')
->setCellValue('B1', 'Estado')
->setCellValue('C1', 'Empresa Afiliada')
->setCellValue('D1', 'No. Movil')
->setCellValue('E1', 'Placa')
->setCellValue('F1', 'Marca y Linea')
->setCellValue('G1', 'Modelo')
->setCellValue('H1', 'Tipo de Vehículo')
->setCellValue('I1', 'Cant. Pasajeros')
->setCellValue('J1', 'No. de Motor')
->setCellValue('K1', 'No. de Chasis')
->setCellValue('L1', 'Nombre Propietario')
->setCellValue('M1', 'No. Documento Propietario')
->setCellValue('N1', 'Teléfono Propietario')
->setCellValue('O1', 'No. Tarjeta de Operación')
->setCellValue('P1', 'Fecha Vencimiento TO')
->setCellValue('Q1', 'No. Licencia de Transito')
->setCellValue('R1', 'Fecha Expedición LT')
->setCellValue('S1', 'No. de SOAT')
->setCellValue('T1', 'Fecha Vencimiento SOAT')
->setCellValue('U1', 'No. de Revisión Tecnomecanica')
->setCellValue('V1', 'Fecha Vencimiento RT')
->setCellValue('W1', 'Fecha Vencimiento RP')
->setCellValue('X1', 'No Poliza RCC')
->setCellValue('Y1', 'No Poliza RCE')
->setCellValue('Z1', 'Fecha Vencimiento Polizas RCC y RCE')
->setCellValue('AA1', 'Fecha Expedición DV');
->setCellValue('AA2', 'No. Poliza Todo Riesgo');
->setCellValue('AA3', 'Fecha Vencimiento Poliza Todo Riesgo');


/* --------------------------------------------------- */
/* --------------------------------------------------- */

/* *************************************************** */

/* ------------------------------------------------- */
/* -------------------- BODY ----------------------- */
/* ------------------------------------------------- */

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Base Vehiculos KV.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>