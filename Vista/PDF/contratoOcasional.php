<?php 
//ob_start();

require_once("../../Resources/fpdf/fpdf.php");
require_once("../../Modelo/contratoOcasional.php");
require_once("../../Modelo/Cliente.php");
require_once("../../Modelo/EmpresaEnt.php");
require_once("../../Modelo/Ciudad.php");
require_once("../../Modelo/Vehiculo.php");
require_once("../../Modelo/TipoVehiculo.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/General.php");


$id_contrato_ocasional = $_GET['id_contrato_ocasional'];

$contratoOcasional = new ContratoOcasional();
$listarContratoOcasional = $contratoOcasional->listarPorId($id_contrato_ocasional);


$cliente = new Cliente();
$listarClienteContrato = $cliente->cliente_ID($listarContratoOcasional[0]['id_cliente']);

$empresa = new Empresa();
$listarEmpresaContrato = $empresa->listarPorId($listarContratoOcasional[0]['id_empresa']);

$ciudad = new Ciudad();
$tipoVehiculo = new TipoVehiculo();


$vehiculo = new Vehiculo();
$usuario = new Usuario();


class PDF extends FPDF{

    function  Header(){
    	$this->SetFont('Arial','',14);
		$this->Cell(0, 20,'', '', 1, '');
	}

	function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0, 10,'Pag '.$this->PageNo().'/{nb}', 0, '0','C');
	}

}



$pdf = new PDF('P','mm','A4');
$pdf->AliasNbPages();

$pdf->AddPage();

/*TITULO*/

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(37,4,'',0,'','C');
$pdf->Cell(23, 4, utf8_decode('CONTRATO N°'), 0,'0','J');
$pdf->Cell(12, 4, str_pad($listarContratoOcasional[0]['id_contrato_ocasional'], 6, '0', STR_PAD_LEFT), 0,'0','J');
$pdf->Cell2(78, 4, utf8_decode('DE PRESTACIÓN DE SERVICIOS DE TRANSPORTE'), 0,'0','FJ');
$pdf->Cell(36,4,'',0,'1','C');


$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 4,'',0,'','C');
$pdf->Cell(130, 4, 'ESPECIAL DE GRUPO ESPECIFICO DE USUARIOS',0,'','C');
$pdf->Cell(30, 4,'',0,'1','C');

$pdf->Ln(12);


/* ##############################################  PG1*/

/*LINE 1*/
$pdf->SetFont('Arial','', 8);
$pdf->Cell2(41, 4, 'Entre los suscritos, de una parte', 0,'0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(75, 4, utf8_decode($listarClienteContrato[0]['representante_legalC']), 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(74, 4, utf8_decode(', mayor de edad, identificado con la cédula de ciudadanía'), 0,'1','FJ');


/*LINE 2*/
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(11, 4, utf8_decode('número'), 0,'0','FJ');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(25, 4, $listarClienteContrato[0]['numero_documentoC'], 'B', 0, 'C');
$pdf->SetFont('Arial','', 8);
$pdf->Cell2(18, 4, 'expedida en', 0,'0','FJ');
$pdf->SetFont('Arial','B', 8);
$listarLugarExpedicionC = $ciudad->listarCiudadPorId($listarClienteContrato[0]['lugar_expedicionC']);
$pdf->Cell(41, 4, $listarLugarExpedicionC[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(43, 4, 'residenciado y domiciliado en', 0,'0','F');
$pdf->SetFont('Arial','B', 8);
$listarCiudadResidenciaC = $ciudad->listarCiudadPorId($listarClienteContrato[0]['ciudad_residencia_rl']);
$pdf->Cell(32, 4, $listarCiudadResidenciaC[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(20, 4, utf8_decode('quien obra en'), 0,'1','FJ');


/*LINE 3*/
$pdf->Cell2(140, 4, utf8_decode('calidad de Representante legal del grupo de usuarios, quien en adelante se llamará'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 8.5);
$pdf->Cell2(30, 4, 'EL CONTRATANTE ,', 0,'0','C');
$pdf->SetFont('Arial','', 8.5);
$pdf->Cell2(20, 4, 'y por la otra', 0,'1','FJ');



/*LINE 4*/
$pdf->SetFont('Arial','B', 7);
$pdf->Cell2(63, 4, utf8_decode($listarEmpresaContrato[0]['representante_legal']), 'B',0, 'C');
$pdf->SetFont('Arial','', 8);
$pdf->Cell2(15, 4, 'mayor de', 0,'0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(82, 4, utf8_decode('edad, identificado con la cédula de ciudadanía número'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(25, 4,  $listarEmpresaContrato[0]['numero_documento'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8.5);
$pdf->Cell(4, 4, 'de', 0, '1', 'J');



/*LINE 5*/

$pdf->SetFont('Arial', 'B', 7);
$listarLugarExpedicionEmpresa = $ciudad->listarCiudadPorId($listarEmpresaContrato[0]['lugar_expedicion']);
$pdf->Cell(40, 4,   utf8_decode($listarLugarExpedicionEmpresa[0]['ciudad']), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(45, 4, 'residenciado y domiciliado en', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 7);
$listarCiudadResidenciaEmpresa = $ciudad->listarCiudadPorId($listarEmpresaContrato[0]['ciudad_residencia']);
$pdf->Cell(40, 4, utf8_decode($listarCiudadResidenciaEmpresa[0]['ciudad']), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(65, 4, 'quien obra en calidad de Representante Legal', 0, '1', 'FJ');




/*LINE 6*/
$pdf->SetFont('Arial', '',8);
$pdf->Cell2(32, 4, ' y Gerente general de', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(80, 4, utf8_decode($listarEmpresaContrato[0]['nombre_empresa']), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(78, 4, utf8_decode('persona jurídica con domicilio principal en la ciudad de'), 0, '1', 'FJ');




/*LINE 7*/
$pdf->SetFont('Arial', 'B', 7);
$listarCiudadEmpresa = $ciudad->listarCiudadPorId($listarEmpresaContrato[0]['id_ciudad']);
$pdf->Cell(40, 4, $listarCiudadEmpresa[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(30, 4, 'identificada con Nit: ', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, $listarEmpresaContrato[0]['nit_empresa'], 'B', 0, 'C');
$pdf->SetFont('Arial', '',8);
$pdf->Cell2(90, 4, utf8_decode('Habilitada por el Ministerio de Transporte para la prestación'), 0, '1', 'FJ');



/*LINE 6*/

$pdf->Cell2(184, 4, utf8_decode('del servicio público de transporte especial, según Resolución 005373 del 2002 y quien en adelante se llamará'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(5, 4, 'EL', 0, '1', 'J');


/*LINE 7*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(25, 4, 'CONTRATISTA,', 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(47, 4, 'hemos convenido en celebrar un', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(118, 4, utf8_decode('CONTRATO DE PRESTACIÓN DE SERVICIOS DE TRANSPORTE ESPECIAL'), 0, '1', 'FJ');


/*LINE 8*/
$pdf->Cell2(123, 4, utf8_decode('EN LA MODALIDAD DE TRANSPORTE PARA GRUPO ESPECÍFICO DE USUARIOS'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(67, 4, utf8_decode('que se regulará por las disposiciones del Código'), 0, '1', 'FJ');


/*LINE 9*/
$pdf->Cell2(190, 4, utf8_decode('Civil, Código de Comercio y démas establecidas por el Gobierno Nacional en la materia de transporte público especial, especialmente'), 0, '1', 'FJ');


/*LINE 10*/
$pdf->Cell(190, 4, utf8_decode('en el Decreto 431 de 2017 en particular por lo dispuesto en las siguientes:'), 0, '1', 'J');

$pdf->Ln(7);


/* #### CLAUSULAS #### */


/*LINE 10*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(190, 4, utf8_decode('CLÁUSULAS'), 0, '1', 'C');
$pdf->Ln(5);


/*LINE 11*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(61, 4, 'PRIMERA.- OBJETO: EL CONTRATISTA', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(29, 4, 'se compromete con', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(31, 4, 'EL CONTRATANTE', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(69, 4, 'a prestar el servicio de transporte en la modalidad', 0, '1', 'FJ');


/*LINE 12*/

$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(149, 4, utf8_decode('servicio especial de pasajeros, a los usuarios aquí relacionados e identificados, desde la ciudad de'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 7);
$CiudadOrigen = $ciudad->listarCiudadPorId($listarContratoOcasional[0]['origen']);
$pdf->Cell(40, 4, utf8_decode($CiudadOrigen[0]['ciudad']), 'B', 1, 'C');
$pdf->SetFont('Arial', '', 8);
$CiudadDestino = $ciudad->listarCiudadPorId($listarContratoOcasional[0]['destino']);
$pdf->Cell(12, 4, 'hasta', 0, '0', 'C');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(40, 4, utf8_decode($CiudadDestino[0]['ciudad']), 'B', 1, 'C');;

$pdf->Ln(5);


/*LINE 17*/

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 4, utf8_decode('SEGUNDA.- PASAJEROS:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(150, 4, utf8_decode('El servicio de transporte se prestará a los siguientes usuarios: '), 0, '1', 'J');
$pdf->Ln(5);


/*TABLA USUARIOS*/

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95, 7, 'NOMBRE', 1, '0', 'C');
$pdf->Cell(95, 7, utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 1, '1', 'C');
$listarUsuariosPorContrato = $contratoOcasional->listarUsuariosPorContratosOcasiones($listarContratoOcasional[0]['id_contrato_ocasional']);
foreach ($listarUsuariosPorContrato as $luc) {
	$pdf->SetFont('Arial', '', 7);
	$pdf->Cell(95, 5, strtr(strtoupper(utf8_decode($luc['nombre_usuario'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 1, '0', 'C');
	$pdf->Cell(95, 5, strtr(strtoupper(utf8_decode($luc['numero_documento'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 1, '1', 'C');
}


$pdf->Ln(7);


/*LINE 18*/

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(40, 4, utf8_decode('TERCERA.- VEHÍCULOS:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(52, 4, 'Para los fines del presente contrato', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(30, 4, 'EL CONTRATISTA', 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(42, 4, utf8_decode('tendrá dispuestos a favor del'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(27, 4, 'CONTRATANTE ,', 0, '1', 'FJ');


/*LINE 19*/

$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(190, 4, utf8_decode('los vehículos requeridos los cuales deberán estar en óptimas condiciones de segurida, servicio y cumpliendo las normas del Ministerio'), 0, '1', 'FJ');


/*LINE 20*/

$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, 'de Transporte en lo que corresponde a este tipo de servicio.', 0, '1', 'J');
$pdf->Ln(5);


/*LINE 21*/

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(24, 4, utf8_decode('PARÁGRAFO.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, utf8_decode('Para el desarrollo de este servicio se asignarán el-los vehículo(s) identificado(s):'), 0, '1', 'J');
$pdf->Ln(7);


/* #################################################################### */
/* #################################################################### */


/* TABLA VEHICULOS*/



$listarVehiculos = $vehiculo->listarPorId($listarContratoOcasional[0]['id_vehiculo']);
$listarTipoVehiculo = $tipoVehiculo->listarPorId($listarVehiculos[0]['id_tipo_vehiculo']);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(38, 5, 'Placa', 1,'0','C');
$pdf->Cell(38, 5, 'Marca', 1,'0','C');
$pdf->Cell(38, 5, 'Modelo', 1,'0','C');
$pdf->Cell(38, 5, 'Cantidad de Pasajeros', 1,'0','C');
$pdf->Cell(38, 5, 'Tipo Vehiculo', 1,'1','C');
foreach ($listarVehiculos as $lv) {
	$pdf->SetFont('Arial','',7);
	$pdf->Cell(38, 5, utf8_encode($lv['placa']), 1,'0','C');
	$pdf->Cell(38, 5, utf8_encode($lv['marca']), 1,'0','C');
	$pdf->Cell(38, 5, utf8_encode($lv['modelo']), 1,'0','C');
	$pdf->Cell(38, 5, utf8_encode($lv['cant_pasajeros']), 1,'0','C');
	$pdf->Cell(38, 5, utf8_encode($listarTipoVehiculo[0]['nombre_tipo_vehiculo']), 1,'1','C');
}


$pdf->Ln(5);


/*LINE 22*/

$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 4, 'vehiculo(s) automor(es) que se encuentra(n) debidamente homologado(s) por las autoridades respectivas, para prestar el servicio de', 0, '1', 'FJ');


/*LINE 23*/
$pdf->Cell2(190, 4, 'transporte especial y que cumple(n) todas las disposiciones legales que rigen al momento de la firma del presente contrato.', 0, '1', 'FJ');


/*LINE 24*/
$pdf->Cell2(190, 4, utf8_decode('EL CONTRATISTA podrá reemplazar el vehiculo en cualquier tiempo, siempre que este cuente con caracteristicas similaras a las'), 0, '1', 'FJ');


/*LINE 25*/
$pdf->Cell(190, 4, 'contratadas, y que cumpla con las mismas condiciones que por el presente documento se contratan.', 0, '1', 'J');
$pdf->Ln(7);


/*LINE 26*/

$fecha_inicial_contrato = explode("-", $listarContratoOcasional[0]['fecha_inicial_contrato_ocasional']);
$año_fecha_inicial_contrato = $fecha_inicial_contrato[0];
$mes_fecha_inicial_contrato = $fecha_inicial_contrato[1];
$dia_fecha_inicial_contrato = $fecha_inicial_contrato[2]; 


$convertirDiaFechaInicial = convertir($dia_fecha_inicial_contrato);
$convertirMesFechaInicial = mes($mes_fecha_inicial_contrato);
$convertirAñoFechaInicial = convertir($año_fecha_inicial_contrato);


$fecha_final_contrato = explode("-", $listarContratoOcasional[0]['fecha_final_contrato_ocasional']);
$año_fecha_final_contrato = $fecha_final_contrato[0];
$mes_fecha_final_contrato = $fecha_final_contrato[1];
$dia_fecha_final_contrato = $fecha_final_contrato[2]; 


$convertirDiaFechaFinal = convertir($dia_fecha_final_contrato);
$convertirMesFechaFinal = mes($mes_fecha_final_contrato);
$convertirAñoFechaFinal = convertir($año_fecha_final_contrato);


$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(53, 4, utf8_decode('CUARTA.- PLAZO DE EJECUCIÓN'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(60, 4, utf8_decode('La duración del presente contrato será del'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(67, 4, $convertirDiaFechaInicial . ' ' . '(' . $dia_fecha_inicial_contrato . ')' . ' de ' . $convertirMesFechaInicial . ' (' .$mes_fecha_inicial_contrato . ') ' . ' del ' . $año_fecha_inicial_contrato , 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(10, 4, 'hasta', 0, '1', 'J');


/*LINE 27*/
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(67, 4, $convertirDiaFechaFinal . ' ' . '(' . $dia_fecha_final_contrato . ')' . ' de ' . $convertirMesFechaFinal . ' (' .$mes_fecha_final_contrato . ') ' . ' del ' . $año_fecha_final_contrato . '.', 'B', 1, 'C');
$pdf->Ln(10);


/*LINE 28*/

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(24, 4, utf8_decode('PARÁGRAFO.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, utf8_decode('El termino podrá ser ampliado previo acuerdo entre las partes, mediante el otro sí correspondiente.'), 0, '1', 'J');
$pdf->Ln(7);





/*LINE 29*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(105, 4, 'QUINTA.- OBLIGACIONES DEL CONTRATANTE: EL CONTRATANTE:', 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(85, 4, utf8_decode('Adquiere por razón del presente las siguientes obligaciones'), 0, '1', 'FJ');



/*30*/
$pdf->Cell2(90, 4, 'especiales, sin prejuicio de las generales completadas en la ley:', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(6, 4, 'A.-', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(94, 4, utf8_decode('Pagar el precio convenido para la ejecución del presente contrato.'), 0, '1', 'FJ');



/*31*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(6, 4, 'B.-', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(184, 4, 'Suministrar oportunamente las novedades que surjan en el desarrollo del contrato y que alteren o puedan alterar de manera', 0, '1', 'FJ');



/*32*/
$pdf->Cell2(90, 4, utf8_decode('general o específica la marcha normal de actividades y horarios.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(6, 4, 'C.-', 0, '', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(94, 4, 'Hacer las sugerencias que considere convenientes para la normal', 0, '1', 'FJ');


/*32*/
$pdf->Cell(190, 4, 'y buena marcha del contrato.', 0, '1', 'J');
$pdf->Ln(5);



/* ############################################### */




/*33*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell2(105, 4, 'SEXTA.- OBLIGACIONES DEL CONTRATISTA: EL CONTRATISTA:', 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(85, 4, utf8_decode('Adquiere por razón del presente las siguientes obligaciones'), 0, '1', 'FJ');



/*34*/
$pdf->Cell2(90, 4, 'especiales, sin prejuicio de las generales completadas en la ley:', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(6, 4, 'A.-', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(94, 4, 'Disponer de los vehiculos determinados y contratados para la', 0, '1', 'FJ');



/*35*/
$pdf->Cell2(142, 4, utf8_decode('prestación del servicio con la documentación al dia del vehiculo y conductor que prestara el servicio.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(5, 4, 'B.-', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(43, 4, 'Todas aquellas relacionadas', 0, '1', 'FJ');


/*36*/
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(190, 4, 'con el objeto del contrato.', 0, '1', 'J');
$pdf->Ln(5);


/*37*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(62, 4, 'SEPTIMA.- VALOR Y FORMA DE PAGO:', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(102, 4, 'Para todos los efectos legales el valor del presente contrato asciende a', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(25, 4, '$' . '' . number_format($listarContratoOcasional[0]['valor_contrato'], 0), 'B', 1, 'C');



/*38*/
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(72, 4, 'PESOS MONEDA LEGAL ($ M/L). EL CONTRATANTE', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell2(28, 4, 'se obliga a pagar al', 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(21, 4, 'CONTRATISTA', 0, '0', 'J');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(55, 4, 'el valor del contrato.', 0, '1', 'J');
$pdf->Ln(5);



/*39*/
$fecha_creacion_contrato = explode("-", $listarContratoOcasional[0]['fecha_creacion']);
$año_fecha_creacion_contrato = $fecha_creacion_contrato[0];
$mes_fecha_creacion_contrato = $fecha_creacion_contrato[1];
$dia_fecha_creacion_contrato = $fecha_creacion_contrato[2]; 


$convertirDiaFechaCreacionContrato = convertir($dia_fecha_creacion_contrato);
$convertirMesFechaCreacionContrato = mes($mes_fecha_creacion_contrato);
$convertirAñoFechaCreacionContrato = convertir($año_fecha_creacion_contrato);


$lstarCiudadDelContrato = $ciudad->listarCiudadPorId($listarContratoOcasional[0]['id_ciudad']);
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(119, 4, utf8_decode('Para constancia de lo aquí pactado se firma de dos (2) ejemplares iguales en la ciudad de'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(30, 4, $lstarCiudadDelContrato[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(8, 4, 'a los', 0, '0', 'J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(33, 4,  $convertirDiaFechaCreacionContrato . ' (' . $dia_fecha_creacion_contrato . ') ', 'B', 1, 'C');



/*40*/
$pdf->SetFont('Arial','',8);
$pdf->Cell(25, 4, utf8_decode('días del mes de'), 0, '0', 'J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(27, 4, $convertirMesFechaCreacionContrato . ' (' . $mes_fecha_creacion_contrato . ') ', 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(5, 4, 'del', 0, '0', 'J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(45, 4, $convertirAñoFechaCreacionContrato . ' (' . $año_fecha_creacion_contrato . ') ', 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(1, 4, '.', 0, '1', 'J');
$pdf->Ln(50);


/*FIRMAS DE LAS PARTES*/

$pdf->SetFont('Arial','B',9);

$pdf->Cell(95, 4, 'EL CONTRATANTE', 0, '0', 'C');

$pdf->Cell(95, 4, 'EL CONTRATISTA', 0, '0', 'C');

$pdf->Ln(28);



$pdf->SetFont('Arial', '', 8);

$pdf->Cell(95, 4, utf8_decode($listarClienteContrato[0]['representante_legalC']), 0, '0', 'C');



$pdf->Cell(95, 4,utf8_decode($listarEmpresaContrato[0]['representante_legal']), 0, '1', 'C');

$pdf->Ln(1);



$pdf->Cell(95, 4, strtr(strtoupper( utf8_decode('C.C. N° ') . $listarClienteContrato[0]['numero_documentoC'] . ' de ' . $listarLugarExpedicionC[0]['ciudad']) , "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, '0', 'C');



$pdf->Cell(95, 4, strtr(strtoupper(utf8_decode('C.C. N° ') . $listarEmpresaContrato[0]['numero_documento'] . ' de ' . $listarLugarExpedicionEmpresa[0]['ciudad']) , "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, '1', 'C');

$pdf->Ln(1);



$pdf->Cell(95, 4, '', 0, '0', 'C');



$pdf->Cell(95, 4, utf8_decode($listarEmpresaContrato[0]['nombre_empresa']), 0, '1', 'C');

$pdf->Ln(1);



$pdf->Cell(95, 4, '', 0, '0', 'C');



$pdf->Cell(95, 4, 'REPRESENTANTE LEGAL', 0, '1', 'C');



$pdf->Cell(95, 4, '', 0, '0', 'C');



$pdf->Cell(95, 4, 'NIT ' . $listarEmpresaContrato[0]['nit_empresa'], 0, '1', 'C');

$pdf->Ln(1);



$pdf->Ln(3);

$pdf->Output();

//ob_end_flush();

 ?>

