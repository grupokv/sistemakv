<?php
include("../Controlador/Sesion/autenticar.php");
require('../Resources/fuec/fpdf.php');
require('../Resources/fpdf-easytable-master/exfpdf.php');
require('../Resources/fpdf-easytable-master/easyTable.php');
require('../Modelo/Fuec.php');
require('../Modelo/Conductor.php');
require('../Modelo/Cliente.php');
require('../Modelo/Contrato.php');
require('../Modelo/Vehiculo.php');
require('../Modelo/EmpresaEnt.php');
require('../Modelo/TipoVehiculo.php');

$cod = $_GET['id'];

$fuec = new Fuec();
//$cod = base64_decode($cod);

$listar = $fuec->listarFuecPorId($cod);

if(count($listar) < 1) {
    echo '<script type="text/javascript">'; 
    echo 'alert("Se genero un error");'; 
    echo 'window.location.href = "inicio.php";';
    echo '</script>';
}

$vehiculo = new Vehiculo();
$contrato = new Contrato();
$conductor = new Conductor();
$empresa = new Empresa();
$cliente = new Cliente();
$tipovehiculo = new TipoVehiculo();

$contratoid = $contrato->listarId($listar[0]['id_contrato']);
$listarUsuariosPorContratoFijo = $contrato->listarUsuariosPorContrato($listar[0]['id_contrato']);

$vehiculoid = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$tipoid = $tipovehiculo->listarPorId($vehiculoid[0]['id_tipo_vehiculo']);

$empresaid = $empresa->listarPorId($contratoid[0]['id_empresa']);
$logo = $empresaid[0]['logo'];

$aprobacion = $fuec->Aprobacion($contratoid[0]['id_empresa']);
$clienteid = $cliente->cliente_ID($contratoid[0]['id_cliente']);

$listarUsuariosPorContrato = $contrato->listarUsuariosPorContrato($listar[0]['id_contrato']);

//print_r($empresaid);

class PDF extends exFPDF
{
// Cabecera de página
function Header()
{
   /*

    // Logo
    $this->Cell(0,20,'',0,1,'C');
    $this->Cell(120,30,$this->Image($mintransporte, $this->GetX()+5, $this->GetY()+5, 110),1,0,'C');
    $this->Cell(70,30,$this->Image($ort, $this->GetX()+12, $this->GetY()+1, 45),'B T R',1,'C');*/

    // Arial bol
    // d 15
    
    $empresa = new Empresa();
    $contrato = new Contrato();
    $fuec = new Fuec();

    $cod = $_GET['id'];
    //$cod = base64_decode($cod);
    $listar = $fuec->listarFuecPorId($cod);

    $contratoid = $contrato->listarId($listar[0]['id_contrato']);
    $empresaid = $empresa->listarPorId($contratoid[0]['id_empresa']);
    $logo = $empresaid[0]['logo'];
    
    $this->Image('../Resources/fuec/img/logo-vigilado-supertransporte.png',20,5,60);

    $this->SetFont('Arial','B',11);
    $this->Cell(0,20,'',0,1,'C');
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



// Creación del objeto de la clase heredada
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
    $pdf->Cell(103,4,utf8_decode($empresaid[0]['nombre_empresa']),0,1,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(24,4,'NIT:',0,0,'');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(166,4,$empresaid[0]['nit_empresa'],0,1,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(24,4,'CONTRATO No:',0,0,'L');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(166,4, str_pad($contratoid[0]['id_contrato'], 4, "0", STR_PAD_LEFT),0,1,'L');

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
            $table->easyCell(utf8_decode($contratoid[0]['objeto_contrato'] ));

            $table->printRow();
        $table->endTable(0);

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(35,5,'ORIGEN - DESTINO:',0,0,'L');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(155,5, utf8_decode($listar[0]['origen']) .' - '. utf8_decode($listar[0]['destino']),0,1,'L');

    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(46,5,utf8_decode('CONVENIO DE COLABORACIÓN:'),0,0,'L');
    $pdf->Cell(134,5,$listarFuecPorId[0]['con_fuec'],0,1,'L');


    /********************************/


$pdf->Cell(0,4,'',0,1,'L');

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,1,'',0,'1','C');
$pdf->Cell(0,4,'VIGENCIA DEL CONTRATO',0,'1','C');
$pdf->Cell(0,4,'',0,'1','C');

$diainicio = date('d',strtotime($listar[0]['fecha_creacion']));
$mesinicio = date('m',strtotime($listar[0]['fecha_creacion']));
$yearinicio = date('Y',strtotime($listar[0]['fecha_creacion']));

$fecha_actual = date('Y-m-d');
//sumo 1 mes
$fecha2 = date("Y-m-d",strtotime($fecha_actual."+ 3 month"));


$docsVencidosVehiculo = $vehiculo->listarPorId($listar[0]['id_vehiculo']);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($listar[0]['id_vehiculo']);

//print_r($docsVencidosVehiculo);

$fechaProxima = $fecha2;

/*RP*/

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
}if ($contratoid[0]['fecha_final_contrato'] < $fechaProxima) {
    $fechaProxima = $contratoid[0]['fecha_final_contrato'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fechaProxima) {
    $fechaProxima = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
}if ($dispositivo_velocidad < $fechaProxima) {
    $fechaProxima = $dispositivo_velocidad;
}



$diafinal = date('d',strtotime($fechaProxima));
$mesfinal = date('m',strtotime($fechaProxima));
$yearfinal = date('Y',strtotime($fechaProxima));

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
$pdf->SetFont('Arial','B',8);
$pdf->Cell(90,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
$pdf->Cell(90,4,'glpgerencia@ortsas.com','L R',1,'C');
$pdf->Cell(90,4,'Bogota - Colombia','L R',1,'C');

$codigo = $listar[0]['num_comprobante'];
$codigo1 = $listar[0]['num_interno'];

$qr = '../Resources/fuec/phpqrcode/codigos/'.$codigo.'.png';
$code39 = '../Resources/fuec/phpbarcode39/codigos/'.$codigo1.'.gif';

$sello = '../Resources/fuec/img/'.$aprobacion[0]['firma_fuec'];

$pdf->Cell(90,18,$pdf->Image($code39,$pdf->GetX()+4, $pdf->GetY()+1, 80),'B L R',1,'C');


$pdf->SetXY(100,232);
$pdf->Cell(30,31,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
$pdf->SetXY(130,237);
$pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
$pdf->SetXY(130,260);
$pdf->Cell(2,3,'','B',0,'C');
$pdf->SetFont('Arial','',8);
$pdf->Cell(66,3,'FIRMA Y SELLO','B T',0,'C');
$pdf->Cell(2,3,'','B R',1,'C');


$pdf->SetFont('Arial','B',9);
$pdf->Cell(0,3,'',0,1,'C');
$pdf->Cell(0,4,utf8_decode('* Se expide el presente FUEC, en cumplimiento de los requisitos establecidos en el artículo 8 de la Resolución 1069 de 2015,'),0,1,'L');
$pdf->Cell(0,4,utf8_decode('la Ley 527 de 1999 y el Decreto 2364 de 2012.'),0,1,'L');


if ($listar[0]['anexo'] == 'S') {
    
    $pdf->AddPage();


    $pdf->Cell(190, 15,'', 0,'1','C');
    $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listar[0]['num_comprobante'], 0,'1','C');
    $pdf->Cell(190, 15,'', 0,'1','C');

    if($listar[0]['id_contrato'] == 65){
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Cajica-Chia,Cota,Funza,Mosquera,Facatativa-Bogota-Soacha-Charquito-Sibate y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Nemocon-Suesca-Sesquile-Macheta, Manta, Somondoco, Guateque y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Tausa-Sutatausa-Ubate-Chiquinquira y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Pacho-El Peñon-Talauta-La Palma-Caparrapi-Cachipay y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Tocancipa-Gachancipa-Suesca-Sesquile-Guatavita-Choconta-Villapinzon-Ventaquemada-Tunja-Combita-Paipa-Duitama-Sogamoso'), 'R,L,T','1','F');
        $pdf->Cell(7, 5, '', 'R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('y Viceversa'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '6', 'TR,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Briceño-Sopo-La Calera-Guasca y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Tausa-Sutatausa-Ubate-Guacheta-Chiquinquira-Raquira-Sutamarchan-Villa de Leyva y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Cogua-Plazuela,Neusa y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '9', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Cajica-Tabio-Subachoque-Cota-Siberia-Calle 80-El Rosal-Villeta-La Vega-La Peña y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '10', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Cota-Funza-Mondoñedo-Fusagasuga-Arbelaez-Melgar-Girardot y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '11', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquira-Cajica-Briceño-Sopo-Meuza-La Calera-El Salitre-Guasca-El Amoladero-Sueva-Gacheta-San Juan-Gama-Ubala-Guavio-Gachala'), 'T,R,L','1','F');
        $pdf->Cell(7, 5, '', 'R,L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('y Viceversa'), 'R,L,B','1','F');

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

        $pdf->AddPage();

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listar[0]['num_comprobante'], 0,'1','C');
        $pdf->Cell(190, 15,'', 0,'1','C');

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(95, 5,'NOMBRE USUARIO', 0,'0','C');
        $pdf->Cell(95, 7,utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 0,'1','C');


        $pdf->Cell(190, 3,'', 0,'1','C');

        /*23*/

        $cant = count($listarUsuariosPorContratoFijo);
        $restante = 23 - $cant;

            $pdf->SetFont('Arial','',8);
        if($cant > 0){
            $i = 1;
            foreach($listarUsuariosPorContratoFijo as $luco){
            $pdf->Cell(95,5,utf8_decode($luco['nombre_usuario']), 0,0,'C');
            $pdf->Cell(95,5,$luco['numero_documento'], 0,1,'C');

            $i++;
            }
        }

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    }else if($listar[0]['id_contrato'] == 61){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Traslados en Bogotá y Aeropuerto'), 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, La calera, Guasca, Tomine y Viceversa.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Mosquera, Tena La Gran Via, La Mesa, Anapoima y Viceversa.'), 'R,L','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Autopista Norte, Chia, Tocancipa, Sesquile y Viceversa.'), 1,'1','F');
    
    }else if($listar[0]['id_contrato'] == 84){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Soacha, Fusagasugá, Pandi, Melgar, Girardot, Variante Espinal, El Prado, Ibagué, Cajamarca, Armenia, Bugalagrande, Tulua, Municipios -'), 'L,R','1','F');
        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Circunvecinos, Cali o Viceversa.'), 'L,R','1','F');
        $pdf->Cell(7, 5, '2', 'T, L, R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, La Vega, Villeta, Guaduas, Honda, Fresno, Letras, Manizales, Santa Rosa de Cabal, Dos Quebradas, Pereira, Cartago, Bugalagrande,'), 'R,L,T','1','F');
        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode(' Tulua, Municipios Circunvecinos, Cali y Viceversa.'), 'L,R,B','1','F');
    
    }else if(($listar[0]['id_contrato'] == 10) || ($listar[0]['id_contrato'] == 37) || ($listar[0]['id_contrato'] == 38) || ($listar[0]['id_contrato'] == 39) || ($listar[0]['id_contrato'] == 40)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');


        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - NEMOCÓN.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - VILLA DE LEYVA.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - PIAPA.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - GUATAVITA.'), 'R,L,B','1','F'); 


        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - NEIVA.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - FACATATIVA.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - MESITAS DEL COLEGIO.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - VILLAVICENCIO.'), 'R,L,B','1','F'); 


        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA OCCIDENTE', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - AEROPUERTO.'), 'R,L,B','1','F'); 
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - VILLETA.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - ZIPAQUIRA.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - FACATATIVA.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - IBAGUE.'), 'R,L,B','1','F'); 

        
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - GUATAVITA.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - FOMEQUE.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - SESQUILE.'), 'R,L,B','1','F');

    }else if($listar[0]['id_contrato'] == 81){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Soacha, Chusaca, Granada, Silvania, Fusagasuga, Melgar, Girardot y Viceversa.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Funza, Mosquera, Mondoñedo, Tena, La Mesa, Anapoima, Apulo, Tocaima, Girardot y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Soacha, Sibate, Santandercito, Tequendama, La Victoria, Pradilla, Mesita, El Triunfo, Anapoima, Viota, Tocaima, Girardot y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Funza, Mosquera, Madrid, Bojaca, Zipacon, Cachipay, Cartegenita, Facatativa, Alban, Villeta, Sasaima y Viceversa.'), 'R,L,B','1','F'); 
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Chipaque, Une, Abasticos, Caqueza, Fosca, Gutierrez, Guayabetal y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, La calera, Guasca, Guatavita, Sesquile y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Choachi, La Union, Fomeque, Ubaque y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Chia, Cajica, Zipaquirá, Cogua, Ubate y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '9', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Chia, Sopo, Briceño, Tocancipa, Gachancipa, Choconta, Villapinzon y Viceversa.'), 'R,L,B','1','F');
        $pdf->Cell(7, 5, '10', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, Siberia, Cota, Tabio, Tenjo, Subachoque, El Rosal, El Vino, San Francisco, La Vega, Villeta y Viceversa.'), 'R,L,B','1','F');
    
    }else if($listar[0]['id_contrato'] == 90){ 
        
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Chia, Cajica, Tenjo, Zipaquirá, Nemocón.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chochontá, Sesquile, Puente de Boyacá, Villa de Leyva.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Tocancipa, Tierra Negra, Chochotá, Tunja, Paipa.'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Sopo, Guatavita, devolviéndonos via La Calera.'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Cajica, Zipaquirá, Ubaté, Capellanía, Simijaca, Chiquinquirá, Ráquira, Sutamarchán, Villa de Leyva.'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chocontá, Sesquile, Puente de Boyacá, Tunja, Villa de Leyva.'), 1,'1','F');

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');
        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Soacha, Viota, Granada, Silvania, Fusagasuga, Melgar, Carmen de Apicala, Girardot, Espinal, Guamo, Saldaña, Castilla'), 'L,R','1','F');
        $pdf->Cell(7, 5, '', 'B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Villavieja, Tatacoa, Neiva.'), 'L,R','1','F');

        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Madrid, Bojaca, Facatativa.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Mondoñedo, Gran Via, El Triunfo, La Mesa, Mesitas del Colegio.'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Mondoñedo, Soacha, Salto de Tequendama, Mesitas del Colegio.'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Avenida Boyaca, Avenida Caracas, Usme, Chipaque, Puente Quetame, Guayabetal, Pipiral, Villavicencio - Restrepo - Acacias - Granada - '), 'T,R,L','1','F');
        $pdf->Cell(7, 5, '', 'B,R,L','0','C');
        $pdf->Cell(183, 5, utf8_decode('Fuente de Oro - Puerto Lopez (Meta). '), 'B,R,L','1','F');
        
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA OCCIDENTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Sobachoque, El Rosal, Alto del Vino, San Francisco, La Vega, Utica, Villeta.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Cota, Chia, Cajica, Zipaquira. '), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Funza, Mosquera, Madrid, Bojaca, Facatativa.'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Call 13, Funza, Mosquera, Madrid, Bojaca, Facatativa.'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Mosquera, La Mesa, Tocaima, Anapoima, Girardot, Flandes, Gualanday, Ibagué.'), 1,'1','F');

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Patios, La Calera, Guasca, Guatavita, Sesquile.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Avenida Circunvalar, Monserrate, Choachi, Ubaque, Fomeque.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Sopo, Guasca, Guatavita, Sesquile.'), 1,'1','F');


        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else if($listar[0]['id_contrato'] == 91){
        
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Chia, Tenjo, Tabio, Zipaquira, Nemocón.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Chocontá, Sesquile, Puente de Boyacá, Samaca, Villa de Leyva.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Tocancipa, Tierra Negra, Choconta, Tunja, Paipa.'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Sopo, Guatavita, devolviéndonos via La Calera.'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Cajica, Zipaquirá, Ubaté, Capellanía, Simijaca, Chiquinquirá, Ráquira, Sutamarchán, Villa de Leyva.'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Cajica, Tocancipa, Gachancipa, Chocontá, Sesquile, Puente de Boyacá, Tunja, Villa de Leyva.'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Villavicencio - Bogotá'), 1,'1','F');


        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');
        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Soacha, Granada, Silvania, Fusagasuga, Melgar, Girardot.'), 'L,R','1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Mondoñedo, Gran Via, El Triunfo, La Mesa, Mesitas del Colegio.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Mondoñedo, Soacha, Salto de Tequendama, Mesitas del Colegio.'), 1,'1','F');
        
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA OCCIDENTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Sobachoque, El Rosal, Alto del Vino, San Francisco, La Vega, Utica, Villeta.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Cota, Chia, Cajica, Zipaquira.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Funza, Mosquera, Madrid, Bojaca, Facatativa.'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Mosquera, La Mesa, Anapoima, Tocaima, Girardot, Flandes, Gualanday, Ibagué.'), 1,'1','F');

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Patios, La Calera, Guasca, Guatavita, Sesquile.'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Avenida Circunvalar, Monserrate, Choachi, Ubaque, Fomeque.'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Sopo, Guasca, Guatavita, Sesquile.'), 1,'1','F');


        $pdf->SetXY(10,235);
        $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
        $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

        $pdf->SetXY(120,235);
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R T',1,'C');
        $pdf->SetXY(120,240);
        $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
        $pdf->SetXY(120,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');

    } else {

    $pdf->SetFont('Arial','',8);

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Chia, Cajica, Tenjo, Tabio, Zipaquirá, Nemocón, Suesca, Sopo, Aposentos, Neusa, Siecha, Guasca, Guatavita.'), 1,'1','F');
    $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chochontá, Villapinzon, Turmequé, Ramiriqui, Samaca, Sachica, Villa de Leyva, Soraca,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Tunja, Combita, Tuta, Sotaquira, Paipa, Duitama, Nobsa, Sogamoso, Mongui, Mongua '), 'B,R,L','1','F');

    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Bogotá, La Calera, Santa Isabel, Siecha, Guasca, Meusa, Sopo, Tocancipa, Aposentos, Chia.'), 1,'1','F');
    $pdf->Cell(7, 5, '4', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Cajica, Zipaquirá, Chochota, Tunja, Duitama, Cerinza, Susacon, Soata, Boavita, Uvita, Guacamayas, San Ignacio, El cocuy, Guican'), 1,'1','F');
    $pdf->Cell(7, 5, '6', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chocontá, Sesquile, Puente de Boyacá, Tunja, Villa de Leyva.'), 1,'1','F');

    
    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');

    $pdf->Cell(7, 5, '1', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Soacha, Viota, Granada, Silvania, Fusagasuga, Melgar, Girardot, Mosquera, Madrid, Facatativa, La gran via, La mesa,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Mesitas el colegio, Anapoima, Apulo, Tocaima, Agua de Dios, Nilo, Ricaurte, Espinal, Guamo, Saldaña, Purificación, Murillo, Natagaima, '), 'R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Yeguera, Guacirco, Forcalacillas, Buziraco, Neiva.'), 'B,R,L','1','F');



    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Madrid, Bojaca, Facatativa, Zipacon, Cachipay, El Ocaso, La Esperanza, La Gran Via, La Mesa.'), 1,'1','F');
    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Mondoñedo, Gran Via, El Triunfo, La Mesa, Mesitas del Colegio.'), 1,'1','F');
    
    $pdf->Cell(7, 5, '4', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Espinal, Ibagué, Coello Cocora, Cajamarca, Calarca, Armenia, Circasia, Salento, Montenegro, El Meson,'), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Parque del café, La Tebaida, Panaca, Pueblo Tapado, Parque los Arrieros, La Paila, Bugalagrande, Andalucia, Tulua, Buga, Guacari,'), 'R,L','1','F');
    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('El Cerrito, Palmira, Yumbo, Cali.'), 'B,R,L','1','F');


    $pdf->Cell(7, 5, '5', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Ibagué, Armenia, Circasia, Salento, El Manzano, La Ye, Huertas, Pereira, Dos Quebradas, La Unión, '), 'T,R,L','1','F');
    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Renacimiento, Santa Rosa de Cabal, Termales de Santa Rosa de Cabal.'), 'B,R,L','1','F');
    $pdf->Cell(7, 5, '6', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Usme, Chipaque, Puente Quetame, Guayabetal, Pirapal, Villavicencio, Restrepo, Acacias, Granada, Fuente de oro, Puerto Lopez.'), 1,'1','F');

    
    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Sobachoque, El Rosal, Alto del Vino, San Francisco, La Vega, Utica, Villeta.'), 1,'1','F');
    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Cota, Chia, Cajica, Zipaquira. '), 1,'1','F');
    $pdf->Cell(7, 5, '3', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 80, Madrid, San Franciso, La Vega, Villeta, Guaduas, Cachipai, Puerto Vargas, La Dorada, El Guamo, Puerto Boyaca, '), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Puerto Nare, Garrapata, Puerto Araujo, Dagota, Villa Nueva Lebrija, Bucaramanga, Rio Negro, El Playón.'), 'R,L','1','F');

    $pdf->Cell(7, 5, '4', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Cajica, Sopo, Tocancipa, El Sisga, Choconta, Villa Pinzon, Ventaquemada, Tunja, Arcabuco, Socorro, San Gil, Curiti, Aratoca, Piedecuesta,'), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Parcela, Florida Blanca, Bucaramanga, Aguachica, Pailitas San Alberto, Urumita, Barrancas Albania, La Guajira, Maicao, Riohacha.'), 'R,L','1','F');



    $pdf->Cell(7, 5, '5', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Mosquera, La Mesa, Tocaima, Anapoima, Girardot, Flandes, Gualanday, Ibagué.'), 1,'1','F');


    
    $pdf->SetFont('Arial','B',8);

    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,235);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R',1,'C');
    $pdf->SetXY(120,240);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,263);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');
   

    $pdf->addPage();

     $pdf->Cell(0, 15, utf8_decode(''), 0,'1','F');


    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Villeta, Guaduas, Honda, La Dorada, Puerto Boyaca, Puerto Araujo, Yarima, Barrancabermeja, San Alberto, San Martin, Los Angeles,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Aguachica, Pailita, San Roque, La Aurora, La Loma, Cuatro Vientos La Esperanza, Bosconia, El Copel, San Tomas Tucuringa, Guamachito,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('La Isabel, Gaira, Rodadero, Playa Blanca, Santa Marta, Taganga, Bahia Concha, Gairaca.'), 'R,L','1','F');

    $pdf->Cell(7, 5, '2', 'T,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Madrid, Villeta, Guaduas, La Dorada, Doradal, Rio Negro, Envigado, Guatape, Pueblito Paisa, San Rafael, San Carlos, Santa Rosa de Osos,'), 'T,R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Yarumal, Valdivia, Monte libano, Alto Genoba, Monteria, San Pelayo, San Pues, Lorica, Sincelejo, Santiago de Tolú, San Onofre,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Carmen de Bolivar, San Juan, Nepomuceno, Arjona, Turbaco, Cartagena, La Boquilla, Clemencia, Luruaco, Sabana Larga, Calamar, Barranquilla,'), 'R,L','1','F');

    $pdf->Cell(7, 5, '', 'B,R,L','0','C');
    $pdf->Cell(183, 5, utf8_decode('Cienaga, Gaira, Minca, Buritacá, Palomino, Dibulla, Camarones, Riohacha'), 'B,R,L','1','F');


    $pdf->Cell(7, 5, '', 1,'0','C');
    $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');
    $pdf->Cell(7, 5, '1', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Patios, La Calera, Guasca, Guatavita, Sesquile.'), 1,'1','F');
    $pdf->Cell(7, 5, '2', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Avenida Circunvalar, Monserrate, Choachi, Ubaque, Fomeque'), 1,'1','F');
    $pdf->Cell(7, 5, '3', 1,'0','C');
    $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Sopo, Guasca, Guatavita, Sesquile.'), 1,'1','F');

    $pdf->Cell(110, 2, '', 'L,R','0','F');
    $pdf->Cell(80, 2, '', 'R','1','F');

    
    $pdf->SetFont('Arial','B',8);

    $pdf->Cell(110,5,'Calle 73 No. 75 - 55 Bogota PBX 5559260/61/65','L R',1,'C');
    $pdf->Cell(110,4,'glpgerencia@ortsas.com','L R',1,'C');
    $pdf->Cell(110,4,'Bogota - Colombia','L R',1,'C');
    $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

    $pdf->SetXY(120,137);
    $pdf->SetFont('Arial','B',8);
    $pdf->Cell(80,5,'REPRESENTANTE LEGAL O GERENTE', 'R',1,'C');
    $pdf->SetXY(120,142);
    $pdf->Cell(80,23,$pdf->Image($sello,$pdf->GetX()+15, $pdf->GetY()+3, 50), 'R', 1, 'C');
    $pdf->SetXY(120,165);
    $pdf->Cell(2,5,'','B',0,'C');
    $pdf->SetFont('Arial','',8);
    $pdf->Cell(76,5,'FIRMA Y SELLO', 'T,B',0,'C');
    $pdf->Cell(2,5,'','B R',1,'C');
    }
}


    if (count($listarUsuariosPorContrato) > 0) {

        $pdf->AddPage();

        $pdf->SetFont('Arial','B',10);
        $pdf->Cell(190, 15,'', 0,'1','C');
        $pdf->Cell(190, 5, utf8_decode('ANEXO FUEC N° ') . $listar[0]['num_comprobante'], 0,'1','C');
        $pdf->Cell(190, 15,'', 0,'1','C');


            $pdf->SetFont('Arial','B',9);
        $pdf->Cell(95, 5,'NOMBRE USUARIO', 0,'0','C');
        $pdf->Cell(95, 7,utf8_decode('DOCUMENTO DE IDENTIFICACIÓN'), 0,'1','C');


        $pdf->Cell(190, 3,'', 0,'1','C');

        /*23*/

        $cant = count($listarUsuariosPorContrato);
        $restante = 23 - $cant;

            $pdf->SetFont('Arial','',8);
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