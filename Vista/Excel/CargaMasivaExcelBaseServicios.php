<?php 

require_once ('../../Resources/PHPExcel-1.8/Classes/PHPExcel.php');
require_once ('../../Modelo/Operativo.php');
require_once ('../../Modelo/Cliente.php');
require_once ('../../Modelo/Vehiculo.php');

define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$id_cliente = $_GET['id_cliente'];
$id_contrato = $_GET['id_contrato'];

$operativo = new Operativo();
$listarProductos = $operativo->listarProductosPorCliente($id_cliente);
//print_r($listarProductos);
$listarClasesMovil = $operativo->listarClasesMovilPorIdCliente($id_cliente);

$cliente = new Cliente();
$cliente_ID = $cliente->cliente_ID($id_cliente);

$vehiculo = new Vehiculo();
$listarVehiculosPorContrato = $vehiculo->listarVehiculosPorContrato2($id_contrato);

$conductores = array();
foreach ($listarVehiculosPorContrato as $lvpc) {
    $conductoresPorVehiculo = $vehiculo->ConductoresPorVehiculo2($lvpc['id_vehiculo']);
    array_push($conductores, $conductoresPorVehiculo[0]['numero_documento_conductor'] . ' - ' . $conductoresPorVehiculo[0]['nombre_conductor']);
}

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);

$objPHPExcel = new PHPExcel();
// Establecer propiedades

$objPHPExcel->getProperties()
->setCreator("Desarrollo - SistemaKV")
->setLastModifiedBy("Desarrollo - SistemaKV")
->setTitle("Documento Excel para Carga Masiva")
->setSubject("Documento Excel para Carga Masiva")
->setDescription("Plantilla para Carga Masiva desde excel al SistemaKV.")
->setKeywords("Excel Office 2007 openxml php")
->setCategory("CARGA MASIVA - BASE SERVICIOS");

/* ---------------------------------------------------- */
/* -------------------- ESTILOS ----------------------- */
/* ---------------------------------------------------- */

$objPHPExcel->cellColor('A1:J1', '274054');
$objPHPExcel->cellColor('K1:O1', '00E3C1');
$objPHPExcel->cellColor('P1:T1', 'EDED00');
$objPHPExcel->cellColor('U1:AA1', '274054');
$objPHPExcel->cellColor('A2:AA2', 'E3E3E3');

$objPHPExcel->getActiveSheet()->getStyle('A1:J1')->getFont()->setBold(true)
    ->setName('Verdana')
    ->setSize(10)
    ->getColor()->setRGB('FFFFFF');   
    
$objPHPExcel->getActiveSheet()->getStyle('K1:T1')->getFont()->setBold(true)
    ->setName('Verdana')
    ->setSize(10)
    ->getColor()->setRGB('000000');   
    
$objPHPExcel->getActiveSheet()->getStyle('U1:AA1')->getFont()->setBold(true)
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

$objPHPExcel->getActiveSheet()->setAutoFilter('A1:AA1');
$objPHPExcel->getActiveSheet()->getStyle('A1:AA1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

/* ---------------------------------------------------- */
/* ---------------------------------------------------- */
/* ---------------------------------------------------- */

/* **************************************************** */

/* --------------------------------------------------- */
/* -------------------- HEADER ----------------------- */
/* --------------------------------------------------- */

$objPHPExcel->setActiveSheetIndex(0)
->setCellValue('A1', 'CLIENTE')
->setCellValue('B1', 'CONTRATO')
->setCellValue('C1', 'FECHA INICIAL')
->setCellValue('D1', 'HORA INICIAL')
->setCellValue('E1', 'FECHA FINAL')
->setCellValue('F1', 'HORA FINAL')
->setCellValue('G1', 'DIVISIÓN')
->setCellValue('H1', 'TIPO SERVICIO')
->setCellValue('I1', 'PRODUCTO')
->setCellValue('J1', 'GRUPO')
->setCellValue('K1', 'CLASE VEH ENTRADA')
->setCellValue('L1', 'MOVIL ENTRADA')
->setCellValue('M1', 'CONDUCTOR ENTRADA')
->setCellValue('N1', 'CANT PAX ENTRADA')
->setCellValue('O1', 'KMS ENTRADA')
->setCellValue('P1', 'CLASE VEH SALIDA')
->setCellValue('Q1', 'MOVIL SALIDA')
->setCellValue('R1', 'CONDUCTOR SALIDA')
->setCellValue('S1', 'CANT PAX SALIDA')
->setCellValue('T1', 'KMS SALIDA')
->setCellValue('U1', 'SOLICITANTE')
->setCellValue('V1', 'OBSERVACIONES')
->setCellValue('W1', 'REQUISITOS')
->setCellValue('X1', 'ORIGEN')
->setCellValue('Y1', 'DESTINO')
->setCellValue('Z1', 'VALOR TOTAL CLIENTE')
->setCellValue('AA1', 'VALOR TOTAL MOVIL');


/* --------------------------------------------------- */
/* --------------------------------------------------- */

/* *************************************************** */

/* ------------------------------------------------- */
/* -------------------- BODY ----------------------- */
/* ------------------------------------------------- */

$objPHPExcel->getActiveSheet()
->setCellValue('A2', $id_cliente)
->setCellValue('B2', $id_contrato);

/* COMENTARIOS FECHAS - FORMATO */

$objPHPExcel->getActiveSheet()
->getComment('C2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('C2')
->getText()->createTextRun('Formato requerido:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()
->getComment('C2')
->getText()->createTextRun("       ");
$objPHPExcel->getActiveSheet()
->getComment('C2')
->getText()->createTextRun('(Año-mes-día)');


$objPHPExcel->getActiveSheet()
->getComment('E2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('E2')
->getText()->createTextRun('Formato requerido:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()
->getComment('E2')
->getText()->createTextRun("       ");
$objPHPExcel->getActiveSheet()
->getComment('E2')
->getText()->createTextRun('(Año-mes-día)');

/* COMENTARIOS FECHAS - FORMATO */

$objPHPExcel->getActiveSheet()
->getComment('D2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('D2')
->getText()->createTextRun('Formato requerido:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()
->getComment('D2')
->getText()->createTextRun("       ");
$objPHPExcel->getActiveSheet()
->getComment('D2')
->getText()->createTextRun('Hora Militar');


$objPHPExcel->getActiveSheet()
->getComment('F2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('F2')
->getText()->createTextRun('Formato requerido:');
$objCommentRichText->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()
->getComment('F2')
->getText()->createTextRun("       ");
$objPHPExcel->getActiveSheet()
->getComment('F2')
->getText()->createTextRun('Hora Militar');


/* COMENTARIOS VALORES TOTALES */

$objPHPExcel->getActiveSheet()
->getComment('Z2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('Z2')
->getText()->createTextRun('Requerido si el tipo de servicio es OCASIONAL');


$objPHPExcel->getActiveSheet()
->getComment('AA2')
->setAuthor('SistemaKV');
$objCommentRichText = $objPHPExcel->getActiveSheet()
->getComment('AA2')
->getText()->createTextRun('Requerido si el tipo de servicio es OCASIONAL');

/* ------------------------------------------------- */

/* DROPDOWN TIPO SERVICIO */
$objValidation1 = $objPHPExcel->getActiveSheet()->getCell('H2')->getDataValidation();
$objValidation1->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
               ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
               ->setAllowBlank(false)
               ->setShowInputMessage(true)
               ->setShowErrorMessage(true)
               ->setShowDropDown(true)
                               -> setErrorTitle ('El valor ingresado es incorrecto')
                               -> setError ('El valor que ingresó no está en la lista desplegable')
                               -> setPromptTitle ('Cuadro de selección desplegable')
                               -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
               ->setFormula1('"FIJO,OCASIONAL"');   


$objPHPExcel->getActiveSheet()->setTitle('Plantilla_Base_Servicios');

/*NUEVA HOJA DE CALCULO*/

$newsheet = $objPHPExcel->createSheet(1);
$newsheet->setTitle('Data_Dropdown_List');

$objPHPExcel->setActiveSheetIndex(1)
->setCellValue('A1', 'PRODUCTOS')
->setCellValue('B1', 'VEHICULOS')
->setCellValue('C1', 'CLASE VEH')
->setCellValue('D1', 'CONDUCTORES');

$objPHPExcel->cellColor('A1:D1', '274054');

$objPHPExcel->getActiveSheet()->getStyle('A1:D1')->getFont()->setBold(true)
    ->setName('Verdana')
    ->setSize(10)
    ->getColor()->setRGB('FFFFFF');   

foreach(range('A','D') as $columnID) {
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
        ->setWidth(40);
    $objPHPExcel->getActiveSheet()->getStyle($columnID)
        ->getAlignment()->setWrapText(true);
}

$objPHPExcel->getActiveSheet()->setAutoFilter('A1:D1');

/*------------------------------------- */
/* ----------- DATA PRODUCTOS --------- */
/*------------------------------------- */

$column1 = 'A';
$ultimaColumnaProductos = '';

for ($row = 1; $row <= count($listarProductos); $row++) {
    $cell = $column1 . ($row+1);
    $newsheet = $objPHPExcel->getActiveSheet()
            ->setCellValue($cell, $listarProductos[$row-1]['detalle_producto']);
    if($row == count($listarProductos)){
        $ultimaColumnaProductos = $cell;
    }
}

/*------------------------------------- */
/* --------- DATA CLASE VEH ----------- */
/*------------------------------------- */

$column2 = 'C';
$ultimaColumnaClaseVeh = '';

for ($row2 = 1; $row2 <= count($listarClasesMovil); $row2++) {
    $cell = $column2 . ($row2+1);
    //$objPHPExcel->getActiveSheet()->setCellValue($cell, "asd");
    $newsheet = $objPHPExcel->getActiveSheet()
            ->setCellValue($cell, strtoupper($listarClasesMovil[$row2-1]['clase_movil_producto']));
    if($row2 == count($listarClasesMovil)){
        $ultimaColumnaClaseVeh = $cell;
    }
}

/*------------------------------------- */
/* ------------ VEHICULOS ------------- */
/*------------------------------------- */

$column3 = 'B';
$ultimaColumnaVehi = '';

for ($row3 = 1; $row3 <= count($listarVehiculosPorContrato); $row3++) {
    $cell = $column3 . ($row3+1);
    //$objPHPExcel->getActiveSheet()->setCellValue($cell, "asd");
    $newsheet = $objPHPExcel->getActiveSheet()
            ->setCellValue($cell, strtoupper($listarVehiculosPorContrato[$row3-1]['placa']));
    if($row3 == count($listarVehiculosPorContrato)){
        $ultimaColumnaVehi = $cell;
    }
}



/*--------------------------------------- */
/* ------------ CONDUCTORES ------------- */
/*--------------------------------------- */

$column4 = 'D';
$ultimaColumnaConds = '';

for ($row4 = 1; $row4 <= count($conductores); $row4++) {
    $cell = $column4 . ($row4+1);
    //$objPHPExcel->getActiveSheet()->setCellValue($cell, "asd");
    $newsheet = $objPHPExcel->getActiveSheet()
            ->setCellValue($cell, strtoupper($conductores[$row4-1]));
    if($row4 == count($conductores)){
        $ultimaColumnaConds = $cell;
    }
}

/*------------------------------------- */
/* --------- DROPDOWN LIST ------------ */
/*------------------------------------- */

/* DROPDOWN PRODUCTOS */
$objPHPExcel->addNamedRange( 
    new PHPExcel_NamedRange('productos', $objPHPExcel->setActiveSheetIndex(1), 'A2:'. $ultimaColumnaProductos) 
);

$objValidation2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('I2')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
               ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
               ->setAllowBlank(false)
               ->setShowInputMessage(true)
               ->setShowErrorMessage(true)
               ->setShowDropDown(true)
                               -> setErrorTitle ('El valor ingresado es incorrecto')
                               -> setError ('El valor que ingresó no está en la lista desplegable')
                               -> setPromptTitle ('Cuadro de selección desplegable')
                               -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
               ->setFormula1("=productos");

/* DROPDOWN CLASE VEHICULOS */

$objPHPExcel->addNamedRange( 
    new PHPExcel_NamedRange('claseVeh', $objPHPExcel->setActiveSheetIndex(1), 'C2:'. $ultimaColumnaClaseVeh) 
);

$objValidation3 = $objPHPExcel->setActiveSheetIndex(0)->getCell('K2')->getDataValidation();
$objValidation3->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
               ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
               ->setAllowBlank(false)
               ->setShowInputMessage(true)
               ->setShowErrorMessage(true)
               ->setShowDropDown(true)
                               -> setErrorTitle ('El valor ingresado es incorrecto')
                               -> setError ('El valor que ingresó no está en la lista desplegable')
                               -> setPromptTitle ('Cuadro de selección desplegable')
                               -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
               ->setFormula1("=claseVeh");    

$objValidation3 = $objPHPExcel->setActiveSheetIndex(0)->getCell('P2')->getDataValidation();
$objValidation3->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                                -> setErrorTitle ('El valor ingresado es incorrecto')
                                -> setError ('El valor que ingresó no está en la lista desplegable')
                                -> setPromptTitle ('Cuadro de selección desplegable')
                                -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
                ->setFormula1("=claseVeh");    

/* DROPDOWN VEHICULOS */

$objPHPExcel->addNamedRange( 
    new PHPExcel_NamedRange('vehiculos', $objPHPExcel->setActiveSheetIndex(1), 'B2:'. $ultimaColumnaVehi) 
);

$objValidation2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('L2')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
               ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
               ->setAllowBlank(false)
               ->setShowInputMessage(true)
               ->setShowErrorMessage(true)
               ->setShowDropDown(true)
                               -> setErrorTitle ('El valor ingresado es incorrecto')
                               -> setError ('El valor que ingresó no está en la lista desplegable')
                               -> setPromptTitle ('Cuadro de selección desplegable')
                               -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
               ->setFormula1("=vehiculos");    

$objValidation2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('Q2')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                                -> setErrorTitle ('El valor ingresado es incorrecto')
                                -> setError ('El valor que ingresó no está en la lista desplegable')
                                -> setPromptTitle ('Cuadro de selección desplegable')
                                -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
                ->setFormula1("=vehiculos");    

/* DROPDOWN CONDUCTORES */

$objPHPExcel->addNamedRange( 
    new PHPExcel_NamedRange('conductores', $objPHPExcel->setActiveSheetIndex(1), 'D2:'. $ultimaColumnaConds) 
);

$objValidation2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('M2')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
               ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
               ->setAllowBlank(false)
               ->setShowInputMessage(true)
               ->setShowErrorMessage(true)
               ->setShowDropDown(true)
                               -> setErrorTitle ('El valor ingresado es incorrecto')
                               -> setError ('El valor que ingresó no está en la lista desplegable')
                               -> setPromptTitle ('Cuadro de selección desplegable')
                               -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
               ->setFormula1("=conductores");    

$objValidation2 = $objPHPExcel->setActiveSheetIndex(0)->getCell('R2')->getDataValidation();
$objValidation2->setType( PHPExcel_Cell_DataValidation::TYPE_LIST )
                ->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION )
                ->setAllowBlank(false)
                ->setShowInputMessage(true)
                ->setShowErrorMessage(true)
                ->setShowDropDown(true)
                                -> setErrorTitle ('El valor ingresado es incorrecto')
                                -> setError ('El valor que ingresó no está en la lista desplegable')
                                -> setPromptTitle ('Cuadro de selección desplegable')
                                -> setPrompt ('¡Seleccione el valor que necesita del cuadro desplegable!')
                ->setFormula1("=conductores");    
               
/*--------------------------------------------------------- */
/*--------------------------------------------------------- */

// Establecer la hoja activa, para que cuando se abra el documento se muestre primero.
$objPHPExcel->setActiveSheetIndex(0);

// Se modifican los encabezados del HTTP para indicar que se envia un archivo de Excel.
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Plantilla Carga Masiva.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

?>