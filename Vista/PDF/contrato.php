<?php 
require("../../Resources/fpdf/fpdf.php");
require_once("../../Modelo/Contrato.php");
require_once("../../Modelo/Ciudad.php");
require_once("../../Modelo/Cliente.php");
require_once("../../Modelo/EmpresaEnt.php");
require_once("../../Modelo/General.php");
require_once("../../Modelo/Vehiculo-Contrato.php");
require_once("../../Modelo/TipoVehiculo.php");


$id_contrato = $_GET['id_contrato'];

$contrato = new Contrato();
$listarContrato = $contrato->listarId($id_contrato);

$cliente = new Cliente();
$empresa = new Empresa();


$id_cliente = $listarContrato[0]['id_cliente'];
$datosCliente = $cliente->cliente_ID($id_cliente);

$id_empresa = $listarContrato[0]['id_empresa'];
$datosEmpresa = $empresa->listarPorId($id_empresa);

$ciudad = new Ciudad();
$datosCiudadCliente = $ciudad->listarCiudadPorId($datosCliente[0]['id_ciudad']);
$datosCiudadEmpresa = $ciudad->listarCiudadPorId($datosEmpresa[0]['id_ciudad']);

$vehiculoContrato = new Vehiculo_Contrato();

$tipoVehiculo = new TipoVehiculo();
/**
 * 
 */
class PDF extends FPDF
{
 
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

$pdf = new PDF('P','mm','A4');
$pdf->AddPage();
$pdf->AliasNbPages();

    /*TITULO*/
    $pdf->SetFont('Arial','B',10);

    $pdf->Cell(30, 4, utf8_decode(''), 0,'0','C');
    $pdf->Cell(26, 4, utf8_decode('CONTRATO N°'), 0,'0','C');
    $pdf->Cell(16, 4, str_pad($listarContrato[0]['id_contrato'], 6, '0', STR_PAD_LEFT), 0,'0','C');
    /*$pdf->Cell(16, 3, '', 'B', 0, '');
    */$pdf->Cell(88, 4, utf8_decode('DE PRESTACIÓN DE SERVICIOS DE TRANSPORTE'), 0,'0','C');
    $pdf->Cell(30, 4, utf8_decode(''), 0,'1','C');


$pdf->Cell(17, 4, utf8_decode(''), 0,'0','C');
$pdf->Cell(65, 4, utf8_decode('EMPRESARIAL CELEBRADO ENTRE'), 0,'0','C');
$pdf->Cell(85, 4, utf8_decode($datosEmpresa[0]['nombre_empresa']), 'B', 0, 'C');
$pdf->Cell(5, 4, utf8_decode('Y'), 0,'0','C');
$pdf->Cell(17, 4, utf8_decode(''), 0,'1','C');


$pdf->Cell(15, 4, utf8_decode(''), 0,'0','C');
$pdf->Cell(160, 4,  utf8_decode($datosCliente[0]['razon_social'] . '.'), 'B',  0, 'C');
$pdf->Cell(15, 4, utf8_decode(''), 0,'0','C');
$pdf->Ln(12);


/* ##############################################  PG1*/

/*LINE 1*/
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(50, 4, utf8_decode('Entre los suscritos, de una parte'), 0,'0','FJ');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(70, 4,  utf8_decode($datosCliente[0]['representante_legalC']), 'B', 0, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell2(70, 4, utf8_decode(', mayor de edad, identificado con la cédula de'), 0,'1','FJ');

/*LINES 2*/

$pdf->Cell2(30, 4, utf8_decode('ciudadanía número'), 0,'0','FJ');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(30, 4, $datosCliente[0]['numero_documentoC'], 'B', 0, 'C');
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(45, 4, utf8_decode(', residenciado y domiciliado en'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 9);
$listarCiudadRLCliente = $ciudad->listarCiudadPorId($datosCliente[0]['ciudad_residencia_rl']);

$pdf->Cell(45, 4, $listarCiudadRLCliente[0]['ciudad'], 'B', 0, 'C');

$pdf->SetFont('Arial','', 9);
$pdf->Cell2(41, 4, utf8_decode(', quien obra en calidad de '), 0,'1','FJ');

/*LINE 3*/

$pdf->Cell2(50, 4, utf8_decode('Representante Legal y Gerente de'), 0,'0','FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(139, 4, utf8_decode($datosCliente[0]['razon_social']), 'B', 1, 'C');

/*LINE 4*/
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(107, 4, Utf8_decode('sociedad debidamente constituida, con domicilio principal en la ciudad de'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(45, 4, $datosCiudadCliente[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(37, 4, utf8_decode('identificada con el NIT:'), 0,'1','FJ');


/*LINE 5*/
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(32, 4, $datosCliente[0]['nit_cliente'], 'B', 0, 'C');
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(105,4, utf8_decode('quien en adelante y para los efectos del presente contrato se llamará'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 9);
$pdf->Cell2(33, 4, utf8_decode('EL CONTRATANTE'), 0,'0','FJ');
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(20, 4, utf8_decode('y por la otra'), 0,'1','FJ');

/*LINE 6*/
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(55, 4, utf8_decode($datosEmpresa[0]['representante_legal']), 'B', 0, 'C');
$pdf->SetFont('Arial','', 9);
$pdf->Cell2(100, 4, utf8_decode('mayor de edad, identificado con la cédula de ciudadanía número'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 9);
$pdf->Cell(29, 4, $datosEmpresa[0]['numero_documento'], 'B', 0, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(2, 4, 'de', 0, '1', 'J');

/*LINE 7*/
$pdf->SetFont('Arial', 'B', 9);
$listarCiudadLEEmpresa = $ciudad->listarCiudadPorId($datosEmpresa[0]['lugar_expedicion']);

$pdf->Cell(33, 4, $listarCiudadLEEmpresa[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(45, 4, utf8_decode('residenciado y domiciliado en'), 0, '0', 'FJ');

$pdf->SetFont('Arial', 'B', 9);
$listarCiudadRLEmpresa = $ciudad->listarCiudadPorId($datosEmpresa[0]['ciudad_residencia']);

 $pdf->Cell(27, 4, $listarCiudadRLEmpresa[0]['ciudad'], 'B', 0, 'C');


$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(85, 4, utf8_decode('quien obra en calidad de Representante Legal y Gerente de'), 0, '1', 'FJ');

/*LINE 7*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 4, utf8_decode($datosEmpresa[0]['nombre_empresa']), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(80, 4, utf8_decode('persona jurídica con domicilio principal en la ciudad de'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(29, 4, $datosCiudadEmpresa[0]['ciudad'], 'B', 1, 'C');

/*LINE 8*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 4, utf8_decode('identificada con Nit: '), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 4, $datosEmpresa[0]['nit_empresa'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(130, 4, utf8_decode('Habilitada por el Ministerio de Transporte para la prestación del servicio público de transporte'), 0, '1', 'FJ');


/*LINE 9*/
$pdf->Cell(58, 4, utf8_decode('especial, y quien en adelante se llamará'), 0, '0', 'J');	
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(31, 4, utf8_decode('EL CONTRATISTA,'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(48, 4, utf8_decode('hemos convenido en celebrar un'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(53, 4, utf8_decode('CONTRATO DE PRESTACIÓN DE'), 0, '1', 'FJ');


/*LINE 10*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(73, 4, utf8_decode('SERVICIOS DE TRANSPORTE EMPRESARIAL,'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(117, 4, utf8_decode('que se regulará por las disposiciones del Código Civil, Código de Comercio y demás'), 0, '1', 'FJ');

/*LINE 11*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('establecidas por el Gobierno Nacional en la materia de transporte público especial, especialmente en el Decreto 1079 y 431 de 2017 y'), 0, '1', 'FJ');

/*LINE 12*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(190, 4, utf8_decode('en particular por lo dispuesto en las siguientes:'), 0, '1', 'J');
$pdf->Ln(7);

/* #### CLAUSULAS #### */

/*LINE 13*/
$pdf->SetFont('Arial', 'BU', 9);
$pdf->Cell(190, 4, utf8_decode('CLÁUSULAS'), 0, '1', 'C');
$pdf->Ln(5);

/*LINE 12*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(61, 4, utf8_decode('PRIMERA.- OBJETO: EL CONTRATISTA'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(29, 4, utf8_decode('se compromete con'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(31, 4, utf8_decode('EL CONTRATANTE'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(69, 4, utf8_decode('a prestar el servicio de transporte en la modalidad'), 0, '1', 'FJ');

/*LINE 14*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(150, 4, utf8_decode('servicio especial de pasajeros, a los funcionarios, contratistas, clientes, visitantes y empleados de la empresa'), 0, '0', 'FJ');

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, utf8_decode('CONTRATANTE,'), 0, '0', 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(15, 4, utf8_decode('desde su'), 0, '1', 'FJ');


/*LINE 15*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(182, 4, utf8_decode('lugar de residencia o habitación hacia las instalaciones de la empresa y viceversa, igualmente hacia el sitio que le señale'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(8, 4, utf8_decode('  EL'), 0, '1', 'J');


/*LINE 16*/

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, utf8_decode('CONTRATANTE'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(32, 4, utf8_decode('dentro de la ciudad de'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);

$listarCiudadContrato = $ciudad->listarCiudadPorId($listarContrato[0]['id_ciudad']);


$pdf->Cell(40, 4, $listarCiudadContrato[0]['ciudad'], 'B', 0, 'C');
$pdf->Cell(32, 4, '.', 0, '1', 'J');
$pdf->Ln(5);

/*LINE 17*/

$pdf->Cell(40, 4, utf8_decode('SEGUNDA.- VEHÍCULOS:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(51, 4, utf8_decode('Para los fines del presente contrato'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(29, 4, utf8_decode('EL CONTRATISTA'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(44, 4, utf8_decode('tendrá dispuestos a favor del'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(25, 4, utf8_decode('CONTRATANTE'), 0, '1', 'J');


/*LINE 18*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('los vehículos requeridos los cuales deberán estar en óptimas condiciones de seguridad, servicio
y cumpliendo con las normas del'), 0, '1', 'FJ');

/*LINE 19*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(190, 4, utf8_decode('Ministerio de Transporte en lo que corresponde a este tipo de servicio.'), 0, '1', 'J');
$pdf->Ln(5);


/*LINE 20*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(24, 4, utf8_decode('PARÁGRAFO.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(138, 4, utf8_decode('Para el desarrollo de este servicio se asignarán el-los vehículo(s) identificado(s) con la(s) placa(s):'), 0, '1', 'FJ');

$pdf->Ln(5);
/*######*/
/*TABLA*/
/*######*/

$listarVehiculos = $vehiculoContrato->listarPorContrato($listarContrato[0]['id_contrato']);

$pdf->SetFont('Arial','B',9);
$pdf->Cell(38, 5, 'Placa', 1,'0','C');
$pdf->Cell(38, 5, 'Marca', 1,'0','C');
$pdf->Cell(38, 5, 'Modelo', 1,'0','C');
$pdf->Cell(38, 5, 'Cantidad de Pasajeros', 1,'0','C');
$pdf->Cell(38, 5, 'Tipo Vehiculo', 1,'1','C');

foreach ($listarVehiculos as $lv) {
    $listarTipoVehiculo = $tipoVehiculo->listarPorId($lv['id_tipo_vehiculo']); 

    $pdf->SetFont('Arial','',9);
    $pdf->Cell(38, 5, utf8_decode($lv['placa']), 1,'0','C');
    $pdf->Cell(38, 5, utf8_decode($lv['marca']), 1,'0','C');
    $pdf->Cell(38, 5, utf8_decode($lv['modelo']), 1,'0','C');
    $pdf->Cell(38, 5, utf8_decode($lv['cant_pasajeros']), 1,'0','C');
    foreach ($listarTipoVehiculo as $ltv) {
        $pdf->Cell(38, 5, utf8_decode($ltv['nombre_tipo_vehiculo']), 1,'1','C');
    }
}

$pdf->Ln(5);

/*LINE 21*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('vehículo(s) automotor(es) que se encuentra(n) debidamente homologado(s) por las autoridades respectivas, para prestar el servicio'), 0, '1', 'FJ');

/*LINE 22*/
$pdf->Cell2(190, 4, utf8_decode('de transporte especial y que cumple(n) todas las disposiciones legales que rigen al momento de la firma del presente contrato.'), 0, '1', 'FJ');


/*LINE 23*/
$pdf->Cell2(190, 4, utf8_decode('El CONTRATISTA podrá reemplazar el vehículo en cualquier tiempo, siempre que este cuente con características similares a las'), 0, '1', 'FJ');

/*LINE 23*/
$pdf->Cell(190, 4, utf8_decode('contratadas, y que cumpla con las mismas condiciones que por el presente documento se contratan.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 24*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(56, 4, utf8_decode('TERCERA.- PLAZO DE EJECUCIÓN:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(59, 4, utf8_decode('La duración del presente contrato será del'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(22, 4, $listarContrato[0]['fecha_inicial_contrato'], 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(5, 4, utf8_decode('al'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(22, 4, $listarContrato[0]['fecha_final_contrato'], 'B', 1, 'C');
$pdf->Ln(5);

/*LINE 25*/
$pdf->Cell(25, 4, utf8_decode('PARÁGRAFO.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(165, 4, utf8_decode('El término podrá ser ampliado previo acuerdo entre las partes, mediante el otro sí
correspondiente.'), 0, '1', '	J');
$pdf->Ln(5);

/*LINE 26*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(105, 4, utf8_decode('CUARTA.- OBLIGACIONES DEL CONTRATANTE: EL CONTRATANTE'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(85, 4, utf8_decode('adquiere por razón del presente las
siguientes obligaciones '), 0, '1', 'FJ');


/*LINE 27*/
$pdf->Cell2(92, 4, utf8_decode('especiales, sin perjuicio de las generales contempladas en la ley:'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('A.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(93, 4, utf8_decode('Pagar el precio convenido para la ejecución del presente contrato.'), 0, '1', 'FJ');

/*LINE 28*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('B.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(185, 4, utf8_decode('Suministrar oportunamente las novedades que surjan en el desarrollo del contrato y que alteren o puedan alterar de manera general'), 0, '1', 'FJ');

/*LINE 29*/
$pdf->Cell(80, 4, utf8_decode('o específica la marcha normal de actividades y horarios.'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('C.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(105, 4, utf8_decode('Hacer las sugerencias que considere convenientes para la normal y buena'), 0, '1', 'FJ');


/*LINE 30*/
$pdf->Cell(30, 4, utf8_decode('marcha del contrato.'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('D.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(40, 4, utf8_decode('Suministrar al conductor el'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 4, utf8_decode('PLAN DE RUTAS. E.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 4, utf8_decode('Prestar todo el apoyo que requiera'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(32, 4, utf8_decode('EL CONTRATISTA,'), 0, '1', 'FJ');


/*LINE 31*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(130, 4, utf8_decode('con el fin de obtener del mismo los mejores resultados para el cumplimiento del contrato.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('F.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(55, 4, utf8_decode('Realizar la supervisión respecto de las '), 0, '1', 'FJ');

/*LINE 32*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(104, 4, utf8_decode('condiciones de ejecución y cumplimiento del contrato celebrado con'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(36, 4, utf8_decode('EL CONTRATISTA. G.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(50, 4, utf8_decode('Garantizar el uso adecuado del'), 0, '1', 'FJ');

/*LINE 33*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(50, 4, utf8_decode('vehículo y su debida conservación'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('H.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(135, 4, utf8_decode('No exceder del cupo máximo de pasajeros autorizados por vehículo por ningún motivo'), 0, '1', 'FJ');

/*LINE 34*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('I.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(185, 4, utf8_decode('Abstenerse de modificar las rutas acordadas por las partes a no ser que por disposición de la autoridad policial disponga otra cosa a'), 0, '1', 'FJ');

/*LINE 35*/
$pdf->Cell2(78, 4, utf8_decode('causa de algún accidente de tránsito, arreglo de vías etc'),0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('J.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(107, 4, utf8_decode('No utilizar el vehículo para actividades ilícitas y en general para cualquier tipo'), 0, '1', 'FJ');

/*LINE 36*/
$pdf->Cell2(125, 4, utf8_decode('de actividad que vaya en contra de la ley o que se encuentre fuera del objeto del contrato'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('K.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(60, 4, utf8_decode('Utilizar el servicio exclusivamente para el'), 0, '1', 'FJ');


/*LINE 37*/
$pdf->Cell2(50, 4, utf8_decode('personal vinculado a la empresa'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('L.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(135, 4, utf8_decode('Pagar al CONTRATISTA todas las sumas resultantes de sanciones o comparendos realizados,'), 0, '1', 'FJ');

/*LINE 38*/
$pdf->Cell2(140, 4, utf8_decode('por el incumplimiento de las normas en materia de tránsito por parte de los ocupantes del vehículo'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('M.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(45, 4, utf8_decode('Pagar las reparaciones que se '), 0, '1', 'FJ');


/*LINE 39*/
$pdf->Cell2(130, 4, utf8_decode('deban realizar al vehículo con ocasión de un uso diferente al designado o por su uso indebido'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('N.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(55, 4, utf8_decode('instruir a los usuarios acerca de las'), 0, '1', 'FJ');

/*LINE 40*/
$pdf->Cell2(190, 4, utf8_decode('condiciones de seguridad y convivencia, a observar durante la fase de transporte de acuerdo con las normas aplicables para el efecto'), 0, '1', 'FJ');


/*LINE 41*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('O.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(118, 4, utf8_decode('Dar un trato respetuoso al conductor que tenga a su cargo la prestación del servicio'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('P.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(62, 4, utf8_decode('Todas aquellas relacionadas con el objeto'), 0, '1', 'FJ');

/*LINE 40*/
$pdf->Cell(190, 4, utf8_decode('del contrato.'), 0, '1', 'J');
$pdf->Ln(10);


/*  ###################################################### PG 2 */


/*LINE 1*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(101, 4, utf8_decode('QUINTA.- OBLIGACIONES DEL CONTRATISTA: EL CONTRATISTA'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(89, 4, utf8_decode('adquiere por razón del presente las siguientes obligaciones'), 0, '1', 'FJ');


/*LINE 2*/
$pdf->Cell2(92, 4, utf8_decode('especiales, sin perjuicio de las generales contempladas en la ley:'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('A.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(93, 4, utf8_decode('Disponer de los vehículos determinados y contratados para la'), 0, '1', 'FJ');


/*LINE 3*/
$pdf->Cell2(190, 4, utf8_decode('prestación del servicio con la documentación al día del vehículo y conductor que prestará el servicio, para tales efectos garantiza que'), 0, '1', 'FJ');

/*LINE 4*/
$pdf->Cell2(117, 4, utf8_decode('los medios utilizados como transporte cuenten con los siguientes documentos al día:'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('I.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(68, 4, utf8_decode('Seguro obligatorio contra accidente de tránsito'), 0, '1', 'FJ');

/*LINE 5*/
$pdf->Cell2(15, 4, utf8_decode('- SOAT -.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('II.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(48, 4, utf8_decode('Revisión tecno mecánica vigente.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('III.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(31, 4, utf8_decode('Extracto de Contrato'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('IV.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(43, 4, utf8_decode('Tarjeta de operación vigente.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('V.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(31, 4, utf8_decode('Tarjeta de propiedad'), 0, '1', 'FJ');


/*LINE 6*/
$pdf->Cell2(20, 4, utf8_decode('del vehículo.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('VI.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(64, 4, utf8_decode('Póliza de responsabilidad civil contractual.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(7, 4, utf8_decode('VII.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(73, 4, utf8_decode('Póliza de responsabilidad civil extracontractual, y'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('VIII.'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(14, 4, utf8_decode('- Demás'), 0, '1', 'FJ');


/*LINE 7*/
$pdf->Cell2(76, 4, utf8_decode('documentos exigidos para la prestación del servicio.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode(' B.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(60, 4, utf8_decode('Mantener comunicación permanente con'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(31, 4, utf8_decode('EL CONTRATANTE'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(17, 4, utf8_decode('a efectos'), 0, '1', 'FJ');


/*LINE 8*/
$pdf->Cell2(122, 4, utf8_decode('de informar todas las novedades ocurridas y relacionadas con la prestación del servicio.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(5, 4, utf8_decode(' C.-'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(63, 4, utf8_decode('Garantizar la prestación del servicio en los'), 0, '1', 'FJ');

/*LINE 9*/
$pdf->Cell2(190, 4, utf8_decode('términos convenidos, evitando sobre cupos, y la presencia de personas ajenas a los funcionarios, visitantes, contratistas y/o empleados'), 0, '1', 'FJ');

/*LINE 10*/
$pdf->Cell(5, 4, utf8_decode('del'), 0, '', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(32, 4, utf8_decode('CONTRATANTE. D.-'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(153, 4, utf8_decode('Proporcionar al CONTRATANTE un vehículo de remplazo de las mismas características del vehículo contratado'), 0, '1', 'FJ');


/*LINE 11*/
$pdf->Cell2(190, 4, utf8_decode('por todo el tiempo en que el vehículo contratado se encuentre en mantenimiento o fuera de uso por cualquier razón, siempre que éste'), 0, '1', 'FJ');

/*LINE 12*/
$pdf->Cell(78, 4, utf8_decode('se realice durante la operación de el CONTRATANTE.'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('E.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(107, 4, utf8_decode('Informar a los empleados y/o funcionarios las normas de seguridad para'), 0, '1', 'FJ');


/*LINE 13*/
$pdf->Cell(54, 4, utf8_decode('llevar a cabo el servicio de transporte'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('F.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(131, 4, utf8_decode('Proveer a los vehículos destinados al servicio de un sistema de comunicaciones bidireccional'), 0, '1', 'FJ');


/*LINE 14*/
$pdf->Cell2(74, 4, utf8_decode('que permita mantener contacto permanente entre'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(68, 4, utf8_decode('EL CONTRATISTA y EL CONTRATANTE G.-'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(48, 4, utf8_decode('Disponer de un coordinador de'), 0, '1', 'FJ');


/*LINE 15*/
$pdf->Cell2(85, 4, utf8_decode('contrato, quien estará a cargo del cumplimiento del mismo.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('H.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 4, utf8_decode('Todas aquellas relacionadas con el objeto del contrato.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 16*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(58, 4, utf8_decode('SEXTA.- VALOR Y FORMA DE PAGO:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(132, 4, utf8_decode('Para todos los efectos legales y fiscales, el valor del presente contrato es indeterminado pero'), 0, '1', 'FJ');

/*LINE 17*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(135, 4, utf8_decode('indeterminado pero determinable de acuerdo a la cantidad de servicios prestados durante el mes.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 4, utf8_decode('EL CONTRATANTE'), 0, '0', 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(25, 4, utf8_decode('se obliga a pagar'), 0, '1', 'FJ');

/*LINE 18*/
$pdf->Cell(4, 4, utf8_decode('al'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(24, 4, utf8_decode('CONTRATISTA'), 0, '0', 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(63, 4, utf8_decode('el valor del contrato de la siguiente manera:'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(5, 4, utf8_decode('A)'), 0, '0', 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(94, 4, utf8_decode('mediante transferencia bancaria a la cuenta No. XXXXXXXX'), 0, '0', 'J');
$pdf->Ln(10);

/*LINE 19*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(87, 4, utf8_decode('SEPTIMA.- FORMAS DE TERMINACIÓN DEL CONTRATO:'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 4, utf8_decode('El presente contrato terminará por:'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('A.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(47, 4, utf8_decode('Ejecución absoluta de todas las'), 0, '1', 'FJ');


/*LINE 20*/
$pdf->Cell2(180, 4, utf8_decode('obligaciones a cargo de las partes, y de todas las actividades tendientes al debido
cumplimiento del objeto del presente contrato.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('B.-'), 0, '1', 'J');

/*LINE 21*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('En cualquier momento por cualquiera de LAS PARTES, previa notificación escrita por lo menos con ocho (8) días corrientes de antelación'), 0, '1', 'FJ');

/*LINE 22*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('a la fecha en que se pretende terminar el mismo, sin que esto de lugar al pago de alguna tipo de indemnización a favor de la otra parte.'), 0, '1', 'FJ');


/*LINE 23*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('C.-'), 0, '', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(184, 4, utf8_decode('En cualquier momento, por el incumplimiento total o parcial de alguna de las obligaciones a cargo de las partes, sin perjuicio'), 0, '1', 'FJ');


/*LINE 24*/
$pdf->Cell2(112, 4, utf8_decode('de las indemnizaciones que se llegaren a generar a favor de la parte cumplida.'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('D.-'), 0, '', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(54, 4, utf8_decode('Por mutuo acuerdo entre las partes.'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 4, utf8_decode('E.-'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(12, 4, utf8_decode('En los'), 0, '1', 'FJ');

/*LINE 25*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(190, 4, utf8_decode(' casos contemplados por la ley y el presente contrato.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 26*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(31, 4, utf8_decode('OCTAVA.- CESIÓN:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(159, 4, utf8_decode('El presente contrato no podrá ser cedido ni subcontratado total o parcialmente, asimismo los derechos obligaciones'), 0, '1', 'FJ');

/*LINE 27*/
$pdf->Cell(190, 4, utf8_decode('y acciones derivadas del mismo; sin el consentimiento previo, expreso y escrito de las partes.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 28*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(50, 4, utf8_decode('NOVENA.- CONFIDENCIALIDAD:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(140, 4, utf8_decode('Las partes se comprometen a guardar la reserva y confidencialidad respecto de cualquier tipo de'), 0, '1', 'FJ');

/*LINE 29*/
$pdf->Cell2(190, 4, utf8_decode('información de la contraparte en razón del desarrollo de su gestión. Dicha reserva se extenderá durante toda la vigencia del desarrollo de la'), 0, '1', 'FJ');

/*LINE 30*/
$pdf->Cell2(190, 4, utf8_decode('gestión y durante el tiempo que la información tenga el carácter de reservada y/o confidencial, de conformidad con las políticas'), 0, '1', 'FJ');

/*LINE 31*/
$pdf->Cell(190, 4, utf8_decode('que sobre el tema manejen las partes, sin importar que el contrato este o no vigente.'), 0, '1', 'J');
$pdf->Ln(3);

/*LINE 32*/
$pdf->Cell2(190, 4, utf8_decode('Además las partes convienen que toda la información que se conozca, intercambie, divulgue o por cualquier medio llegue a conocimiento'), 0, '1', 'FJ');

/*LINE 33*/
$pdf->Cell2(190, 4, utf8_decode('de la otra, será propiedad de la parte en la cual se originó, y no podrá ser utilizada por la otra parte en provecho propio o de terceros,'), 0, '1', 'FJ');

/*LINE 34*/
$pdf->Cell2(190, 4, utf8_decode('o con fines diferentes a la correcta ejecución de los contratos o convenios vigentes para la presentación de servicios suscritos entre'), 0, '1', 'FJ');

/*LINE 35*/
$pdf->Cell(190, 4, utf8_decode('las partes.'), 0, '1', 'J');
$pdf->Ln(3);

/*LINE 36*/
$pdf->Cell2(190, 4, utf8_decode('El incumplimiento de cualquiera de las partes del deber de reserva consagrado en la presente cláusula, constituye violación de secreto'), 0, '1', 'FJ');

/*LINE 37*/
$pdf->Cell2(190, 4, utf8_decode('y justa causa de terminación unilateral del contrato, y acarreará el pago de indemnizaciones por daños y perjuicios y las sanciones'), 0, '1', 'FJ');

/*LINE 38*/
$pdf->Cell(190, 4, utf8_decode('previstas en la ley a favor de la parte afectada.'), 0, '1', 'J');
$pdf->Ln(3);

/*LINE 39*/
$pdf->Cell2(190, 4, utf8_decode('Las partes reconocen expresamente a ésta cláusula mérito ejecutivo, y para su cobro bastará simplemente su presentación junto'), 0, '1', 'FJ');

/*LINE 40*/
$pdf->Cell2(190, 4, utf8_decode('con la afirmación de la parte afectada acerca de incumplimiento de la obligación, sin necesidad de que medie previamente'), 0, '1', 'FJ');

/*LINE 41*/
$pdf->Cell(190, 4, utf8_decode('requerimiento judicial o extrajudicial alguno.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 42*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(94, 4, utf8_decode('DÉCIMA.- NATURALEZA DEL CONTRATO: EL CONTRATISTA'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(96, 4, utf8_decode('actuará por su propia cuenta con absoluta autonomía y no estará'), 0, '1', 'FJ');

/*LINE 43*/
$pdf->Cell(53, 4, utf8_decode('sometido a subordinación laboral con'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(30, 4, utf8_decode('EL CONTRATANTE'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(107, 4, utf8_decode('y sus derechos se limitarán, de acuerdo con la naturaleza del contrato a exigir'), 0, '1', 'FJ');

/*LINE 44*/
$pdf->Cell(190, 4, utf8_decode('cumplimiento de las obligaciones y al pago de los montos establecidos como contraprestación del servicio contratado.'), 0, '1', 'J');
$pdf->Ln(5);


/*LINE 45*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(90, 4, utf8_decode('DÉCIMA PRIMERA.- AUSENCIA DE RELACIÓN LABORAL:'), 0, '0', 'FJ');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(100, 4, utf8_decode('Queda claramente entendido que no existirá subordinación alguna por'), 0, '1', 'FJ');

/*LINE 46*/
$pdf->Cell2(159, 4, utf8_decode('ser este un contrato de prestación de servicios, sin subordinación jurídica laboral, salario, ni servicio personal entre'), 0, '0', 'FJ');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell2(31, 4, utf8_decode('EL CONTRATANTE'), 0, '1', 'FJ');

/*LINE 47*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(3, 4, utf8_decode('y'), 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(29, 4, utf8_decode('EL CONTRATISTA'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(158, 4, utf8_decode('y las personas que éste designe para la ejecución del objeto del presente contrato.'), 0, '1', 'J');
/*$pdf->Ln(30);*/
$pdf->Ln(5);

/* ########################################### PG 3 */

/*LINE 1*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(80, 4, utf8_decode('DÉCIMA SEGUNDA.- CLAUSULA COMPROMISORIA.'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(110, 4, utf8_decode('Acuerdan ambas partes que toda controversia o diferencia relativa a este'), 0, '1', 'FJ');

/*LINE 2*/
$pdf->Cell2(190, 4, utf8_decode('contrato, a su ejecución y liquidación, se resolverá en primera instancia por arreglo directo y conciliatorio entre las partes dentro de los'), 0, '1', 'FJ');

/*LINE 3*/
$pdf->Cell2(190, 4, utf8_decode('quince (15) días calendario siguientes a la notificación de una parte a la otra del motivo de la disputa, plazos que podrán prorrogarse por'), 0, '1', 'FJ');

/*LINE 4*/
$pdf->Cell2(190, 4, utf8_decode('escrito de común acuerdo. En caso de declararse fracasada la conciliación entre las partes y que no exista ánimo conciliatorio o que se'), 0, '1', 'FJ');

/*LINE 5*/
$pdf->Cell(190, 4, utf8_decode('llegue a acuerdos parciales, cualquiera de las partes deberá acudir a la justicia ordinaria.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 6*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(105, 4, utf8_decode('DÉCIMA TERCERA.- LEY APLICABLE Y DOMICILIO CONTRACTUAL:'), 0, '', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(85, 4, utf8_decode('El presente contrato se regirá de acuerdo con las leyes de la'), 0, '1', 'FJ');

/*LINE 7*/
$pdf->Cell(190, 4, utf8_decode('de Colombia y el domicilio contractual para todos los efectos es la ciudad de Bogotá.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 8*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(60, 4, utf8_decode('DÉCIMA CUARTA.- NOTIFICACIONES:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(130, 4, utf8_decode('Serán recibidas por las partes en las siguientes direcciones:'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 9*/
$pdf->SetFont('ZapfDingBats', 'B', 9);
$pdf->Cell(7, 4, 'v', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 4, 'EL CONTRATANTE:', 0, '0', 'J');
$pdf->Cell(60, 4, $datosEmpresa[0]['direccion'], 'B', 0, 'C');
$pdf->Ln(8);

/*LINE 10*/
$pdf->SetFont('ZapfDingBats', 'B', 9);
$pdf->Cell(7, 4, 'v', 0, '0', 'J');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(31, 4, 'EL CONTRATISTA:', 0, '0', 'J');
$pdf->Cell(60, 4, $datosCliente[0]['direccionC'], 'B', 0, 'C');
$pdf->Ln(8);

/*LINE 11*/
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(190, 4, utf8_decode('En todo caso, las partes podrán modificar la dirección o direcciones designadas para su notificación, previa
información escrita dirigida'), 0, '1', 'FJ');

/*LINE 12*/
$pdf->Cell2(190, 4, utf8_decode('por lo menos con cinco (5) días hábiles de antelación al cambio de la dirección previamente designada, so pena de no poder alegar'), 0, '1', 'FJ');

/*LINE 13*/
$pdf->Cell(190, 4, utf8_decode('la indebida notificación.'), 0, '1', 'J');
$pdf->Ln(5);

/*LINE 14*/
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(86, 4, utf8_decode('DÉCIMA QUINTA.- ACUERDO INTEGRAL Y REFORMAS:'), 0, '0', 'J');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(104, 4, utf8_decode('El presente contrato y sus anexos constituyen el acuerdo integral que'), 0, '1', 'FJ');

/*LINE 15*/
$pdf->Cell2(190, 4, utf8_decode('vincula a las partes en relación con el objeto del mismo. En consecuencia el presente contrato deroga expresamente todos los acuerdos'), 0, '1', 'FJ');

/*LINE 16*/
$pdf->Cell2(190, 4, utf8_decode('anteriores verbales o escritos que tengan relación con el mismo. Cualquier modificación a los términos aquí contenidos deberá'), 0, '1', 'FJ');

/*LINE 17*/
$pdf->Cell(190, 4, utf8_decode('constar en documento escrito suscrito por las partes.'), 0, '1', 'J');
$pdf->Ln(5);


$fecha_creacion_contrato = explode("-", $listarContrato[0]['fecha_creacion_contrato']);

$año_fecha_creacion_contrato = $fecha_creacion_contrato[0];
$mes_fecha_creacion_contrato = $fecha_creacion_contrato[1];
$dia_fecha_creacion_contrato = $fecha_creacion_contrato[2];

$convertirDiaFechaCreacion = convertir($dia_fecha_creacion_contrato);
$convertirMesFechaCreacion = mes($mes_fecha_creacion_contrato);
$convertirAñoFechaCreacion = convertir($año_fecha_creacion_contrato);


/*LINE 18*/
$pdf->Cell2(133, 4, utf8_decode('Para constancia de lo aquí pactado se firma en dos (2) ejemplares iguales en la ciudad de'), 0, '0', 'FJ');
$pdf->SetFont('Arial','B',9);

$listarCiudadContrato = $ciudad->listarCiudadPorId($listarContrato[0]['id_ciudad']);

$pdf->Cell(47, 4, $listarCiudadContrato[0]['ciudad'], 'B', 0, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell2(10, 4, utf8_decode('a los'), 0, '1', 'FJ');


/*LINE 19*/

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25, 4,  strtoupper($convertirDiaFechaCreacion) . ' ' . '(' . $dia_fecha_creacion_contrato . ')', 'B', 0, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(25, 4, utf8_decode('días del mes de'), 0, '0', 'J');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(35, 4, strtoupper($convertirMesFechaCreacion) . ' ' . '(' . $mes_fecha_creacion_contrato . ')', 'B', 0, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(6, 4, utf8_decode('del'), 0, '0', 'J');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(53, 4,  strtoupper($convertirAñoFechaCreacion) . ' ' . '(' . $año_fecha_creacion_contrato . ')', 'B', 0, 'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(1, 4, utf8_decode('.'), 0, '1', 'J');
$pdf->Ln(10);

$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(95, 4, utf8_decode('EL CONTRATANTE'), 0, '0', 'C');
$pdf->Cell(95, 4, utf8_decode('EL CONTRATISTA'), 0, '0', 'C');
$pdf->Ln(28);

$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(95, 4, utf8_decode($datosCliente[0]['representante_legalC']), 0, '0', 'C');

$pdf->Cell(95, 4, utf8_decode($datosEmpresa[0]['representante_legal']), 0, '1', 'C');
$pdf->Ln(1);

$listarLugarExpedicionC = $ciudad->listarCiudadPorId($datosCliente[0]['lugar_expedicionC']);
$listarLugarExpedicionE = $ciudad->listarCiudadPorId($datosEmpresa[0]['lugar_expedicion']);

$pdf->Cell(95, 4, utf8_decode('CC. N°') . $datosCliente[0]['numero_documentoC'] . ' ' . 'DE' . ' '. strtr(strtoupper($listarLugarExpedicionC[0]['ciudad']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, '0', 'C');


$pdf->Cell(95, 4, utf8_decode('CC. N°') .$datosEmpresa[0]['numero_documento'] . ' ' . 'DE' . ' '. strtr(strtoupper($listarLugarExpedicionE[0]['ciudad']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 0, '1', 'C');

$pdf->Ln(1);

$cliente = explode(' ', $datosCliente[0]['razon_social']);
$contar = count($cliente);
$mitad = round($contar / 2);

$primera_linea = '';
for($i=0;$i<$mitad;$i++){
    $primera_linea .= $cliente[$i].' ';
}

$segunda_linea = '';
for($i=$mitad;$i<$contar;$i++){
    $segunda_linea .= $cliente[$i].' ';
}

if ($contar < 7) { 
    $pdf->Cell(95, 4,  utf8_decode($datosCliente[0]['razon_social']), 0, '0', 'C');
}else if ($contar > 7) {
    $pdf->Cell(95, 4,  utf8_decode($primera_linea), 0, '1', 'C');
    $pdf->Cell(95, 4,  utf8_decode($segunda_linea), 0, '0', 'C');
}


$pdf->Cell(95, 4, utf8_decode($datosEmpresa[0]['nombre_empresa']), 0, '1', 'C');
$pdf->Ln(1);

/* ################## */

$pdf->Cell(95, 4, 'REPRESENTANTE LEGAL', 0, '0', 'C');
$pdf->Cell(95, 4, 'REPRESENTANTE LEGAL', 0, '1', 'C');
$pdf->Ln(1);

/* ################## */

$pdf->Cell(95, 4, utf8_decode('NIT:') . $datosCliente[0]['nit_cliente'], 0, '0', 'C');
$pdf->Cell(95, 4, utf8_decode('NIT:'). $datosEmpresa[0]['nit_empresa'], 0, '0', 'C');

$pdf->Ln(1);


$pdf->Output();
 ?>
<div id="loading" style="display:block;">
    <img src="../../Resources/images/renderLoader.gif" alt="Loading" />
</div>
<script type="text/javascript">
     $("#loading").ajaxStart(function () {
        $(this).show();
     });

     $("#loading").ajaxStop(function () {
        $(this).hide();
     });
</script>
    
