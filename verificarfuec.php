<?php
require('Resources/fuec/fpdf.php');
require('Modelo/Fuec.php');
require('Modelo/Conductor.php');
require('Modelo/Cliente.php');
require('Modelo/Contrato.php');
require('Modelo/Vehiculo.php');
require('Modelo/EmpresaEnt.php');
require('Modelo/TipoVehiculo.php');

$cod = $_GET['cod'];

$fuec = new Fuec();

$listar = $fuec->listarFuecPorCodComprobante($cod);

if(count($listar) < 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("No existe el numero de extracto");'; 
    echo 'window.location.href = "index.php";';
    echo '</script>';
}

$vehiculo = new Vehiculo();
$contrato = new Contrato();
$conductor = new Conductor();
$empresa = new Empresa();
$cliente = new Cliente();
$tipovehiculo = new TipoVehiculo();

$contratoid = $contrato->listarId($listar[0]['id_contrato']);
$vehiculoid = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$tipoid = $tipovehiculo->listarPorId($vehiculoid[0]['id_tipo_vehiculo']);

$empresaid = $empresa->listarPorId($contratoid[0]['id_empresa']);
$logo = $empresaid[0]['logo'];

$aprobacion = $fuec->Aprobacion($contratoid[0]['id_empresa']);
$clienteid = $cliente->cliente_ID($contratoid[0]['id_cliente']);

class PDF extends FPDF
{
// Cabecera de página
function Header()
{
    // Logo
    $this->Image('Resources/fuec/img/logo-vigilado-supertransporte.png',20,5,60);
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

$mintransporte = "Resources/fuec/img/logo-mintransporte.png";
$ort = "Resources/fpdf/img/".$logo;

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
$pdf->Cell(0,5,'No. '.$listar[0]['num_comprobante'],'R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,utf8_decode('Razón Social'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,$empresaid[0]['nombre_empresa'],'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$empresaid[0]['nit_empresa'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Contrato No.','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,$contratoid[0]['id_contrato'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Contratante','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,$clienteid[0]['razon_social'],'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'NIT','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$clienteid[0]['nit'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Objeto del Contrato','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,$contratoid[0]['objeto_contrato'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Origen - Destino','L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(155,5,$listar[0]['origen'].' - '.$listar[0]['destino'],'R',1,'L');
$pdf->Cell(35,5,'','L',0,'L');
$pdf->Cell(155,5,$listar[0]['ruta1'],'R',1,'L');
$pdf->Cell(35,5,'','L B',0,'L');
$pdf->Cell(155,5,$listar[0]['ruta2'],'R B',1,'L');

$tipoconvenio = '';
$tipoconsorcio = '';
$tipounion = '';
if($listar[0]['tipo_fuec'] == 'CONVENIO'){
    $tipoconvenio = 6;
} else if($listar[0]['tipo_fuec'] == 'CONSORCIO'){
    $tipoconsorcio = 6;
} else if($listar[0]['tipo_fuec'] == 'UNION TEMPORAL'){
    $tipounion = 6;
} 

$pdf->Cell(0,1,'','R L',1,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(18,5,'Convenio','L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,$tipoconvenio,1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(18,5,'Consorcio','L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,$tipoconsorcio,1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(28,5,utf8_decode('Unión Temporal'),'L',0,'L');
$pdf->SetFont('ZapfDingbats','', 9);
$pdf->Cell(5,5,$tipounion,1,0,'C');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(10,5,'Con:','',0,'L');
$pdf->Cell(101,5,$listar[0]['con_fuec'],'R',1,'L');
$pdf->Cell(0,1,'','R L B',1,'C');

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'VIGENCIA DEL CONTRATO','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$diainicio = date('d',strtotime($contratoid[0]['fecha_inicial_contrato']));
$mesinicio = date('m',strtotime($contratoid[0]['fecha_inicial_contrato']));
$yearinicio = date('Y',strtotime($contratoid[0]['fecha_inicial_contrato']));

$diafinal = date('d',strtotime($contratoid[0]['fecha_final_contrato']));
$mesfinal = date('m',strtotime($contratoid[0]['fecha_final_contrato']));
$yearfinal = date('Y',strtotime($contratoid[0]['fecha_final_contrato']));

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'','L B',0,'C');
$pdf->Cell(45,5,'DIA','L B',0,'C');
$pdf->Cell(45,5,'MES','L B',0,'C');
$pdf->Cell(45,5,utf8_decode('AÑO'),'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Inicial','L B',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$diainicio,'L B',0,'C');
$pdf->Cell(45,5,$mesinicio,'L B',0,'C');
$pdf->Cell(45,5,$yearinicio,'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Vencimiento','L B',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$diafinal,'L B',0,'C');
$pdf->Cell(45,5,$mesfinal,'L B',0,'C');
$pdf->Cell(45,5,$yearfinal,'L B R',1,'C');

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
$pdf->Cell(25,5,$vehiculoid[0]['placa'],'L B',0,'C');
$pdf->Cell(25,5,$vehiculoid[0]['modelo'],'L B',0,'C');
$pdf->Cell(70,5,$vehiculoid[0]['marca'],'L B',0,'C');
$pdf->Cell(70,5,$tipoid[0]['nombre_tipo_vehiculo'],'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'NUMERO INTERNO','L B',0,'C');
$pdf->Cell(140,5,'NUMERO DE TARJETA DE OPERACION','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$vehiculoid[0]['numero_movil'],'L B',0,'C');
$pdf->Cell(140,5,$vehiculoid[0]['num_tarjeta_operacion'],'L B R',1,'C');

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

$conductores = $vehiculo->listarConductoresPorId($listar[0]['id_vehiculo']);
$cant = count($conductores);

$restante = 4 - $cant;

if($cant > 0){
    $i = 1;
foreach($conductores as $cond){

$datos = $conductor->listarPorId($cond['id_conductor']);
$fechaven = date('d/m/Y',strtotime($datos[0]['fecha_vencimiento_licencia']));

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'CONDUCTOR '.$i,'L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,$datos[0]['nombre_conductor'],'L B',0,'C');
$pdf->Cell(30,5,$datos[0]['numero_documento_conductor'],'L B',0,'C');
$pdf->Cell(30,5,$datos[0]['num_licencia'],'L B',0,'C');
$pdf->Cell(25,5,$fechaven,'L B R',1,'C');

$i++;
}
}

while($restante > 0){
$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,5,'','L B',0,'C');
$pdf->SetFont('Arial','',9);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');
$restante--;
}

$pdf->SetFont('Arial','B',11);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'RESPONSABLE CONTRATANTE','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Nombre','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,$listar[0]['responsable'],'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'No. Cedula','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$listar[0]['idResponsable'],'B R',1,'L');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(35,5,'Direccion','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,$listar[0]['dirResponsable'],'B R',0,'L');
$pdf->SetFont('Arial','B',9);
$pdf->Cell(20,5,'Telefono','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$listar[0]['telResponsable'],'B R',1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(90,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
$pdf->Cell(90,4,'glpgerencia@ortsas.com','L R',1,'C');
$pdf->Cell(90,4,'Bogota - Colombia','L R',1,'C');

$codigo = $listar[0]['num_comprobante'];
$codigo1 = $listar[0]['num_interno'];
$qr = 'Resources/fuec/phpqrcode/codigos/'.$codigo.'.png';
$code39 = 'Resources/fuec/phpbarcode39/codigos/'.$codigo1.'.gif';

$sello = 'Resources/fuec/img/'.$aprobacion[0]['firma_fuec'];

$pdf->Cell(90,20,$pdf->Image($code39,$pdf->GetX()+4, $pdf->GetY()+1, 80),'B L R',1,'C');


$pdf->SetXY(100,217);
$pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R',0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R',1,'C');
$pdf->SetXY(130,222);
$pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
$pdf->SetXY(130,245);
$pdf->Cell(2,5,'','B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
$pdf->Cell(2,5,'','B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,3,'',0,1,'C');
$pdf->Cell(0,4,utf8_decode('* Se expide el presente FUEC, en cumplimiento de los requisitos establecidos en el artículo 8 de la Resolución 1069 de 2015,'),0,1,'L');
$pdf->Cell(0,4,utf8_decode('la Ley 527 de 1999 y el Decreto 2364 de 2012.'),0,1,'L');

$pdf->Output();

?>