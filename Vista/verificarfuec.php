<?php
ob_start();
require('../Resources/fuec/fpdf.php');
require('../Resources/fpdf-easytable-master/exfpdf.php');
require('../Resources/fpdf-easytable-master/easyTable.php');
require('../Modelo/Fuec.php');
require('../Modelo/Conductor.php');
require('../Modelo/Cliente.php');
require('../Modelo/Contrato.php');
require('../Modelo/Ciudad.php');
require('../Modelo/contratoOcasional.php');
require('../Modelo/UsuarioContratoOcasional.php');
require('../Modelo/Vehiculo.php');
require('../Modelo/EmpresaEnt.php');
require('../Modelo/TipoVehiculo.php');

$cod = $_GET['cod'];

$fuec = new Fuec();
$listar = $fuec->listarFuecPorCodComprobante($cod);

if(count($listar) < 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Se genero un error");'; 
    echo 'window.location.href = "inicio.php";';
    echo '</script>';
}

$vehiculo = new Vehiculo();
if($listar[0]['id_contrato'] != '0'){
    $contrato = new Contrato();
    $contratoid = $contrato->listarId($listar[0]['id_contrato']);
    $id_contrato = $listar[0]['id_contrato'];
    $objeto_contrato = $contratoid[0]['objeto_contrato'];
    $listarUsuariosPorContrato = array();
} else {
    $contrato = new ContratoOcasional();
    $contratoid = $contrato->listarPorId($listar[0]['id_contrato_ocasional']);
    $id_contrato = $listar[0]['id_contrato_ocasional'];
    $objeto_contrato = 'SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS';
    $usuarioContratoOcasional = new UsuarioContratoOcasional();
    $listarUsuariosPorContrato = $usuarioContratoOcasional->listarUsuariosPorContrato($id_contrato);
}

$conductor = new Conductor();
$empresa = new Empresa();
$cliente = new Cliente();
$tipovehiculo = new TipoVehiculo();

$vehiculoid = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$tipoid = $tipovehiculo->listarPorId($vehiculoid[0]['id_tipo_vehiculo']);

$empresaid = $empresa->listarPorId($contratoid[0]['id_empresa']);
$logo = $empresaid[0]['logo'];

$aprobacion = $fuec->Aprobacion($contratoid[0]['id_empresa']);
$clienteid = $cliente->cliente_ID($contratoid[0]['id_cliente']);

class PDF extends exFPDF
{
// Cabecera de página
    function Header()
    {
        
        $empresa = new Empresa();
        
        $fuec = new Fuec();
        $cod = $_GET['cod'];
        $listar = $fuec->listarFuecPorCodComprobante($cod);
        if($listar[0]['id_contrato_ocasional'] == 0){
            $contrato = new Contrato();
            $contratoid = $contrato->listarId($listar[0]['id_contrato']);
        } else {
            $contrato = new ContratoOcasional();
            $contratoid = $contrato->listarPorId($listar[0]['id_contrato_ocasional']);
        }
        $empresaid = $empresa->listarPorId($contratoid[0]['id_empresa']);
        $logo = $empresaid[0]['logo'];
        
        $this->Image('../Resources/fuec/img/logo-vigilado-supertransporte.png',20,5,60);

        $this->SetFont('Arial','B',11);
        $this->Cell(0,12,'',0,1,'C');
        $this->Cell(120,30,$this->Image('../Resources/fpdf/img/logo-mintransporte.png', $this->GetX()+5, $this->GetY()+10, 80),0,0,'C');
        $this->Cell(70,30,$this->Image("../Resources/fpdf/img/".$logo, $this->GetX()+12, $this->GetY()+1, 40),0,1,'C');
        // Arial bold 15
        $this->Ln(0);

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
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial','B',9);

$pdf->Cell(0,1,'',0,'1','C');
$pdf->Cell(0,4,'FORMATO UNICO DE EXTRACTO DEL CONTRATO DEL SERVICIO PUBLICO',0,'1','C');
$pdf->Cell(0,4,'DE TRANSPORTE TERRESTRE AUTOMOTOR ESPECIAL',0,'1','C');
$pdf->Cell(0,4,'No. '.$listar[0]['num_comprobante'],0,'1','C');
$pdf->Cell(0,5,'',0,'1','C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(87,4,utf8_decode('RAZÓN SOCIAL DE LA EMPRESA DE TRANSPORTE ESPECIAL: '),0,0,'L');
$pdf->SetFont('Arial','',8);

if($listar[0]['id_contrato'] == '156'){
    $pdf->Cell(103,4,utf8_decode('UNION TEMPORAL SDIS KV'),0,1,'L');
} else {
    $pdf->Cell(103,4,utf8_decode($empresaid[0]['nombre_empresa']),0,1,'L');
}

$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,4,'NIT:',0,0,'');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4,$empresaid[0]['nit_empresa'],0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,4, utf8_decode('ID FUEC:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4, $listar[0]['id_fuec'],0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(36,4,utf8_decode('CONTRATO INTERNO N°:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4, str_pad($id_contrato, 4, "0", STR_PAD_LEFT),0,1,'L');

if($contratoid[0]['numero_contrato'] != ''){ 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(46,4,utf8_decode('N° OPERACIÓN Y/O CONTRATO:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4, $contratoid[0]['numero_contrato'],0,1,'L');
$pdf->SetFont('Arial','',8);
} 

$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,5,'CONTRATANTE:',0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,5,utf8_decode($clienteid[0]['razon_social']),0,1,'L');


$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,4,'NIT/CC:',0,0,'');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4,$clienteid[0]['nit_cliente'],0,1,'L');

$table = new easyTable($pdf, '%{19,81}', 'font-size: 8; font-family:Arial;');
$table->easyCell('OBJETO CONTRATO:', 'font-style:B;');
$table->easyCell(utf8_decode($objeto_contrato));

$table->printRow();
$table->endTable(0);

$pdf->SetFont('Arial','',8);
if($listar[0]['origen'] != $listar[0]['destino']){
   $table = new easyTable($pdf, '{35, 155}', 'font-size: 8; font-family:Arial;');
        $table->easyCell('ORIGEN - DESTINO:', 'font-style:B;');
        $table->easyCell(utf8_decode($listar[0]['origen']) .' - '. utf8_decode($listar[0]['destino']).' Y VICEVERSA.');

        $table->printRow();
    $table->endTable(0);
} else {
    $table = new easyTable($pdf, '{35, 155}', 'font-size: 8; font-family:Arial;');
        $table->easyCell('ORIGEN - DESTINO:', 'font-style:B;');
        $table->easyCell(utf8_decode($listar[0]['origen']) .' - '. utf8_decode($listar[0]['destino'] . " Y VICEVERSA."));

        $table->printRow();
    $table->endTable(0);
}
$pdf->ln(1);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(46,5,utf8_decode('CONVENIO DE COLABORACIÓN:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(134,5,$listar[0]['con_fuec'],0,1,'L');
$pdf->Cell(0,5,'',0,'1','C');


$pdf->Cell(0,4,'',0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,1,'',0,'1','C');
$pdf->Cell(0,4,'VIGENCIA DEL CONTRATO',0,'1','C');
$pdf->Cell(0,4,'',0,'1','C');

if($listar[0]['id_contrato_ocasional'] != '0'){
    $fechaInicialContrato = explode("-", $contratoid[0]['fecha_inicial_contrato_ocasional']);

    $yearinicio = $fechaInicialContrato[0];
    $mesinicio = $fechaInicialContrato[1];
    $diainicio = $fechaInicialContrato[2];

    $fecha2 = $contratoid[0]['fecha_final_contrato_ocasional'];

} else {
    $diainicio = date('d',strtotime($listar[0]['fecha_inicial_fuec']));
    $mesinicio = date('m',strtotime($listar[0]['fecha_inicial_fuec']));
    $yearinicio = date('Y',strtotime($listar[0]['fecha_inicial_fuec']));

    $fecha_actual = date('Y-m-d');
    //sumo 1 mes
    $fecha2 = date("Y-m-d",strtotime($fecha_actual."+ 3 month"));
}

$docsVencidosVehiculo = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($listar[0]['id_vehiculo']);

//print_r($docsVencidosVehiculo);

$fechaProxima = $fecha2;

//RP//
foreach ($listarConductoresPorVehiculo as $lcpv) {
    if ($lcpv['fecha_vencimiento_licencia'] < $fechaProxima) {
        $fechaProxima = $lcpv['fecha_vencimiento_licencia'];
    }
}

if ($docsVencidosVehiculo[0]['fecha_vencimiento_rp'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_rp'];
    
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_to'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_to'];
    
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_soat'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_soat'];   
    
}
if($listar[0]['id_contrato_ocasional'] == 0){
    if ($contratoid[0]['fecha_final_contrato'] < $fechaProxima) {
        $fechaProxima = $contratoid[0]['fecha_final_contrato'];
    }
}
if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];
    //echo '5';
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];
    //echo '6';
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
    //echo '7';
}if ($dispositivo_velocidad < $fechaProxima) {
    $fechaProxima = $dispositivo_velocidad;
    //echo '8';
}

$diafinal = date('d',strtotime($fechaProxima));
$mesfinal = date('m',strtotime($fechaProxima));
$yearfinal = date('Y',strtotime($fechaProxima));

if($listar[0]['id_contrato_ocasional'] == '0'){
    $diafinal = date('d',strtotime($listar[0]['fecha_final_fuec']));
    $mesfinal = date('m',strtotime($listar[0]['fecha_final_fuec']));
    $yearfinal = date('Y',strtotime($listar[0]['fecha_final_fuec']));
}

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Inicial','L B T',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$diainicio,'L B T',0,'C');
$pdf->Cell(45,5,$mesinicio,'L B T',0,'C');
$pdf->Cell(45,5,$yearinicio,'L B R T',1,'C');

$pdf->SetFont('Arial','B',9);

$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));

if ($dispositivo_velocidad < $fechaProxima) {
    $fechaProxima = $dispositivo_velocidad;
}else{
    $fechaProxima = $fecha2;
}

$pdf->Cell(55,5,'Fecha Vencimiento','L B',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$diafinal,'L B',0,'C');
$pdf->Cell(45,5,$mesfinal,'L B',0,'C');
$pdf->Cell(45,5,$yearfinal,'L B R',1,'C');


$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,3,'',0,'1','C');
$pdf->Cell(0,5,'CARACTERISTICAS DEL VEHICULO',0,'1','C');
$pdf->Cell(0,3,'',0,'1','C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(25,4,'PLACA','L B T',0,'C');
$pdf->Cell(25,4,'MODELO','L B T',0,'C');
$pdf->Cell(70,4,'MARCA','L B T',0,'C');
$pdf->Cell(70,4,'CLASE','L B R T',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(25,4,$vehiculoid[0]['placa'],'L B',0,'C');
$pdf->Cell(25,4,$vehiculoid[0]['modelo'],'L B',0,'C');
$pdf->Cell(70,4,$vehiculoid[0]['marca'],'L B',0,'C');
$pdf->Cell(70,4,$tipoid[0]['nombre_tipo_vehiculo'],'L B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(50,5,'NUMERO INTERNO','L B',0,'C');
$pdf->Cell(140,5,'NUMERO DE TARJETA DE OPERACION','L B R',1,'C');

$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$vehiculoid[0]['numero_movil'],'L B',0,'C');
$pdf->Cell(140,5,$vehiculoid[0]['num_tarjeta_operacion'],'L B R',1,'C');


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

$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,'CONDUCTOR '.$i,'L B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,utf8_decode($datos[0]['nombre_conductor']),'L B',0,'C');
$pdf->Cell(30,5,$datos[0]['numero_documento_conductor'],'L B',0,'C');
$pdf->Cell(30,5,$datos[0]['num_licencia'],'L B',0,'C');
$pdf->Cell(25,5,$fechaven,'L B R',1,'C');

$i++;
}
}

$pdf->SetFont('Arial','B',10);


while($restante > 0){
$pdf->SetFont('Arial','B',8);
$pdf->Cell(25,5,'','L B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(80,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(30,5,'','L B',0,'C');
$pdf->Cell(25,5,'','L B R',1,'C');
$restante--;
}

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,1,'','R L','1','C');
$pdf->Cell(0,5,'RESPONSABLE CONTRATANTE','R L','1','C');
$pdf->Cell(0,1,'','R L B','1','C');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5,'NOMBRE','B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,utf8_decode($listar[0]['responsable']),'B R',0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5, utf8_decode('N° CEDULA'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$listar[0]['idResponsable'],'B R',1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(35,5, utf8_decode('DIRECCIÓN'),'B L',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(85,5,utf8_decode($listar[0]['dirResponsable']),'B R',0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5,'TELEFONO','B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$listar[0]['telResponsable'],'B R',1,'L');


$pdf->SetXY(10,232);
$pdf->SetFont('Arial','B',7);
$pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
$pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
$pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');

$codigo = $listar[0]['num_comprobante'];
$codigo1 = $listar[0]['num_interno'];

$qr = '../Resources/fuec/phpqrcode/codigos/'.$codigo.'.png';
//$code39 = '../Resources/fuec/phpbarcode39/codigos/'.$codigo1.'.gif';
$sello = '../Resources/fuec/img/'.$aprobacion[0]['firma_fuec'];

$pdf->Cell(90,20,$pdf->Code39($pdf->GetX()+3, $pdf->GetY()+3, $codigo1 ,1,9),'B L R',1,'C');

$pdf->SetXY(100,232);
$pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
$pdf->SetXY(130,237);
$pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
$pdf->SetXY(130,260);
$pdf->Cell(2,5,'','B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
$pdf->Cell(2,5,'','B R',1,'C');

$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,3,'',0,1,'C');
$pdf->Cell(0,4,utf8_decode('* Se expide el presente FUEC, en cumplimiento de los requisitos establecidos en el artículo 8 de la Resolución 1069 de 2015,'),0,1,'L');
$pdf->Cell(0,4,utf8_decode('la Ley 527 de 1999 y el Decreto 2364 de 2012.'),0,1,'L');

$pdf->AddPage();
    
$pdf->Image('../Resources/fuec/img/SKMBT_22319123016050_002.png',0,0,210);

if (count($listarUsuariosPorContrato) > 0) {

$pdf->AddPage();

$pdf->Cell(190, 15,'', 0,'1','C');
$pdf->Cell(190, 5, utf8_decode('ANEXO SERVICIO DE TRANSPORTE ESPECIAL DE PASAJEROS CON GRUPO ESPECÍFICO DE USUARIOS'), 0,'1','C');
$pdf->Cell(190, 5, utf8_decode('FUEC N° ') . $listarFuecPorId[0]['num_comprobante'], 0,'1','C');
$pdf->Cell(190, 15,'', 0,'1','C');

$pdf->Cell(95, 5,'NOMBRE USUARIO', 0,'0','C');
$pdf->Cell(95, 7,utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 0,'1','C');


$pdf->Cell(190, 3,'', 0,'1','C');

//23//

$cant = count($listarUsuariosPorContrato);
$restante = 23 - $cant;

    $pdf->SetFont('Arial','',9);
if($cant > 0){
    $i = 1;
    foreach($listarUsuariosPorContrato as $luco){
    $pdf->Cell(95,5,utf8_decode($luco['nombre_usuario']), 0,0,'C');
    $pdf->Cell(95,5,$luco['numero_documento'], 0,1,'C');

    $i++;
    }
}

while($restante > 0){
    $pdf->SetFont('Arial','',9);
    $pdf->Cell(190, 5, utf8_decode(), 0,'1','C');

    $restante--;
}
}

$pdf->Output();
?>