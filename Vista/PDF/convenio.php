<?php 
ob_start();
require("../../Resources/fpdf/fpdf.php");
require('../../Resources/fpdf-easytable-master/exfpdf.php');
require('../../Resources/fpdf-easytable-master/easyTable.php');
require("../../Modelo/Cliente-Convenio.php");
require("../../Modelo/TipoVehiculo.php");
require("../../Modelo/EmpresaEnt.php");
require("../../Modelo/Conductor.php");
require("../../Modelo/Convenio.php");
require("../../Modelo/Vehiculo.php");
require("../../Modelo/Contrato.php");
require("../../Modelo/General.php");
require("../../Modelo/Cliente.php");
require("../../Modelo/Usuario.php");
require("../../Modelo/Ciudad.php");
require('../../Modelo/Fuec.php');

$id_convenio = $_GET['id_convenio'];

$convenio = new Convenio();
$listarC = $convenio->listarId($id_convenio);


$clienteConvenio = new Cliente_Convenio();
$tipoVehiculo = new TipoVehiculo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$contrato = new Contrato();
$usuario = new Usuario();
$cliente = new Cliente();
$empresa = new Empresa();
$ciudad = new Ciudad();
$fuec = new Fuec();

$listarEmpresaPorId = $empresa->listarPorId($listarC[0]['id_empresa']);
$listarClientePorId = $clienteConvenio->listarClientePorId($listarC[0]['id_cliente']);
$listarVehiculoPorId = $vehiculo->listarPorId($listarC[0]['id_vehiculo']);
$listarPropietarioPorId = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']);
$listarTipoVehiculoPorId = $tipoVehiculo->listarPorId($listarVehiculoPorId[0]['id_tipo_vehiculo']);


class PDF extends exFPDF{

	function Header(){
		$id_convenio1 = $_GET['id_convenio'];

        $convenio1 = new Convenio();
		$listarC1 = $convenio1->listarId($id_convenio1);

		$empresa1 = new Empresa();
		$listarEmpresaPorId1 = $empresa1->listarPorId($listarC1[0]['id_empresa']); 

        $this->Image('../../Resources/fpdf/img/'. $listarEmpresaPorId1[0]['logo'], 10,5,30);
		$this->Image('../../Resources/fpdf/img/logo-vigilado-supertransporte.png',150,6,45);
		$this->SetFont('Arial','',14);	
		$this->SetDrawColor(191, 216, 239);	
		$this->SetLineWidth(0.2);
		$this->Cell(0, 15,'', 'B', 1, '');

		$this->Ln(12);
	}

	function Footer(){

		$id_convenio2 = $_GET['id_convenio'];
        $convenio2 = new Convenio();
		$listarC2 = $convenio2->listarId($id_convenio2);


		$empresa2 = new Empresa();
		$listarEmpresaPorId2 = $empresa2->listarPorId($listarC2[0]['id_empresa']); 


        $this->Image('../../Resources/fpdf/img/'. $listarEmpresaPorId2[0]['logo'], 10,245,30);
		

        $this->SetY(220);

		$this->SetDrawColor(191, 216, 239);	
		$this->SetLineWidth(0.2);
		$this->Cell(0, 20,'', 'B', 1, '');

        $this->SetXY(120,245);

        $this->Ln(2);	

        $this->SetTextColor(113, 113, 113);
        $this->SetFont('Arial','',8);
        $this->Cell(32, 4, '', 0,'0','J');	
        $this->Cell(147, 4, utf8_decode('Calle 73 N. 75-55. Santa Maria del Lago'), 0,'1','J');

        $this->Cell(32, 4, '', 0,'0','J');	
        $this->Cell(147, 4, utf8_decode('Info@ortsas.com - www.ortsas.com'), 0,'1','J');

        $this->Cell(32, 4, '', 0,'0','J');	
        $this->Cell(147, 4, utf8_decode('PBX. 5559265/60/61 Ext. 100'), 0,'1','J');

        $this->Cell(32, 4, '', 0,'0','J');	
        $this->Cell(147, 4, utf8_decode('Bogotá, D.C - Colombia'), 0,'1','J');



		// Posición: a 1,5 cm del final
        $this->SetY(-18);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Número de página
        $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');


	}
}


//$pdf = new PDF();
$pdf = new PDF('P','mm','Letter');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetAutoPageBreak(true,55);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(0, 2, utf8_decode('CONVENIO DE COLABORACIÓN EMPRESARIAL PARA LA PRESTACIÓN DE SERVICIOS DE TRANSPORTE'), '','1','C');
$pdf->Ln(8);

/**/

$pdf->SetFont('Arial','',8);
$pdf->Cell(24, 3, utf8_decode('Entre los suscritos'), 0,'0','J');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(50, 3, utf8_decode($listarEmpresaPorId[0]['representante_legal']) , 'B', 0, 'C');


$pdf->SetFont('Arial','',8);
$pdf->Cell2(83, 3, utf8_decode(', mayor de edad, identificado con la cedula de ciudadania número'), 0,'0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(16, 3, $listarEmpresaPorId[0]['numero_documento'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(17, 3, utf8_decode('expedida en'), 0,'1','FJ');

/**/

$listarCiudadExpedicion = $ciudad->listarCiudadPorId($listarEmpresaPorId[0]['lugar_expedicion']);

$pdf->SetFont('Arial','B',7);
$pdf->Cell(37, 3, $listarCiudadExpedicion[0]['ciudad'], 'B', 0, 'C');

$pdf->SetFont('Arial','',8);
$pdf->Cell2(81, 3, utf8_decode('quien actúa en su calidad de Representante Legal de la empresa'), 0,'0','FJ');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(71, 3, utf8_decode(strtoupper($listarEmpresaPorId[0]['nombre_empresa'])), 'B', 1, 'C');


/**/

$pdf->SetFont('Arial','',8);
$pdf->Cell2(65, 3, utf8_decode('Sociedad legalmente constituida, identificada con'), 0,'0','FJ');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(7, 3, utf8_decode('NIT: '), 0,'0','J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(30, 3, $listarEmpresaPorId[0]['nit_empresa'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(88, 3, utf8_decode('quien en adelante y para los efectos de este convenio se denominará'), 0,'1','FJ');


/**/
	
$pdf->SetFont('Arial','B',7);
$pdf->Cell2(41, 3, utf8_decode('LA EMPRESA CONTRATISTA'), 0,'0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell(2, 3, utf8_decode('y'), 0,'0','J');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(79, 3, utf8_decode($listarClientePorId[0]['representante_legalC']), 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(68, 3, utf8_decode(', tambien mayor de edad, identificado con la C.C'), 0,'1','FJ');


/**/

$pdf->SetFont('Arial','B',7);
$pdf->Cell(30, 3, $listarClientePorId[0]['numero_documentoC'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(20, 3, utf8_decode('expedida en'), 0,'0','FJ');
$pdf->SetFont('Arial','B', 7);

$listarLugarExpedicionEmpresa = $ciudad->listarCiudadPorId($listarClientePorId[0]['lugar_expedicionC']);
$pdf->Cell(42, 3,  $listarLugarExpedicionEmpresa[0]['ciudad'] , 'B', 0, 'C');
	
$pdf->SetFont('Arial','',8);
$pdf->Cell2(98, 3, utf8_decode('quien actúa en su calidad de Representante Legal de la empresa'), 0,'1','FJ');

/**/


$pdf->SetFont('Arial','B',6.7);
$pdf->Cell(133, 3, utf8_decode($listarClientePorId[0]['razon_social']), 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(57, 3, utf8_decode('sociedad legalmente constituida identificada'), 0,'1','FJ');

$pdf->SetFont('Arial','',8);
$pdf->Cell(6, 3, utf8_decode('con'), 0,'0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(7, 3, utf8_decode('NIT:'), 0,'0','FJ');
$pdf->Cell(23, 3, $listarClientePorId[0]['nit_cliente'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(90, 3, utf8_decode(', quien en adelante y para los efectos de este contacto se denominará'), 0,'0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(46, 3, utf8_decode('LA EMPRESA COLABORADORA,'), 0,'0','J');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(18, 3, utf8_decode('y quienes en'), 0,'1','FJ');

/**/


$pdf->SetFont('Arial','B',8);
$pdf->Cell(20, 3, utf8_decode('LAS PARTES'), 0,'0','J');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(170, 3, utf8_decode('y quienes se encuentra legalmente habilitadas para la prestación de servicios de transporte especial; hemos acordado celebrar'), 0,'1','FJ');

/**/

$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('el presente Convenio de Colaboración Empresarial conforme lo  establecido en los Decretos 1079 de 2015 y 431 de 2017,  y en concordancia'), 0,'1','FJ');

/**/


$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('con las resoluciones 3068 de 2014 y 1069 de 2015, expedidas por el Ministerio de Transporte y demás normas complementarias o las que'), 0,'1','FJ');


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('la sustituyan, y en especial por lo dispuesto en  las siguientes cláusulas.'), 0,'1','J');

$pdf->Ln(2);

$pdf->SetFont('Arial','B',7.5);
$pdf->Cell2(32, 3, utf8_decode(' PRIMERA. OBJETIVO:'), 0,'0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(148, 3, utf8_decode('Por medio del presente convenio LA EMPRESA COLABORADORA pone a disposición de LA EMPRESA CONTRATISTA al '), 0,'1','J');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 2, utf8_decode('vehiculo descrito a continuación, vinculado a la empresa colaboradora, con el objeto de colaborar en la ejecución del contrato para'), 0,'1','FJ');


$pdf->SetFont('Arial','B',7);
$table = new easyTable($pdf,'{190}', 'font-size: 7; font-family:Arial; align:L;');
 	$table->rowStyle('min-height:3');
    $table->easyCell(utf8_decode($listarC[0]['objeto']) . '.', 'align: L');
    $table->printRow();
$table->endTable(0);

if($listarC[0]['id_cliente'] == 92){

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('Este convenio deberá ajustarse a lo estipulado articulo Artículo 2.2.1.6.3.4., Parágrafo 3°.- "Ninguna de las empresas de transporte que participan en'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('convenios de colaboración empresarial podrá ofrecer o recibir en convenios para la operación una flota superior al 30% de su parque automotor'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('vinculado y con tarjeta de operación vigente. Este porcentaje corresponde al porcentaje máximo de flota que puede tener la empresa para uno o para'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('la totalidad de los convenios suscriba".'), 0,'1','J');

}


/**/
$pdf->Ln(5);

$contratos = explode(",", $listarC[0]['id_contrato']);

if (count($contratos) > 1) {

	$a = 1;
	for ($i=0; $i < count($contratos); $i++) { 
		$listarContratoPorId = $contrato->listarId($contratos[$i]);

		$listarEmpresasId = $cliente->cliente_ID($listarContratoPorId[0]['id_cliente']);

		$pdf->Cell(1, 4, '', 0,'0','C');
		$pdf->SetFont('Arial','B', 7);
		$pdf->Cell(10, 4, $a, 'B,L,T','0','C');
		$pdf->SetFont('Arial','', 6.5);
		$pdf->Cell(177, 4, utf8_decode(strtr(strtoupper($listarEmpresasId[0]['razon_social']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")) . ' - ' . $listarEmpresasId[0]['nit_cliente'], 1,'1','C');
		$pdf->Ln(1);
		$a++;
	}
	
	$pdf->Ln(5);
	
}


$pdf->SetFont('Arial','B',7);
$pdf->Cell(1, 4, '', 0,'0','C');
$pdf->Cell(13, 4, 'PLACA', 1,'0','C');
$pdf->SetFont('Arial','',7);
$pdf->Cell(33, 4, $listarVehiculoPorId[0]['placa'], 1,'0','C');

$pdf->SetFont('Arial','B',7);
$pdf->Cell(17, 4, 'TIPO', 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(47, 4, $listarTipoVehiculoPorId[0]['nombre_tipo_vehiculo'], 1,'0','C');


$pdf->SetFont('Arial','B',7);
$pdf->Cell(19, 4, utf8_decode('N° CHASIS'), 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(58, 4, $listarVehiculoPorId[0]['numero_chasis'], 1,'1','C');

$pdf->Ln(1);

/**/
$pdf->Cell(1, 4, '', 0,'0','C');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(13, 4, 'MODELO', 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(33, 4, $listarVehiculoPorId[0]['modelo'], 1,'0','C');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(17, 4, 'CAPACIDAD', 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(47, 4, $listarVehiculoPorId[0]['cant_pasajeros'] . ' ' .  'PASAJEROS', 1,'0','C');
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(19, 4, utf8_decode('N° MOTOR'), 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(58, 4, $listarVehiculoPorId[0]['numero_motor'], 1,'1','C');
$pdf->Ln(1);
/**/

$pdf->Cell(1, 4, '', 0,'0','C');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(13, 4, 'MARCA', 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(74, 4, $listarVehiculoPorId[0]['marca'], 'B-L-T','0','C');
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(20, 4, 'PROPIETARIO', 1,'0','C');
$pdf->SetFont('Arial','', 7);
$pdf->Cell(80, 4, utf8_decode(strtr(strtoupper($listarPropietarioPorId[0]['nombre']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 1,'1','C');

$pdf->Ln(5);

$pdf->Cell(1, 4, '', 0,'0','C');
$pdf->SetFont('Arial','B', 7);
$pdf->Cell(30, 4, '', 'B,L,T','0','C');
$pdf->Cell(87, 4, 'NOMBRE CONDUCTOR', 1,'0','C');
$pdf->Cell(30, 4, utf8_decode('N° DOCUMENTO'), 1,'0','C');
$pdf->Cell(40, 4, 'VENCIMIENTO LICENCIA', 1,'1','C');
$pdf->Ln(1);
$conductores = explode(",", $listarC[0]['id_conductor']);
$a = 1;

for ($i=0; $i < count($conductores); $i++) { 
	$listarConductorPorId = $conductor->listarPorId($conductores[$i]);

	$pdf->Cell(1, 4, '', 0,'0','C');
	$pdf->SetFont('Arial','B', 7);
	$pdf->Cell(30, 4, 'CONDUCTOR ' . $a, 'B,L,T','0','C');
	$pdf->SetFont('Arial','', 6.5);
	$pdf->Cell(87, 4, utf8_decode(strtoupper(strtr($listarConductorPorId[0]['nombre_conductor'], "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"))), 1,'0','C');
	$pdf->Cell(30, 4, $listarConductorPorId[0]['numero_documento_conductor'], 1,'0','C');
	$pdf->Cell(40, 4, $listarConductorPorId[0]['fecha_vencimiento_licencia'], 1,'1','C');
	$pdf->Ln(1);
	$a++;
}

$pdf->Ln(5);


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('El  vehículo  a  disposición  se  encuentra  debidamente  homologado  para  la  prestación  del  servicio  Público  Terrestre Automotor Especial, cuyas'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell(156, 3, utf8_decode('características y especificaciones técnicas y de seguridad, se encuentran acordes a las exigidas en la normatividad vigente.'), 0,'0','J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell2(34, 3, utf8_decode('SEGUNDA: DURACIÓN:'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(53, 3, utf8_decode('La duración del presente convenio será de'), 0,'0','FJ');
$pdf->SetFont('Arial','B',8);

$fecha_inicio_convenio = explode("-", $listarC[0]['fecha_inicio_convenio']);
$año_fecha_inicio_convenio = $fecha_inicio_convenio[0];
$mes_fecha_inicio_convenio = $fecha_inicio_convenio[1];
$dia_fecha_inicio_convenio = $fecha_inicio_convenio[2];

$convertirDiaFechaInicial = convertir($dia_fecha_inicio_convenio);
$convertirMesFechaInicial = mes($mes_fecha_inicio_convenio);
$convertirAñoFechaInicial = convertir($año_fecha_inicio_convenio);

/* Fecha final*/
$fecha_final_convenio = explode("-", $listarC[0]['fecha_final_convenio']);
$año_fecha_final_convenio = $fecha_final_convenio[0];
$mes_fecha_final_convenio = $fecha_final_convenio[1];
$dia_fecha_final_convenio = $fecha_final_convenio[2];

$convertirDiaFechaFinal = convertir($dia_fecha_final_convenio);
$convertirMesFechaFinal = mes($mes_fecha_final_convenio);
$convertirAñoFechaFinal = convertir($año_fecha_final_convenio);

/*Fecha creacion*/
$fecha_creacion_convenio = explode("-", $listarC[0]['fecha_creacion_convenio']);
$año_fecha_creacion_convenio = $fecha_creacion_convenio[0];
$mes_fecha_creacion_convenio = $fecha_creacion_convenio[1];
$dia_fecha_creacion_convenio = $fecha_creacion_convenio[2];

$convertirDiaFechaCreacion = convertir($dia_fecha_creacion_convenio);
$convertirMesFechaCreacion = mes($mes_fecha_creacion_convenio);
$convertirAñoFechaCreacion = convertir($mes_fecha_creacion_convenio);


$fecha1 = new DateTime($listarC[0]['fecha_inicio_convenio']);
$fecha2 = new DateTime($listarC[0]['fecha_final_convenio']);
$intervalo = $fecha1->diff($fecha2); 
$converir = convertir($intervalo->format('%a'));

$pdf->SetFont('Arial','B', 7);
$pdf->Cell(46, 3, utf8_decode(strtoupper($converir) . ' (' . $intervalo->format('%a') . ') ' . 'DIAS'), 'B', 0, 'C');


$pdf->SetFont('Arial','',8);
$pdf->Cell(30, 3, utf8_decode('contados desde el día'), 0,'0','J');
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(28, 3, utf8_decode(strtoupper($convertirDiaFechaInicial) . ' '. '(' . $fecha_inicio_convenio[2] . ')'), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(7, 3, utf8_decode(' de'), 0,'0','J');
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(25, 3, utf8_decode(strtoupper($convertirMesFechaInicial) . ' '. '(' . $fecha_inicio_convenio[1] . ')'), 'B', 1, 'C');


$pdf->SetFont('Arial', '', 9);
$pdf->Cell(13, 3, utf8_decode('del año'), 0,'0','J');
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(9, 3, $fecha_inicio_convenio[0], 'B', 0, 'C');

$pdf->SetFont('Arial', '', 9);
$pdf->Cell(5, 3, utf8_decode('al'), 0,'0','J');
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(28, 3, utf8_decode(strtoupper($convertirDiaFechaFinal) . ' '. '(' . $fecha_final_convenio[2] . ')'), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(5, 3, utf8_decode('de'), 0,'0','J');
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(28, 3, utf8_decode(strtoupper($convertirMesFechaFinal) . ' '. '(' . $fecha_final_convenio[1] . ')'), 'B', 0, 'C');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell2(13, 3, utf8_decode('del año'), 0,'0','FJ');
$pdf->SetFont('Arial', 'B', 6.5);
$pdf->Cell(9, 3, $fecha_final_convenio[0]. '.', 'B', 0, 'C');


$pdf->SetFont('Arial','B',8);
$pdf->Cell2(65, 3, utf8_decode('TERCERA. OBLIGACIONES DE LAS PARTES:'), 0,'0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(15, 3, utf8_decode('Las partes'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell(150, 3, utf8_decode('tendrán a su cargo las obligaciones legales correspondientes a la esencia del convenio, adicionalmente las siguientes: '), 0,'0','J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(40, 3, utf8_decode('I) EMPRESA  CONTRATISTA'), 0,'1','J');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('a) Administrar en debida  forma  el  vehículo  b)  Utilizar  el vehículo exclusivamente para el objeto pactado en este convenio  c)  Realizar inspecciones'), 0,'1','FJ');



/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('permanentes al vehículo para  garantizar  su buen estado  d)  Radicar el presente convenio una vez legalizado por las partes en el Ministerio de Transporte y'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(64, 3, utf8_decode('en la Superintendencia de Puertos y Transportes.'), 0,'0','FJ');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(48, 3, utf8_decode('II) LA EMPRESA COLABORADORA'), 0,'0','J');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(78, 3, utf8_decode('a)  Garantizar  que  los  vehículos  de  su  parque automotor'),0 ,'1','FJ');


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('destinados para prestar el transporte objeto del presente convenio, estén vinculados legalmente al servicio público de transporte terrestre automotor'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('especial, con todos los documentos exigidos en la ley para la prestación del servicio incluyendo tarjeta de operación vigente, pólizas de'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('responsabilidad civil contractual y extracontractual en cuantía mínima de 100 SMLMV, SOAT, revisiones técnico mecánicas y preventivas de conformidad'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('con la Resolución 315 de 2013 y demás normas concordantes b) Poner a disposición de la EMPRESA CONTRATISTA vehículos que cuentan'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('con las condiciones de homologación para la prestación de servicios de transporte publico automotor especial establecidas para la prestación de servicios'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('de transporte publico automotor especial establecidas por el Ministerio de Transporte y el Código Nacional de Tránsito c) Velar por que el propietario o'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('quien corresponda se haga responsable por las multas, sanciones y demás costos que se generen por fallas en los documentos del vehículo'), 0,'1','FJ');


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode(' o por infracciones en las norma de transito d) Vigilar que el conductor del vehículo se encuentre afiliado y realice sus pagos a seguridad social integral,'), 0,'1','FJ');

if ($listarC[0]['id_cliente'] == '92') {
	
	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(146, 3, utf8_decode('asimismo, que tenga la formación académica e idoneidad requerida en la ley para el desempeño de su labor. e) '), 0,'0','FJ');
	$pdf->SetFont('Arial','B',7);
	$pdf->Cell2(44, 3, utf8_decode('AUXILIAR DE RUTA O MONITORA'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('En ningún momento como empresa colaboradora, tenemos responsabilidad y/o autonomía sobre la auxiliar de ruta y/o Monitora que la empresa'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('contratista y/o el colegio y/o el propietario contrate para tal fin, ya que se está realizando un convenio de colaboración empresarial, civil o'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(153, 3, utf8_decode('comercial para suplir la deficiencia del parque automotor, tal cual lo establece el decreto 00000431 de 2017.'), 0,'0','FJ');
	
	//NUEVO//
	
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell2(37, 3, utf8_decode('CUARTA. EXTRACTO DE'), 0,'1','FJ');

}else{
	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(153, 3, utf8_decode('asimismo, que tenga la formación académica e idoneidad requerida en la ley para el desempeño de su labor.'), 0,'0','FJ');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell2(37, 3, utf8_decode('CUARTA. EXTRACTO DE'), 0,'1','FJ');
}



/**/
$pdf->SetFont('Arial','B',8);
$pdf->Cell(18, 3, utf8_decode('CONTRATO:'), 0,'0','J');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(172, 3, utf8_decode('LA EMPRESA CONTRATISTA, será la encargada de expedir el Extracto de Contrato exclusivamente sobre la prestación del servicio objeto'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('de este convenio y previa presentación de paz y salvo emitido por la EMPRESA COLABORADORA en donde se acredite que el vehículo cumple'), 0,'1','FJ');


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('con todos los documentos requeridos para la operación y los soportes de pago a seguridad social del conductor que operara el vehículo.'), 0,'1','FJ');


if ($listarC[0]['id_cliente'] == '92') {

	// /**/
	// $pdf->SetFont('Arial','',8);
	// $pdf->Cell2(190, 3, utf8_decode('La expedición y firma de este documento conlleva igualmente la responsabilidad y solidaridad en las acciones legales que por su emisión u omisión'), 0,'1','FJ');

	// /**/
	// $pdf->SetFont('Arial','',8);
	// $pdf->Cell2(190, 3, utf8_decode('se pueden generar, conformé al articulo 984 y 991 del codigo de comercio, ley 336 del 96, resolución 10800/2003, hasta el monto de las pólizas'), 0,'1','FJ');

	// /**/
	// $pdf->SetFont('Arial','',8);
	// $pdf->Cell2(190, 3, utf8_decode('y saciones impuestas.'), 0,'1','J');

	/**/

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('Conforme la autorización dada por la decreto 1079/15, art. 9 decreto. 431/17, resolución 1069/15 expedida por el Ministerio de Transporte, el trasportador'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('contractual será el responsable de expedir el FUEC indicando la existencia del convenio y allegando copia de estos a la empresa colaboradora, el cual se'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('encuentra dentro del porcentaje del (30%) autorizado por el decreto 431/17. La expedición y firma de este documento conlleva igualmente la responsabilidad'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('y solidaridad en las acciones legales que por su emisión u omisión se puedan generar, conformé al artículo 984 y 991 del código de comercio, ley 336 del 96,'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('resolución 10800/2003, hasta el monto de las pólizas y sanciones impuestas. La empresa CONTRATANTE no expedirá el FUEC, sin antes solicitar paz'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('y salvo emitido por la empresa COLABORADORA del vehículo (s) relacionado (s) en el presente convenio. La empresa contratante en cumplimiento de la'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('de ley 336/16 vigilara el pago de la seguridad social del conductor; por su parte la empresa colaboradora se compromete a cumplir con los requisitos'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('establecidos en la Resolución 1565/14 Numeral 8.1, Resolución 1231/16 y demás normas específicas del PESV. EL TRANSPORTADOR CONTRACTUAL'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('está obligado a radicar copia del presente convenio ante el ministerio de transporte y la superintendencia e puertos y transporte,'), 0,'1','FJ');

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('conforme al paragrafo 2 del artículo 2.2.1.6.34 del decreto 1079/15.'), 0,'1','F');
	
	$pdf->Ln(1);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('PROTOCOLO DE BIOSEGURIDAD, la empresa CONTRATANTE; en cumplimiento de las disposiciones: circular (004 de la Superintendencia de'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('Transporte, Resoluciones 666 y 667 y circular conjunta 003 del Ministerio de Salud y transporte); se compromete a vigilar y constatar que el'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('conductor del vehículo, descrito en el presente convenio; de estricto cumplimiento a al protocolo de Bioseguridad adoptado por las'), 0,'1','FJ');
	
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('empresas CONTRATANTE Y COLABORADORA.'), 0,'1','F');

	$pdf->Ln(1);
}


if ($listarC[0]['id_cliente'] == '85') {

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(41, 3, utf8_decode('QUINTA. RESPONSABILIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(149, 3, utf8_decode('Las pólizas de responsabilidad civil serán las encargadas de cubrir los riesgos que puedan surgir en desarrollo del presente'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('convenio, la Responsabilidad Cilvil Contractual y Extracontractual de sus vehículos vinculados por los daños que se puedan derivar de la prestación'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('del servicio a los usuarios del mismo o a terceros, hasta por el monto de las pólizas de seguros RCC Y RCE; asimismo, de forma solidaria, EL PROPIETARIO'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('asumirá la responsabilidad en lo no amparado por las pólizas y respecto de los daños materiales que llegare a sufrir el vehículo. La responsabilidad en la'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('prestación del servicio, respecto a la calidad, operatividad, cubrimiento y desarrollo de este estará a cargo de la EMPRESA CONTRATISTA. si se impone multas'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('sanciones o similares a la EMPRESA CONTRATISTA, por fallas en los documentos del vehículo suministrado, incumplimientos a las normas de tránsito,'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(115, 3, utf8_decode('sanciones administrativas y demás este podrá repetir contra EL PROPIETARIO del vehículo.'), 0,'0','FJ');

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell2(75, 3, utf8_decode('SÉXTA. CAUSALES DE TERMINACIÓN DEL CONVENIO'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('Este convenio se puede dar por terminado durante la vigencia del mismo, mediante aviso dado por escrito por parte de ambas empresas, sin que haya lugar al'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(61, 3, utf8_decode('reconocimiento de ningún tipo de indemnización.'), 0,'0','J');
	
	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(46, 3, utf8_decode('SÉPTIMA. CONFIDENCIALIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(144, 3, utf8_decode('LAS PARTES se comprometen a guardar estricta confidencialidad sobre la	información y documentos que llegare a'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('conocer como consecuencia del desarrollo de este convenio, por lo cual, bajo ninguna circunstancia podrán utilizarla en detrimento de la otra parte, o en'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('beneficio propio o de un tercero, o de cualquier manera divulgarla.'), 0,'1','J');

} else if ($listarC[0]['id_cliente'] == '96') {

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(41, 3, utf8_decode('QUINTA. RESPONSABILIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(149, 3, utf8_decode('Se deja expresa constancia que la Empresa Contratista no tendrá ningún vínculo laboral con el personal contratado'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('para la ejecuión del presente convenio, la dotacion, exámenes de salud ocupacional o cualquier otro gasto surgido con el conductor y/o monitora'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('del vehículo, estos gastos serán a cargo del propietario asumiendo este su valor, El propietario es el único responsable del pago de salarios,'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('prestaciones sociales, seguridad social, aportes parafiscales, indemnizaciones y demás acreencias laborales a que legalmente tenga derecho el conductor'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('y/o monitora, así como obligaciones con la Empresa Colaboradora, La empresa contratista se limitará al control y supervisión de su función.'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell2(77, 3, utf8_decode('SÉXTA. CAUSALES DE TERMINACIÓN DEL CONVENIO:'), 0,'0','FJ');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(113, 3, utf8_decode('Este convenio se puede dar por terminado durante la vigencia del mismo, mediante aviso'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('dado por escrito, con por lo menos diez (10) días corrientes de anticipación, sin que haya lugar al reconocimiento de ningún tipo de indemnización.'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(46, 3, utf8_decode('SÉPTIMA. CONFIDENCIALIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(144, 3, utf8_decode('LAS PARTES se comprometen a guardar estricta confidencialidad sobre la	información y documentos que llegare a'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('conocer como consecuencia del desarrollo de este convenio, por lo cual, bajo ninguna circunstancia podrán utilizarla en detrimento de la otra parte, o en'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('beneficio propio o de un tercero, o de cualquier manera divulgarla.'), 0,'1','J');

}else{

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(42, 3, utf8_decode('QUINTA. RESPONSABILIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(148, 3, utf8_decode('La EMPRESA COLABORADORA asumirá la Responsabilidad Civil Contractual y Extracontractual de sus vehículos'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('que se puedan derivar de la prestación del servicio a los usuarios del mismo o a terceros, hasta por el monto de las pólizas de seguros RCC'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('y RCE; asimismo, de forma solidaria, EL PROPIETARIO asumirá la responsabilidad en lo no amparado por las pólizas y respecto de los daños'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('materiales que llegare a sufrir el vehículo. La responsabilidad en la prestación del servicio, respecto a la calidad, operatividad, cubrimiento'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('y desarrollo de este, estará a cargo de la EMPRESA CONTRATISTA. Si se impone multas, sanciones o similares a LA EMPRESA CONTRATISTA, por'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('fallas en los documentos del vehículo suministrado, incumplimientos a las normas de tránsito, sanciones administrativas y demás este podrá repetir contra'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(43, 3, utf8_decode('EL PROPIETARIO del vehículo.'), 0,'0','FJ');
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell2(77, 3, utf8_decode('SÉXTA. CAUSALES DE TERMINACIÓN DEL CONVENIO:'), 0,'0','FJ');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(70, 3, utf8_decode('Este convenio se puede dar por terminado durante la'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('la vigencia del mismo, mediante aviso dado por escrito, con por lo menos diez (10) días corrientes de anticipación, sin que haya lugar al reconocimiento'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(43, 3, utf8_decode('de ningún tipo de indemnización.'), 0,'0','J');

	/**/
	$pdf->SetFont('Arial','B',8);
	$pdf->Cell(46, 3, utf8_decode('SÉPTIMA. CONFIDENCIALIDAD:'), 0,'0','J');
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(101, 3, utf8_decode('LAS PARTES se comprometen a guardar estricta confidencialidad sobre la	'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(190, 3, utf8_decode('sobre la información y documentos que llegare a conocer como consecuencia del desarrollo de este convenio, por lo cual, bajo ninguna circunstancia'), 0,'1','FJ');

	/**/
	$pdf->SetFont('Arial','',8);
	$pdf->Cell2(175, 3, utf8_decode('podrán utilizarla en detrimento de la otra parte, o en beneficio propio o de un tercero, o de cualquier manera divulgarla.'), 0,'1','J');
}

/**/
$pdf->SetFont('Arial','B',7.7);
$pdf->Cell2(150, 3, utf8_decode('OCTAVA. INDEMNIDAD DE LA EMPRESA CONTRATISTA FRENTE AL PROPIETARIO Y/O TENEDOR DEL VEHÍCULO:'), 0,'0','FJ');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(40, 3, utf8_decode('Con la celebración del presente'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('convenio de Colaboración Empresarial, LA EMPRESA CONTRATISTA no se obliga de ninguna manera a garantizar
la contratación mínima o prioritaria'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(190, 3, utf8_decode('de los vehículos objeto del presente contrato, pues se entiende que se acude a ellos por la demanda requerida, sin que ello genere obligación alguna'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell(70, 3, utf8_decode('de mantenerlos en constante contratación u operación.'), 0,'0','J');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(41, 3, utf8_decode('NOVENA. NOTIFICACIONES:-'), 0,'0','J');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(79, 3, utf8_decode('Para efectos de notificaciones judiciales y/o extrajudiciales'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell2(90, 3, utf8_decode('las partes declaran que las reciben en LA EMPRESA CONTRATISTA:'), 0,'0','FJ');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(78, 3, strtoupper($listarEmpresaPorId[0]['direccion']), 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(22, 3, utf8_decode('y LA EMPRESA'), 0,'1','FJ');


/**/
$pdf->SetFont('Arial','',8);
$pdf->Cell(32, 3, utf8_decode('COLABORADORA:'), 0,'','FJ');
$pdf->SetFont('Arial','B',6.8);
$pdf->Cell(80, 3, utf8_decode($listarClientePorId[0]['direccionC']) . ' - ' . $listarClientePorId[0]['telefonoC'], 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell2(78, 3, utf8_decode('. Una vez leído el presente documento por los que intervienen,'), 0,'1','FJ');

/**/
$pdf->Cell2(190, 3, utf8_decode('lo aprueban en su en su integridad, y en prueba de su consentimiento, firma cuatro originales del mismo tenor en la ciudad de Bogotá D.C., a los'), 0,'1','FJ');

/**/
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(28, 3, utf8_decode(strtr(strtoupper($convertirDiaFechaCreacion), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")) . ' ' . '(' . $fecha_creacion_convenio[2] . ')', 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(21, 3, utf8_decode('dias del mes de'), 0,'0','J');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(24, 3, strtoupper($convertirMesFechaCreacion) . ' ' . '(' . $fecha_creacion_convenio[1] . ')', 'B', 0, 'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(10, 3, utf8_decode('del año'), 0,'0','J');
$pdf->SetFont('Arial','B',6.5);
$pdf->Cell(10, 3, $fecha_creacion_convenio[0], 'B', 0, 'C');
$pdf->Cell(1, 3, utf8_decode('.'), 0,'1','J');

$pdf->Ln(15);

$aprobacion = $fuec->Aprobacion($listarC[0]['id_empresa']);
$sello = '../../Resources/fuec/img/'. $aprobacion[0]['firma_fuec'];
$selloCliente = '../../Resources/fuec/img/'. $listarClientePorId[0]['firma_empresa'];


/*
$pdf->Cell(95, 3, $pdf->Image($sello, 10,10,10), 0,'0','C');*/
$pdf->Cell(95, 18, $pdf->Image($sello,$pdf->GetX()+25, $pdf->GetY()), 0,'0','C');

/*$pdf->Image($sello,$pdf->GetX()+25,$pdf->GetY());
$pdf->Image($selloCliente,$pdf->GetX()+120,$pdf->GetY());*/

if ($listarClientePorId[0]['firma_empresa'] == '') {
	$pdf->Cell(95, 18, "", 0,'1','C');
}else{
	$pdf->Cell(95, 18, $pdf->Image($selloCliente,$pdf->GetX()+25, $pdf->GetY()), 0,'1','C');
}

$pdf->SetFont('Arial','',7);
$pdf->Cell(95, 3, utf8_decode(strtr(strtoupper($listarEmpresaPorId[0]['representante_legal']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 0,'0','C');
$pdf->Cell(95, 3, utf8_decode(strtr(strtoupper($listarClientePorId[0]['representante_legalC']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 0,'1','C');


$pdf->SetFont('Arial','B',7);
$pdf->Cell(95, 3, utf8_decode('REPRESENTANTE LEGAL'), 0,'0','C');
$pdf->Cell(95, 3, utf8_decode('REPRESENTANTE LEGAL'), 0,'1','C');


$pdf->SetFont('Arial','',7);
$pdf->Cell(95, 3, utf8_decode(strtr(strtoupper($listarEmpresaPorId[0]['nombre_empresa']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 0,'0','C');
$pdf->Cell(95, 3, utf8_decode(strtr(strtoupper($listarClientePorId[0]['razon_social']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 0,'1','C');


$pdf->Output();
ob_end_flush();

?>