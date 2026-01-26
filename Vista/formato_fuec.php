<?php

ob_start();

//include("../Controlador/Sesion/autenticar.php");
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
$cod = base64_decode($cod);

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


class PDF extends exFPDF
{
    // Cabecera de página
    function Header()
    {
    
        $empresa = new Empresa();
        $contrato = new Contrato();
        $fuec = new Fuec();
    
        $cod = $_GET['id'];
        $cod = base64_decode($cod);
        $listar = $fuec->listarFuecPorId($cod);
        
    
        $contratoid = $contrato->listarId($listar[0]['id_contrato']);
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
// $pdf->SetAutoPageBreak(true,70);

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
$pdf->Cell(166,4, $cod,0,1,'L');

$pdf->SetFont('Arial','B',8);
$pdf->Cell(36,4,utf8_decode('CONTRATO INTERNO N°:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4, str_pad($contratoid[0]['id_contrato'], 4, "0", STR_PAD_LEFT),0,1,'L');
$pdf->SetFont('Arial','',8);

if($contratoid[0]['numero_contrato'] != ''){ 
$pdf->SetFont('Arial','B',8);
$pdf->Cell(46,4,utf8_decode('N° OPERACIÓN Y/O CONTRATO:'),0,0,'L');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4, $contratoid[0]['numero_contrato'],0,1,'L');
$pdf->SetFont('Arial','',8);
} 

    $table = new easyTable($pdf, '{25,165}', 'font-size: 8; font-family:Arial;');
        $table->easyCell('CONTRATANTE:', 'font-style:B;');
        $table->easyCell(utf8_decode($clienteid[0]['razon_social']));

        $table->printRow();
    $table->endTable(0);

$pdf->SetFont('Arial','B',8);
$pdf->Cell(24,4,'NIT/CC:',0,0,'');
$pdf->SetFont('Arial','',8);
$pdf->Cell(166,4,$clienteid[0]['nit_cliente'],0,1,'L');

    $table = new easyTable($pdf, '%{19,81}', 'font-size: 8; font-family:Arial;');
        $table->easyCell('OBJETO CONTRATO:', 'font-style:B;');
        $table->easyCell(utf8_decode($contratoid[0]['objeto_contrato'] ));

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

$pdf->SetFont('Arial','B',10);
$pdf->Cell(0,1,'',0,'1','C');
$pdf->Cell(0,4,'VIGENCIA DEL CONTRATO',0,'1','C');
$pdf->Cell(0,4,'',0,'1','C');

$diainicio = date('d',strtotime($listar[0]['fecha_inicial_fuec']));
$mesinicio = date('m',strtotime($listar[0]['fecha_inicial_fuec']));
$yearinicio = date('Y',strtotime($listar[0]['fecha_inicial_fuec']));

$diafinal = date('d',strtotime($listar[0]['fecha_final_fuec']));
$mesfinal = date('m',strtotime($listar[0]['fecha_final_fuec']));
$yearfinal = date('Y',strtotime($listar[0]['fecha_final_fuec']));

$pdf->SetFont('Arial','B',9);
$pdf->Cell(55,5,'Fecha Inicial','L B T',0,'L');
$pdf->SetFont('Arial','',9);
$pdf->Cell(45,5,$diainicio,'L B T',0,'C');
$pdf->Cell(45,5,$mesinicio,'L B T',0,'C');
$pdf->Cell(45,5,$yearinicio,'L B R T',1,'C');

$pdf->SetFont('Arial','B',9);

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
$pdf->Cell(85,5, utf8_decode($listar[0]['responsable']),'B R',0,'L');
$pdf->SetFont('Arial','B',8);
$pdf->Cell(20,5, utf8_decode('N° CEDULA'),'B',0,'');
$pdf->SetFont('Arial','',9);
$pdf->Cell(50,5,$listar[0]['idResponsable'],'B R',1,'L');


$table = new easyTable($pdf, '{40,80,20,50}', 'font-size: 8; font-family:Arial;');
    $table->easyCell(utf8_decode('DIRECCIÓN:'), 'font-style:B; border: B - L');
    $table->easyCell(utf8_decode($listar[0]['dirResponsable']), 'border: B - R');
    $table->easyCell('TELEFONO:', 'font-style:B; border: B');
    $table->easyCell(utf8_decode($listar[0]['telResponsable']), 'border: B - R');

    $table->printRow();
$table->endTable(0);


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
//$pdf->Image('../Resources/fuec/img/SKMBT_22319123016050_002.png',0,0,100);
$pdf->Image('../Resources/fuec/img/SKMBT_22319123016050_002.png',0,0,210);




/* ------------------------------------------------------------ */
/* ----------------------- ANEXO RUTAS ------------------------ */
/* ------------------------------------------------------------ */

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
    
    }else if($listar[0]['id_contrato'] == 54){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Cali - Cartagena - Puerto Gaitan - Sabana de Cundinamarca - Villa de Leyva y Viceversa'), 1,'1','F');
    
    }else if($listar[0]['id_contrato'] == 129){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Zipaquirá, Cajica, Chia, Tabio, Cota ,Siberia, Bogotá, Guaymaral, Sopo, Briceño, Tocancipa.'), 1,'1','F');
    
    }else if($listar[0]['id_contrato'] == 240){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Barrancabermeja, Cartago, Toro, Roldanillo.'), 1,'1','F');
    
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
    
    }else if($listar[0]['id_contrato'] == 403){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, La Calera, Guasca, Guatavita (Tominé), Girardot, Anapoima y Viceversa.'), 1,'1','F');

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

    }else if($listar[0]['id_contrato'] == 54){ 
        
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->Cell(7, 5, '1', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('AEROPUERTO, ZONA URBANA DE BOGOTÁ Y SUS 20 LOCALIDADES: SUBA, ENGATIVÁ, BARRIOS UNIDOS, CHAPINERO, USME, '), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('CIUDAD BOLÍVAR, PUENTE ARANDA, FONTIBÓN, RAFAEL  NÚÑEZ,  KENNEDY,  SAN  CRISTÓBAL,  RAFAEL  URIBE,  TUNJUELITO,'), 'L,R','1','F');
        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('MÁRTIRES, TEUSAQUILLO, USAQUÉN, CANDELARIA, SANTA FÉ, BOSA, SUMAPAZ Y VICEVERSA'), 'L,B,R','1','F');

        $pdf->ln(1);


        $pdf->Cell(7, 5, '2', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('SALIENDO DE BOGOTA A LOS SIGUENTES MUNICIPIOS DEL DEPARTAMENTO DE CUNDINAMARCA  SEGÚN  LOS  EJES  QUE  SE'), 'L,R,T','1','F');
        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('DESCRIBEN:EJE1:BOGOTA,  LA  CALERA, GUASCA,  SOPO,  BRICEÑO,  GUATAVITA,  GACHETA,  UBALA,  JUNIN,  GACHA,  GAMA;'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('EJE2:BOGOTA, SIBERIA, TENJO, TABIO, CHIA, CAJICA, ZIPAQUIRA, COGUA, TOCANCIPA, GACHANCIPA, SUESCA, SESQUILE'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('CHOCONTA, VILLAPINZON, MACHETA, LENGUASAQUE,  GUACHETA;  EJE3:BOGOTA,  SOACHA,  EL  COLEGIO,  SAN ANTONIO DE'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TEQUENDAMA,  TENA,  VIOTA,  TIBACUY,  PANDI,  ICONONZO,  CUNDAY;  EJE  4:BOGOTA, FUNZA, MADRID, CARTAGENITA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('FACATATIVA, ALBAN, SASAIMA, GUAYABAL DE SIQUIMA, VITUIMA, VIANI, SAN JUAN DE RIO SECO, CHAGUANI, CAMBAO, BELTRAN; '), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('EJE  5:BOGOTA,  CHIA,  ZIPAQUIRA,  PACHO,  VILLA  GOMEZ,  SAN  CAYETANO,  PAIME, TOPAIPI, EL PEÑÓN, LA PEÑA, LA PALMA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('YACOPI, UTICA, QUEBRADANEGRA, CAPARRAPI EJE 6:BOGOTA, SOACHA, CHUZACA, GRANADA, SILVANIA, TIBACUY, CUMACA'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('EJE 7:BOGOTA, LA CARO, CHIA, CAJICA, ZIPAQUIRA, UBATE, COGUA, TAUSA, SUTATAUSA,  VILLA  DE  SAN  DIEGO  DE  UBATE,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('CUCUNUBA  EJE  8:BOGOTA,  LA  CARO, BRICEÑO, SOPOEJE 9:BOGOTA, LA CALERA, CHOACHI EJE 10:BOGOTA, SOCHA, '), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('SANTARDECITO,  PRADILLA,  MESITAS  EJE  11:BOGOTA,  FUNZA,  MOSQUERA,  LA  GRAN VIA, LA MESA EJE 12:BOGOTA, FUNZA, '), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('MOSQUERA, MADRID, FACATATIVA, ZIPACON, ANOLAIMAEJE 13:BOGOTA, LA CALERA, GUASCA, SUEVA, GACHETA, UBALA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('GACHALA Y VICEVERSA'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '3', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA -  SIBERIA - EL  ROSAL -  SANFRANCISCO - LA  VEGA - VILLETA - GUADUAS - HONDA - LA DORADA - MARIQUITA - PUERTO'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('SALGAR  CAÑO  ALEGRA  PUERTO  TRIUNFO  PUERTO BERRIO DORADAL COCORNA SANTUARIO - RIO NEGRO - MARINILLA'), 'L,R','1','F');
        
        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('COPACABANA - BELLO - ITAGUI - MEDELLIN Y VICEVERSA'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '4', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, SOACHA, SILVANIA, FUSAGASUGA, MELGAR, RICAUTE, GIRARDOT, FLANDES, ESPINAL, IBAGUE, CAJAMARCA, CALARCA,'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('ARMENIA, LA TEBAIDA, BUGALAGRANDE, ANDA LUCIA, TULUA, BUGA, GUACARI, EL CERRITO YUMBO, CALI Y ADEMAS BOGOTA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('MONDOÑEDO, LA MESA, ANAPOIMA, TOCAIMA, GIRARDOT, FLANDES,CALI Y ADEMAS BOGOTA, CHARQUITO, MESITAS EL TRIUNFO, '), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('VIOTA, TOCAIMA, GIRARDOT, FLANDES, ESPINAL, IBAGUE, CAJAMARCA, CALARCA,  ARMENIA, LA TEBAIDA, BUGALAGRANDE,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('ANDA LUCIA, TULUA, BUGA, GUACARI, EL CERRITO YUMBO, CALI Y VICEVERSA'), 'L,R,B','1','F');

                
        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',7);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');

        $pdf->Cell(90,20,$pdf->Code39($pdf->GetX()+3, $pdf->GetY()+3, $codigo1 ,1,9),'B L R',1,'C');

        $pdf->SetXY(100,235);
        $pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
        $pdf->SetXY(130,240);
        $pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
        $pdf->SetXY(130,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');


        $pdf->addPage();

        $pdf->Cell(0, 15, utf8_decode(''), 0,'1','F');

        $pdf->Cell(7, 5, '5', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, CHIA, CAJICA, TOCANCIPA, ZIPAQUIRA, SESQUILE, CHOCONTA, VILLAPINZON, VENTAQUEMADA, TUNJA, COMBITA,'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('ARCABUCO, MONIQUIRA, TAUSA, UBATE, SIMIJACA, CHIQUINQUIRA, SABOYA, PUENTENACIONAL, BARBOSA, GUEPSA, SANTANA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('OIBA, SOCORRO, SANGIL, CONFINES, PINCOTE, CURITI, ARACOTA, PIEDECUESTA, BUCARAMANGA, MUTISCUA, PAMPLONA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('PAMPLONITA, CHINACOTA, LOS PATIOS, CUCUTA Y VICEVERSA'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '6', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, CHIA, CAJICA, SOPO, TOCANCIPA, GACHANCIPA, SESQUILE, CHOCONTA, VILLAPINZON, VENTAQUEMADA, PUENTE DE'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOYACA, TUNJA, COMBITA, SOTAQUIRA, PAIPA,  DUITAMA,  TIBASOSA,  NOBSA,    SOGAMOSO,  AGUAZUL,  YOPAL,  ARACABUCO,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('VILLA DE LEYVA Y ADEMAS, BOGOTA, CHIA, CAJICA, ZIPAQUIRA, TAUSA, UBATE, SIMIJACA, CHIQUINQUIRA, TINJACA, RAQUIRA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('SUTAMARCHAN, VILLA DE LEYVA Y VICEVERSA.'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '7', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, SIBERIA, EL ROSAL, ALTO DEL VINO, LA VEGA, VILLETA ,GUADAS, RUTA DEL SOL, Y ADEMAS HONDA, LA DORADA,'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('PTO BOYACA, PUERTOARAUJO, B/CA BERMEJA, SANALBERTO, AGUACHICA, PELAYA, PAILITAS, CURUMANI, BOSCONIA,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('FUNDACION, LA GRAN VIA, CIENAGA, B/QUILLA, PTO COLOMBIA, CARTAGENA, STA MARTHA ,PARQUE NACIONAL NATURAL'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TAYRONA, PLAYA PALOMINO, RIONEGRO, RIOACHA Y VICEVERSA Y ADEMAS, BARRANQUILLA, SOLEDAD, MALAMBO, EL CARMEN'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('DE BOLIVAR, COROZAL, SINCELEJO, CHINU, CAUCACIA, PIAMONTE, PUERTO ANTIOQUIA, VALDIVIA, YARUMAL, SANTA ROSA DE'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('OSOS, GIRARDOTA, BELLO, MEDELLIN, BOGOTA Y VICEVERSA.'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '8', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, SOACHA, SILVANIA, FUSAGASUGA, MELGAR, ESPINAL, IBAGUE, CAJAMARCA, ARMENIA, LA TEBAIDA, BUGA LA GRANDE,'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('ANDALUCIA, TULUA, BUGA, GUACARI, EL CERRRITO, CALI, ARMENIA, PEREIRA, SANTA ROSA DE CABAL, CHINCHINA MANIZALES'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode(' Y VICEVERSA.'), 'L,R,B','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '9', '1','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, CHIA, CAJICA, ZIPAQUIRA, TAUSA, UBATE, SIMIJACA, CHIQUINQUIRA, BUENA VISTA, MARIPI, MUZO Y VICEVERSA'), '1','1','F');

        $pdf->ln(1);

        $pdf->Cell(7, 5, '10', 'L,R,T','0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA, SOACHA, SIBATE, FUSAGASUGA, BOQUERON, MELGAR GIRARDOT,  ESPINAL, GUAMO,  SALDAÑA,  NATAGUAMA,  AIPE,'), 'L,R,T','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('NEIVA, Y /O SIBERIA FUNZA MOSQUERA, MADRID, LA MESA, ANAPOIMA, APULO, TOCAIMA, GIRARDOT, ESPINAL, GUAMO,'), 'L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('SALDAÑA, NATAGAIMA, AIPE, NEIVA Y VICEVERSA.'), 'L,R,B','1','F');


    }else if($listar[0]['id_contrato'] == 91){
        
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

    }else if(($listar[0]['id_contrato'] == 101)or($listar[0]['id_contrato'] == 102)){
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Chia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Cota y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Cajica y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Siberia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - La Punta y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Zipaquira y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Guatavita y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Sopo y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '9', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Subachoque y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '10', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - San Francisco y Viceversa'), 1,'1','F');

    }else if($listar[0]['id_contrato'] == 114){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Nobsa - Sogamoso - Duitama - Paipa - Tunja - Venta Quemada - Villa Pinzon y Viceversa'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 69)or($listar[0]['id_contrato'] == 70)or($listar[0]['id_contrato'] == 71)or($listar[0]['id_contrato'] == 113)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Chia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Cota y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - La Calera y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Siberia y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Zipaquira y Viceversa'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Sopo y Viceversa'), 1,'1','F');

    }else if($listar[0]['id_contrato'] == 126){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Chia'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - La Calera'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Cota'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Madrid'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá - Zipaquira'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 119)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ - AEROPUERTO MONTERIA'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ - QUIMBAYA'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - AEROPUERTO LAS BRUJAS COROZAL'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - MOMPOX'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - VALLEDUPAR'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BARICHARA'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CARTAGENA'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BARRANQUILLA'), 1,'1','F');
        $pdf->Cell(7, 5, '9', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTA MARTA'), 1,'1','F');
        $pdf->Cell(7, 5, '10', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - RIOHACHA'), 1,'1','F');
        $pdf->Cell(7, 5, '11', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CABO DE LA VELA'), 1,'1','F');
        $pdf->Cell(7, 5, '12', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - ARBOLETES'), 1,'1','F');
        $pdf->Cell(7, 5, '13', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTA FÉ DE ANTIOQUIA'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 132)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ - AEROPUERTO MONTERIA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - AEROPUERTO LAS BRUJAS COROZAL (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - AEROPUERTO CARTAGENA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - MOMPOX (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CALI (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - EJE CAFETERO (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - MEDELLIN (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTAFE DE ANTIOQUIA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '9', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - JARDIN ANTOQUIA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '10', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - GUATAPE (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '11', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BOGOTA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '12', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - VALLEDUPAR (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '13', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BARICHARA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '14', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CABO DE LA VELA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '15', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - SANTA MARTA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '16', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - MANIZALEZ (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '17', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - QUIMBAYA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '18', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - RIOHACHA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '19', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - CUCUTA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '20', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - IBAGUE (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '21', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - BUCARAMANGA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '22', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLÚ  - RINCON DEL MAR (VICEVERSA)'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 137)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - TOBIA GRANDE (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - VILLETA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - GUADUAS (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - GUADERO (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - PUERTO SALGAR (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - EL CORAL (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - HONDA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - DORADA (VICEVERSA)'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 233)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('GACHANCIPA'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOCANCIPA'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BRICEÑO'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('ZIPAQUIRÁ'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('COGUA'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 141)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - CHIA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '2', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - LA CALERA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '3', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - CAJICA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '4', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - MOSQUERA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '5', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - MADRID (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '6', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - COTA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '7', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - SOACHA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '8', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - FUNZA (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '9', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - TENJO (VICEVERSA)'), 1,'1','F');
        $pdf->Cell(7, 5, '10', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTA - FACATATIVA (VICEVERSA)'), 1,'1','F');

    }else if(($listar[0]['id_contrato'] == 64)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Ibagué, Cuchuni, Alvarado, Venadillo, Santa Isabel, Lérida, Libano, Murillo, Villahermosa, Armero, Guayabal, Falan, Palocabildo, Casablanca,'), 'T,L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Mariquita, Honda, Fresno, Gualanday, Chicoral, Espinal, Melgar, Cunday, Icononzo, Villarrica, Saldaña, Guamo, Ortega, Chaparral, Planadas, '), 'L,R','1','F');
        $pdf->Cell(7, 5, '', 'B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Dolores, Prado, Purificaión, Alpujarra, Cajamarca, Girardot, Anapoima, Tocaima, Apulo y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '2', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Popayán, Cajibío, Piendamó, Mondono, Santander, Morales, Suárez, Totoro, Puerto Tejada, Guachené, Miranda, Caldono, Timbio,'), 'T,L,R','1','F');

        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Rosas, Patía, Bordo, Bolívar, Sucre, Mercaderes, Buenos Aires, Caloto, Corinto, Padilla, Santander de Quilichao, Villa Rica, El tambo, '), 'L,R','1','F');
        $pdf->Cell(7, 5, '', 'L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('La sierra, Sotará, Almaguer, Argelia, Balboa, Florencia, La vega, Piamonte, San Sebastián, Sanra Rosa, Guapi, López de Micay, Timbiquí,'), 'L,R','1','F'); 
        $pdf->Cell(7, 5, '', 'B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Inzá, Jambaló, Páez, Puracé - Coconuco, Silvia, Toribío y Viceversa.'), 'B,L,R','1','F');

    }else if(($listar[0]['id_contrato'] == 175)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota y Alrededores'), 'T,L,R','1','F');

        $pdf->Cell(7, 5, '2', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Girardot y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '2', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Barranquilla y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '2', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Medellin y Viceversa.'), 'B,L,R','1','F');

    }else if(($listar[0]['id_contrato'] == 212)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Usaquén.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '2', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Chapinero.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '3', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Santa Fe.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '4', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('San Cristóbal.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '5', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Usme.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '6', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Tunjuelito.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '7', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bosa.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '8', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Kennedy.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '9', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Fontibón.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '10', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Engativá.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '11', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Suba.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '12', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Barrios Unidos.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '13', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Teusaquillo.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '14', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Los Mártires.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '15', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Antonio Nariño.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '16', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Puente Aranda.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '17', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('La Candelaria.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '18', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Rafael Uribe Uribe.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '19', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Ciudad Bolívar.'), 'B,L,R','1','F');


        $pdf->Cell(7, 5, '20', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Sumapaz.'), 'B,L,R','1','F');

    }else if(($listar[0]['id_contrato'] == 245)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHÍQUIZA y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '2', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHIVATÁ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '3', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CÓMBITA y Viceversa.'), 'B,L,R','1','F');
    
        $pdf->Cell(7, 5, '4', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CUCAITA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '5', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MOTAVITA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '6', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - OICATÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '7', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAMACÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '8', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SIACHOQUE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '9', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SORA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '10', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SORACÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '11', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SOTAQUIRÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '12', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TOCA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '13', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TUTA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '14', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - VENTAQUEMADA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '15', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHISCAS y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '16', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - EL COCUY y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '17', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - EL ESPINO y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '18', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GUACAMAYAS y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '19', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GUICÁN y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '20', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PANQUEBA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '21', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - LABRANZAGRANDE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '22', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PAJARITO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '23', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PAYA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '24', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PISBA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '25', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BERBEO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '26', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CAMPOHERMOSO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '27', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MIRAFLORES y Viceversa.'), 'B,L,R','1','F');

        /*quitar*/
        $pdf->Cell(7, 5, '28', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - VENTAQUEMADA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '29', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PÁEZ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '30', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN EDUARDO y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '31', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - ZETAQUIRA y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '32', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - EL BOYACÁ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '33', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CIÉNAGA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '34', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - JENESANO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '35', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - NUEVO COLÓN y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '36', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - RAMIRIQUÍ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '37', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - RONDÓN y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '38', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TIBANÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '39', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TURMEQUÉ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '40', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - ÚMBITA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '41', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - VIRACACHÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '42', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHINAVITA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '43', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GARAGOA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '44', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MACANAL y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '45', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PACHAVITA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '46', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN LUIS DE GACENO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '47', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SANTA MARÍA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '48', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BOAVITA y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '49', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - COVARACHÍA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '50', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - LA UVITA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '51', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN MATEO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '51', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SATIVANORTE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '52', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SATIVASUR y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '53', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SOATÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '54', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SUSACÓN y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '55', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TIPACOQUE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '56', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BRICEÑO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '57', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BUENAVISTA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '58', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CALDAS y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '59', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHIQUINQUIRÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '60', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - COPER y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '61', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - LA VICTORIA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '62', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MARIPÍ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '63', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MUZO y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '64', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - OTANCHE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '65', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PAUNA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '66', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - QUÍPAMA y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '67', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SABOYÁ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '68', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN MIGUEL DE SEMA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '69', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TUNUNGUÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '70', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - ALMEIDA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '71', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHIVOR y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '72', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GUATEQUE y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '73', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GUAYATÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '74', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - LA CAPILLA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '75', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SOMONDOCO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '76', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SUTATENZA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '77', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TENZA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '78', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - ARCABUCO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '79', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CHITARAQUE y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '80', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GACHANTIVÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '81', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MONIQUIRÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '82', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - RÁQUIRA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '83', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SÁCHICA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '84', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN JOSÉ DE PARE y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '85', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SANTA SOFÍA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '86', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SANTANA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '87', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SUTAMARCHÁN y Viceversa.'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '88', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TINJACÁ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '89', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TOGUÍ y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '90', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - VILLA DE LEYVA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '91', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - AQUITANIA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '92', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CUÍTIVA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '93', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - GÁMEZA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '94', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - IZA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '95', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MONGUA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '96', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - MONGUÍ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '97', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - NOBSA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '98', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - PESCA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '99', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - SOGAMOSO y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '100', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TÍBASOSA y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '101', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TÓPAGA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '102', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - TOTA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '103', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BELÉN y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '104', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - BUSBANZÁ y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '105', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CERINZA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '106', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - CORRALES y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '107', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - DUITAMA y Viceversa.'), 'B,L,R','1','F');

        $pdf->Cell(7, 5, '108', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('TUNJA - FLORESTA y Viceversa.'), 'B,L,R','1','F');
        
        
        $pdf->addPage();

            $pdf->Cell(7, 5, '109', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - PAIPA y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '110', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - SANTA ROSA DE VITERBO y Viceversa.'), 'B,L,R','1','F');
            
            $pdf->Cell(7, 5, '111', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - TUTAZÁ y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '112', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - BETÉITIVA y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '113', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - CHITA y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '114', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - JERICÓ y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '115', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - PAZ DE RÍO y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '116', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - SOCHA y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '117', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - SOCOTÁ y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '118', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - TASCO y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '119', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - CUBARÁ y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '120', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - SAN PABLO DE BORBUR y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '121', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - FIRAVITOBA y Viceversa.'), 'B,L,R','1','F');

            $pdf->Cell(7, 5, '122', 'T,B,L,R','0','C');
            $pdf->Cell(183, 5, utf8_decode('TUNJA - PUERTO BOYACÁ y Viceversa.'), 'B,L,R','1','F');

    }else if(($listar[0]['id_contrato'] == 72)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota y Alrededores'), 'T,B,L,R','1','F');

        $pdf->Cell(7, 5, '2', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Chia y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '3', 'T,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Cajica y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '4', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Cota y Viceversa.'), 'B,L,R','1','F');
        
        $pdf->Cell(7, 5, '5', 'T,B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogota, Calera y Viceversa.'), 'B,L,R','1','F');
        
    }else if(($listar[0]['id_contrato'] == 352)){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOLIVAR'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Achí - Altos del Rosario - Arenal - Arjona - Arroyohondo - Barú - Barranco de Loba - Calamar - Cantagallo - El Carmen de Bolivar - Cartagena de Indias - Cicuco - Clemencia - Córdoba - El Guamo - El Peñón - Galerazamba - Hatillo de Loba - Magangué - Mahates - Margarita - María la Baja - Montecristo - Morales - Norosí - Pinillos - Regidor - Río Viejo - San Cristóbal - San Estanislao - San Fernardo - San Jacinto - San Jacinto del Cauca - San Juan Nepomuceno - San Martín de Loba - San Pablo - Santa Catalina - Santa Cruz de Mompox - Santa Rosa - Santa Rosa del Sur - Simití - Soplaviento - Talaigua Nuevo - Tiquisio - Turbaco - Turbaná - Villanueva - Zambrano.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

    }else if($listar[0]['id_contrato'] == 257){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOGOTÁ'), 'L,R,T','1','F');
        
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 'B,L,R','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá D.C y Alrededores'), 'T,B,L,R','1','F');

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'CUNDINAMARCA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Cundinamarca: Bogotá, Soacha, Fusagasugá, Facatativá, Zipaquirá, Chía, Girardot, Mosquera, Madrid, Funza, Cajicá, Ubaté, Guaduas, Sibaté, La Mesa, Pacho, Tocancipá, Villeta, La Calera, Sopó, Silvania, Tabio, El Colegio, Cota, Chocontá, Cogua, Tenjo, Villapinzón, Tociama, Cáqueza, Yacopi, Puerto Salgar, Nilo, Suesca, Caparrapí, El Rosal, Viotá, La Vega, Subachoque, Anolaima, Guasca, Fómeque, Ubalá, Agua de Dios, Arbeláez, Anapoima, Guachetá, Nemocón, Pasca, Chiachí, Simijaca, Gachancipá, San Anonio del Tequendama, Gachetá, Sasaima, San Bernardo, Susa, Cachipay, Sesquilé, Lenguazaque, Medina, San Juan del Rioseco, La Palma, Bojacá, Carmen de Carupa, Chipaque, San Franciso, Junín, Ricaurte, Quipile, Une, Apulo, Tena, Vergara, Paratebueno, Granada, La Peña, Cucunubá, Ubaque, Machetá, Fosca, Quetame, Albán, Cachalá, Guatavita, Nimaima, Pandi, Nocaima, Paime, San Cayetano, Fúquene, Zipacón, El Peñón, Supatá, Tibacuy, Sutatausa, Tausa, Guayabetal, Topaipí, Cabrera, Quebradanegra, Manta, útica, Vianí, Chaguaní, Venecia, Gama, Guayabal de Síquima, Gutíérrez, Tibirita, Pulí, Jerusalén, Bituima, Guataquí, Villagómez, Nariño, Beltran.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'SANTANDER', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Santander: Bucaramanga, Floridablanca, Barrancabermeja, San Juan de Girón, Piedecuesta, San Gil, Cimitarra, Puerto Wilches, Lebrija, San Vicente de Chucurí, Rionegro, Barbosa, Sabana de Torres, Vélez, Málaga, El Carmen de Chucurí, Puente Nacional, Landázuri , El Playón, Bolívar, Curití, Charalá, Oiba, Mogotes, Los Santos, Suaita, San Andrés, Sapatoca, Sucre, Simacota, Aratoca, Barichara, La Belleza, Villanueva, Guaca, Tona, Ouerto Parra, Florián, Cerrito, Coromoro, Capitanejo, Concepción, Matanza, Onzaga, El Peñón, La paz, Guadalupe, Molagavita, Betulia, Valle de San José, Carcasí, Chipatá, Ocamonte, San José de Miranda ,Santa Helena del Opón, Albania, Guavatá, Güepsa, Contratación, Enciso, San Benito, Gámbita, Pinchote, Páramo, Suratá, Jesús María, Chima, Charta, Galán, San Joaquín, Confines, Encino, Macaravita, San Miguel, Plamas del Socorro, Socorro, Hato, Santa Bárbara, El Guacamayo, Guapotá, Plamar, Cepitá, Cabrera, Aguada, California, Vetas, Jordán.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOYACÁ'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Boyacá: Tunja, Sogamoso, Duitama, Chiquinquirá, Puerto Boyacá, Paipa, Moniquirá, Samacá, Garagoa, Aquitania, Nobsa, Ventaquemada, Cómbita, Saboyá, Tibasosa, Ráquira, Santa Rosa de Veiterbo, Chita, Otanche, Pauna, Guateque, Úmbita, San Pablo de Borbur, Muzo, Socotá, Ramiriquí, Villa de Leyva, Tibaná, Miraflores, Pesca, Tuta, Toca, Soatá, Belén, Quípama, Sotaquirá, Maripí, Santana, Siachoque, Socha, Turmequé, Jenesano, Tasco, Chitaraque, Boavita, Cubará, Firavitoba, San Luis de Gaceno, Guayatá, Nuevo Colón, Motavita, Güicán, Chíquiza, iza, Soracá, Buenavista, Sutamarchán, San José de Pare, Tota, El Cocuy, Labranzagrande, Chiscas, Togüí, Ciénega, Arcabuco, Paz del Río, Mongua, Zetaquira, Chivatá, Boyacá, Monguí, Gámeza, Macanal, San Mateo, Jericó, Santa María, Cucaita, Sutatenza, Tenza, Cerinza, Coper, San Miguel de Sema, Campohermoso, El Espino, Caldas, Floresta, Sáchica, Tipacoque, Chinavita, Tópaga, Susacón, La Uvita, Viracachá, Somondoco, Páez, Covarachía, La Capilla, Santa Sofía, Gachantivá, Pachavita, Rondón, Sora, Tinjacá, Oicatá, Briceño, Sativanorte, Paya, Corrales, Betéitiva, Tutazá, Almeida, Pajarito, Chivor, Guacamayas, Cuítiva, San Eduardo, Berbeo, Panqueba, La Victoria, Tununguá, Pisba, Sativasur, Busbanzá.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);
        
        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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


        $pdf->addPage();


        $pdf->ln(10);

        $pdf->SetFont('Arial','B', 9);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'META', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Meta: Villavicencio, Acacías, Granada, Puerto López, San Martín, Cumaral, Puerto Gaitán, Vista Hermosa, Fuente de Oro, Puerto Lleras, Restrepo, Lejanías, Guamal, Puerto Concordia, La Uribe, Castilla La Nueva, Puerto Rico, San Juan de Arama, San Carlos de Guaroa, El Castillo, Cubarral, Mesetas, La Macarena, Cabuyaro, Barranca de Upía, El Dorado, El Calvario, San Juanito, Mapiripán.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);


        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAQUETÁ'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Caquetá: Florencia, San Vicente del Caguán, Cartagena del Chairá, El Doncello, Puerto Rico, La Montañita, El Paujil, Belén de los Andaquíes, Solano, San José del Fragua, Valparaíso, Puerto Milán, Solita, Curillo, Albania, Morelia.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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

    }else if($listar[0]['id_contrato'] == 258){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('ATLÁNTICO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Atlántico: Barranquilla, Soledad, Malambo, Sabanalarga, Baranoa, Galapa, Puerto Colombia, Sabanagrande, Santo Tomás, Palmar de Varela, Luruaco, Repelón, Ponedera, Campo de la Cruz, Juan de Acosta, Polonuevo, Manatí, Santa Lucía, Candelaria, Tubará, Suán, Usiacurí, Piojó.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'MAGDALENA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Magdalena: Santa Marta, Ciénaga, Zona Bananera, Fundación, El Banco, Plato, Pivijay, Aracataca, Ariguaní, Sitionuevo, Guamal, Pueblo Viejo, Santa Ana, El Retén, San Sebastián de Buenavista, El Piñón, Chibolo, Nueva Granada, Sabanas de San Angel, Pijiño del Carmen, Tenerife, Algarrobo, Santa Bárbara de Pinto, Concordia, San Zenón, Zapayán, Salamina, Cerro de San Antonio, Pedraza, Remolino.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'CESAR', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Cesar: Valledupar, Aguachica, Codazzi, Bosconia, Chimichagua, Curumaní, El Copey, Chiriguaná, Jagua, La Paz, El Paso, San Alberto, Astrea, Pueblo Bello, San Martín, Pailitas, Pelaya, Gamarra, La Gloria, Río de Oro, Tamalameque, Becerril, San Diego, González, Manaure Balcón del Cesar.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'SUCRE', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Sucre: Sincelejo, Corozal, San Marcos, San Onofre, Sampués, Majagual, Sincé, Santiago de Tolú, San Benito Abad, Sucre, Ovejas, Tolú Viejo, Los Palmitos, Pueblo Bello, Galeras, San Pedro, Guaranda, Morroa, San Juan de Betulia, Palmito, Coveñas, Caimito, La Unión, Buenavista, El Roble, Colosó, Chalán.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CÓRDOBA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Córdoba: Montería, Santa Cruz de Lorica, Sahagún, Cereté, Tierralta, Montelíbano, San Andrés de Sotavento, Planeta Rica, Ciénaga de Oro, Chinú, Ayapel, San Pelayo, Valencia, Puerto Libertador, Tuchín, Pueblo Nuevo, San Bernardo del Viento, San Antero, San Carlos, Moñitos, Puerto Escondido, Buenavista, Los Córdobas, Cotorra, Purísima, Canalete, Momil, Chimá, La Apartada, San José de Uré.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOLÍVAR'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Bolívar: Cartagena de Indias, Magangué, El Carmen de Bolívar, Turbaco, Arjona, María La Baja, Santa Cruz de Mompox, San Juan Nepomuceno, San Pablo, Santa Rosa del Sur, Mahates, Pinillos, San Jacinto, Calamar, Achí, Tiquisio, Santa Rosa, Simití, Villanueva, San Estanislao, Río Viejo, Barranco de Loba, Brazuelo de Papayal, Norosí, San Martín, Turbaná, Morales, Córdoba, San Fernando, Santa Catalina, Clemencia, Hatillo de Loba, Montecristo, Cicuco, Talaigua Nuevo, Altos del Rosario, Zambrano, Margarita, Arroyohondo, Soplaviento, El Peñón, Cantagallo, El Guamo, Arenal, San Jacinto del Cauca, San Cristóbal, Regidor.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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


        $pdf->addPage();

        $pdf->ln(10);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('NORTE DE SANTANDER'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Norte de Santander: Cúcuta, Ocaña, Villa del Rosario, Los Patios, Pamplona, Abrego, Tibú, El Zulia, Sardinata, Toledo, Teorama, Chinácota, Convención, El Carmen, La Esperanza, Cáchira, San Calixto, Chitagá, Salazar de Las Palmas, Arboledas, Cucutilla, Hacarí, Puerto Santander, Ragonvalia, Bochalema, Gramalote, La Playa de Belén, Labateca, Santo Domingo de Silos, Villa Caro, Pamplonita, Bucarasica, San Cayetano, Herrán, Duranía, Mutiscua,  Lourdes, Santiago, Cácota.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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

    }else if($listar[0]['id_contrato'] == 342){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('QUINDIO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ARMENIA, FILANDIA, CIRCASIA, MONTENEGRO,GENOVA, LA TEBAIDA, QUIMBAYA, PUEBLO TAPADO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'VALLE DEL CAUCA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('2', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CALI, PALMIRA, BUGA,CAICEDONIA,SEVILLA, CARTAGO,BUENAVENTURA, LA UNION, ANDALUCIA, JAMUNDI, ALCALA, YUMBO, ROLDANILLO, TULUA, CALIMA, GINEBRA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'TOLIMA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('3', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CAJAMARCA, IBAGUE, ESPINAL, MELGAR, NEVADO DEL TOLIMA, ALVARADO, VENADILLO,ARMERO GUAYABAL, MARIQUITA, FRESNO, HONDA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RISARALDA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('4', 'border: B-L-R;');
            $table->easyCell(utf8_decode('PEREIRA, QUINCHIA, DOSQUEBRADAS, SANTA ROSA DE CABAL, LA VIRGINIA, BELEN DE UMBRIA, BELALCAZAR, ANSERMA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CALDAS'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('5', 'border: B-L-R;');
            $table->easyCell(utf8_decode('MANIZALES, CHINCHINA, VICTORIA, MARQUETALIA, RIOSUCIO, LA DORADA, DORADAL, MANZANARES, NORCASIA, VITERBO, PENSILVANIA, SAMANA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CUNDINAMARCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('6', 'border: B-L-R;');
            $table->easyCell(utf8_decode('BOGOTA, GIRARDOT, LA CALERA, FUSAGASUGA, TOCAIMA, VILLETA,GUADUAS, PUERTO BOGOTA, PUERTO SALGAR, MOSQUERA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('ANTIOQUIA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('7', 'border: B-L-R;');
            $table->easyCell(utf8_decode('MEDELLIN,BELLO, GUATAPE, SANTA ROSA DE OSOS, YARUMAL, APARTADO, MARINILLA, NECOCLI, ENVIGADO, RIONEGRO, JERICO, REMEDIOS, CAREPA, ITAGUI.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('HUILA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('8', 'border: B-L-R;');
            $table->easyCell(utf8_decode('NEIVA, LA PLATA, GARZON, PITALITO, RIVERA, PALERMO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CHOCO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('9', 'border: B-L-R;');
            $table->easyCell(utf8_decode('QUIBDO, BAGADO, BOJAYA, ATRATO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('MAGDALENA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('10', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CIENAGA, PLATO, EL BANCO, SANTA MARTA, EL COPEY, BARRANQUILLA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->addPage();

        $pdf->ln(10);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAUCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('11', 'border: B-L-R;');
            $table->easyCell(utf8_decode('POPAYAN, EL TAMBO, CORINTO, TORIBIO, SANTANDER DE QUILICHAO, SUCRE, CALOTO, PIENDAMO, CARTAGO, CANDELARIA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SANTANDER'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('12', 'border: B-L-R;');
            $table->easyCell(utf8_decode('BUCARAMANGA,BARRANCABERMEJA, BOLIVAR, PURTO WILCHES, BARBOSA, GIRON.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('GUAJIRA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('13', 'border: B-L-R;');
            $table->easyCell(utf8_decode('RIOHACHA, MAICAO, PALOMINO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAQUETA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('14', 'border: B-L-R;');
            $table->easyCell(utf8_decode('FLORENCIA, CARTAGENA DEL CHAIRA, EL PAUJIL, SAN VICENTE DEL CAGUAN, PURTO RICO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SUCRE'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('15', 'border: B-L-R;');
            $table->easyCell(utf8_decode('SINCELEJO, SAN MARCOS, TOLU VIEJO, COVEÑAS.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('NARIÑO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('16', 'border: B-L-R;');
            $table->easyCell(utf8_decode('PASTO, TUMACO, TUQUERRES, IPIALES, BUESACO, BELEN.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOLIVAR'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('17', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CARTAGENA, MOMPOS, TURBACO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

    }else if($listar[0]['id_contrato'] == 315){

        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('ANTIOQUIA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CACERES - CAUCASIA - EL BAGRE - NECHI - TARAZA - ZARAGOZA - CARACOLI - MACEO - PUERTO BERRIO - PUERTO NARE - PUERTO TRIUNFO - YONDO - AMALFI - ANORI - CISNEROS - REMEDIOS - SAN ROQUE - SAN DOMINGO - SEGOVIA - VEGACHI - YALI - YOLOMBO - ANGOSTURA - BELMIRA - BRICEÑO - CAMPAMENTO - CAROLINA DEL PRINCIPE - DONMATIAS - ENTRERRIOS - GOMEZ PLATA - GUADALUPE - ITUANGO - SAN ANDRES DE CUERQUIA - SAN JOSE DE LA MONTAÑA - SAN PEDRO DE LOS MILAGROS - SANTA ROSA DE OSOS - TOLEDO - VALDIVIA - YARUMAL - ABRIAQUI - SANTA FE DE ANTIOQUIA - ANZA - ARMENIA - BRITICA - CAICEDO - CAÑASGORDAS - DABEIBA - EBEJICO - FRONTINO - GIRALDO - HELICONIA - LIBRONA - OLAYA - PEQUE - SABANALARGA - SAN JERONIMO - SOPETRAN -  URAMITA - ABEJORRAL - ALEJANDRIA - ARGELIA - EL CARMEN DE VIBORAL - COCORNA - CONCEPCION - EL PEÑOL - EL RETIRO - EL SANTUARIO - GRANADA - GUATAPE - LA CEJA - LA UNION - MARINILLA - NARIÑO - RIONEGRO - SAN CARLOS - SAN FRANCISCO - SAN LUIS - SAN RAFAEL - SAN VICENTE - SONSON - AMAGA - ANDES - ANGELOPOLIS - BETANIA - BETULIA - CARAMANTA - CIUDAD BOLIVAR - CONCORDIA - FREDONIA - HISPANIA - JARDIN - JERICO - LA PINTADA - MONTEBELLO - PUEBLORRICO - SALGAR - SANTA BARBARA - TAMESIS - TARSO - TITIRIBI - URRAO - VALPARAISO - VENECIA - APARTADO - ARBOLETES - CAREPA - CHIGORODO - MURINDO - MUTATA - NECOCLI - SAN JUAN DE ARABA - SAN PEDRO DE URABA - TURBO - VIGIA DE FUERTE - BARBOSA - BELLO - CALDAS - COPACABANA - ENVIGADO - GIRARDOTA - ITAGUI - LA ESTRELLA - MEDELLIN - SABANETA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('VALLE DEL CAUCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('2', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ALCALA - ANDALUCIA - ANSERMANUEVO - ARGELIA - BOLIVAR - BUENAVENTURA - BUGA - BUGALAGRANDE - CAICEDONIA - CALI - CALIMA EL DARIEN - CANDELARIA - CARTAGO - DAGUA - EL AGUILA - EL CAIRO - EL CERRITO - EL DOVIO - FLORIDA - GINEBRA - GUACARI - JAMUNDI - LA CUMBRE - LA UNION - LA VICTORIA - OBANDO - PALMIRA - PRADERA - RESTREPO - RIOFRIO - ROLDANILLO - SAN PEDRO - SEVILLA - TORO - TRUJILLO- TULUA - ULLOA - VERSALLES - VIAJES - YOTOCO - YUMBO - ZARZAL.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAUCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('3', 'border: B-L-R;');
            $table->easyCell(utf8_decode('BUENOS AIRES - CALOTO - CORINTO - GUACHENE - MIRANDA - PADILLA - PUERTO TEJADA - SANTANDER DE QUILICHAO - SUAREZ - VILLA RICA - CAJIBIO - EL TAMBO - LA SIERRA - MORALES - PIENDAMO - POPAYAN - ROSAS - SOTARA - TIMBIO - ALMAGUER - ARGELIA - BALBOA - BOLIVAR - FLORENCIA - LA VEGA - MERCADERES - PATIA - PIAMONTE - SAN SEBASTIAN - SANTA ROSA - SUCRE - GUAPI - LOPEZ DE MICAY - TIMBIQUI - CALDONO - INZA - JAMBALO - PAEZ - PURACE COCONUCO - SILVIA - TORIBIO - TOTORO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAQUETÁ'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('4', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ALBANIA - BELEN DE LOS ANDAQUIES - CARTAGENA DEL CHAIRA - CURILLO - EL DONCELLO - EL PAUJIL - FLORENCIA - LA MONTAÑITA - MORELIA - PUERTO RICO - SAN JOSE DE FRAGUA - SAN VICENTE DEL CAGUAN - SOLANO - SOLITA - VALPARAISO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('PUTUMAYO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('5', 'border: B-L-R;');
            $table->easyCell(utf8_decode('COLON - MOCOA - ORITO - PUERTO ASIS - PUERTO CAICEDO - PUERTO GUZMAN - PUERTO LEGUIZAMO - SAN FRANCISCO - SAN MIGUEL - SANTIAGO - SIBUNDOY - VALLE DEL GUAMUEZ - VILLAGARZON.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        /* NUEVA PAG */
        $pdf->addPage();
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('META'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('6', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ACACIAS - BARRANCA DE UPIA - CABUYARO - CASTILLA LA NUEVA - CUBARRAL - CUMARAL - EL CALVARIO - EL CASTILLO - EL DORADO - FUENTE DE ORO - GRANADA - GUAMAL - LA MACARENA - LAURIBE - LEJANIAS - MAPIRIPAN - MESETAS - PUERTO CONCODIA - PUERTO GAITAN - PUERTO LLERAS - PUERTO LOPEZ - PUERTO RICO - RESTREPO - SAN CARLOS DEGUAROA - SAN JUAN DE ARAMA - SAN JUANITO - SAN MARTIN - VILLAVICENCIO - VISTA HERMOSA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('NORTE DE SANTANDER'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('7', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ARBOLEDAS - CUCUTILLA - GRAMALOTE - LOURDES - SALAZAR DE LAS PALMAS - SANTIAGO - VILLA CARO - CUCUTA - EL ZULIA - LOS PATIOS - PUERTO SANTANDER - SAN CAYETANO - VILLA DEL ROSARIO - BUCARASICA - EL TARRA - SARDINATA - TIBU - ABREGO - CACHIRA - CONVENCION - EL CARMEN - HACARI - LA ESPERANZA - LA PLAYA DE BELEN - OCAÑA - SAN CALIXTO - TEORAMA - CACOTA - CHITAGA - MUTISCUA - PAMPLONITA - SANTO DOMINGO DE SILOS - BOCHALEMA - CHINACOTA - DURANIA - HERRAN - LABATECA - RAGONVALIA - TOLEDO.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('BOLIVAR'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('8', 'border: B-L-R;');
            $table->easyCell(utf8_decode('ACHI - ALTOS DEL ROSARIO - ARENAL - ARJONA - ARROYOHONDO - BARRANCO DE LOBA - CALAMAR - CANTAGALLO - EL CARMEN DE BOLIVAR - CARTAGENA DE INDIAS - CICUCO - CLEMENCIA CORDOBA ELGUAMO - EL PEÑON - HATILLO DE LOBA - MAGANGUE - MAHATES - MARGARITA - MARIA LA BAJA - MONTECRISTO - MARIA LA BAJA - ARGARITA - MAHATES - MAGANGUE - HATILLO DE LOBA - EL PEÑON - EL GUAMO - CORDOBA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CORDOBA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('9', 'border: B-L-R;');
            $table->easyCell(utf8_decode('AYAPEL - BUENAVISTA - CANALETE - CERETE - CHIMA - CHINU - CIENEGA DE ORO - COTORRA - LA APARTADA - LOS CORDOBAS - MOMIL - MONTELIBANO - MONTERIA - MOÑITOS - PLANETA RICA - PUEBLO NUEVO - PUERTO ESCONDIDO - PUERTO LIBERTADOR - PURISIMA - SAHAGUN - SAN ANDRES DE SOTAVENTO - SAN ANTERO - SAN BERNARDO DEL VIENTO - SAN CARLOS - SAN JOSE DE URE - SAN PELAYO - SANTA CRUZ DE LORICA - TIERRALTA - TUCHIN - VALENCIA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('NARIÑO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('10', 'border: B-L-R;');
            $table->easyCell(utf8_decode('BARBACOAS - EL CHARCO - FRANCISCO PIZARRO - LA TOLA - MAGUI PAYAN - MOSQUERA - OLAYA HERRERA - ROBERTO PAYAN - SANTA BARBARA - TUMACO - ALDANA - CONTADERO - CORDOBA - CUASPUD - CUMBAL - FUNES - GUACHUCAL - GUALMATAN - ILES - IPIALES - POTOSI - PUERRES - PUPIALES - ALBAN - ARBOLEDA - BELEN - COLON - EL ROSARIO - EL TABLON DE GOMEZ - LA CRUZ - LA UNIÓN - LEIVA - POLICARPA - SAN BERNARDO - SAN LORENZO - SAN PABLO - SAN PEDRO DE CARTAGO - TAMINANGO - BUESACO - CHACHAGUI - CONSACA - EL PEÑOL - EL TAMBO - LA FLORIDA - NARIÑO - PASTO - SANDONA - TANGUA - YACUANQUER - ANCUYA - CUMBITARA - GUAITARILLA - IMUES - LA LLANADA - LINARES - LOS ANDES - MALLAMA - OSPINA - PROVIDENCIA - RICAURTE - SAMANIEGO - SANTACRUZ - SAPUYES - TUQUERRES.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('SAN JOSE DEL GUAVIARE'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('11', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CALAMAR - EL RETORNO - MIRAFLORES - SAN JOSE DEL GUAVIARE.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);
        
        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('VICHADA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('12', 'border: B-L-R;');
            $table->easyCell(utf8_decode('CUMARIBO, PUERTO CARREÑO, LA PRIMAVERA, SANTA ROSALÍA.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

    }else if($listar[0]['id_contrato'] == 259){
        
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('ANTIOQUIA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Antioquia: Medellín, Bello, Itagüí, Envigado, Apartadó, Turbo, Rionegro, Caucasia, Caldas, Copacabana, Chigorodó, La Estrella, Necoclí, La Ceja, Marinilla, Sabaneta, Sabaneta, Barbosa, Carepa, Andes, El Carmen de Viboral, Guarne, Puerto Berrío, El Bagre, Sonsón, Segovia, Urrao, Yarumal, Arboletes, Santa Rosa de Osos, Tarazá, San Pedro de Urabá, Cáceres, Bolívar, Amagá, Santuario, Zaragoza, San Vicente, Ituango, Santa Bárbara, Antioquia, Fredonia, San Pedro de los Milagros, Concordia, San Juan de Urabá, Remedios, Amalfi, Yolombó, Abejorral, Dabeiba, Frontino, Salgar, San Roque, La Unión, Nechí, Donmatías, El Retiro, Puerto Nare, Betulia, Cañasgordas, Valdivia, Puerto Triunfo, Támesis, El Peñol, Jardín, Cocorná, Yondó, Sopetrán, Venecia, Titiribí, San Rafael, Jericó, Angostura, Ebéjico, San Carlos, San Jerónimo, Santo Domingo, Gómez Plata, Vegachí, San Luis, Betania, Mutatá, Anorí, Cisneros, Granada, Liborina, Nariño, Entrerríos, Pueblorrico, Sabanalarga, Briceño, Caicedo, Angelópolis, Maceo, Peque, Montebello, Anzá, Uramita, Guatapé, Tarso, La Pintada, Argelia, Heliconia, Buriticá, Valparaíso, San Francisco, Yalí, Belmira, Guadalupe, Caramanta, Vigía del Fuerte, Toledo, Armenia, Hispania, Caracolí, San Andrés de Cuerquia, Concepción, Giraldo, Carolina del Príncipe, Alejandría, Murindó, Campamento, San José de la Montaña, Olaya, Abriaquí.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CHOCÓ'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Chocó: Quibdó, Alto Baudó, Istmina, Tadó, Bajo Baudó, Riosucio, Condoto, Unguía, Medio San Juan, Medio Baudó, Acandí, Medio Atrato, Bojayá, Bahía Solano, Bagadó, Lloró, Litoral de San Juan, El Carmen de Atrato, Cértegui, Nuquí, Río Quito, Río Iró, Nóvita, Unión Panamericana, Atrato, Cantón de San Pablo, El Carmen del Darién, San José del Palmar, Sipí, Juradó.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'CALDAS', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Caldas: Manizales, La Dorada, Chinchiná, Villamaría, Riosucio, Anserma, Neira, Supía, Pensilvania, Aguadas, Samaná, Salamina, Manzanares, Palestina, Pácora, Marquetalia, Filadelfia, Aranzazu, Viterbo, Belalcázar, Risaralda, Victoria, Marmato, Norcasia, La Merced, San José, Marulanda.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RISARALDA', 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Risaralda: Pereira, Dosquebradas, Santa Rosa de Cabal, Quinchía, La Virginia, Belén de Umbría, Marsella, Guática, Santuario, Apía, Mistrató, Pueblo Rico, La Celia, Balboa.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('QUINDÍO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Quindío: Armenia, Calarcá, Montenegro, Quimbaya, La Tebaida, Circasia, Filandia, Génova, Salento, Pijao, Córdoba, Buenavista.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('TOLIMA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Tolima: Ibagué, Espinal, Chaparral, Líbano, Guamo, Mariquita, Melgar, Fresno, Ortega, Coyaima, Flandes, Purificación, Honda, Planadas, Rioblanco, Rovira, Natagaima, Cajamarca, Venadillo, Lérida, Ataco, San Antonio, Saldaña, San Luis, Armero, Villahermosa, Icononzo, Palocabildo, Coello, Herveo, Alvarado, Prado, Cunday, Anzoátegui, Carmen de Apicalá, Falán, Ambalema, Casabianca, Santa Isabel, Valle de San Juan, Roncesvalles, Villarrica, Dolores, Piedras, Alpujarra, Murillo, Suárez.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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

        $pdf->addPage();

        $pdf->ln(10);

        $pdf->SetFont('Arial','B',9);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
        $pdf->SetFont('Arial','',8);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('HUILA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad de Huila: Neiva, Pitalito, Garzón, La Plata, Campoalegre, San Agustín, Gigante, Palermo, Acevedo, Isnos, Algeciras, Timaná, Aipe, Rivera, Guadalupe, Tarqui, Suaza, Tello, Pital, La Argentina, Palestina, Saladoblanco, Santa María, Oporapa, Íquira, Tesalia, Colombia, Agrado, Teruel, Yaguará, Villavieja, Hobo, Nátaga, Paicol, Baraya, Altamira, Elías.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('CAUCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad de Cauca: Popayán, Santander de Quilichao, Puerto Tejada, Bolívar, Caloto, Piendamó, Cajibío, El Tambo, Patía, La Vega, Miranda, Páez, Caldonó, Silvia, Timbío, Guapi, Inzá, Toribío, Morales, Balboa, Corinto, Buenos Aires, Guachené, Suárez, Almaguer, Mercaderes, Totoró, Timbiquí, Sotará, Puracé, Jambaló, Villa Rica, San Sebastián, López de Micay, Rosas, La Sierra, Padilla, Sucre, Florencia, Santa Rosa, Piamonte, Argelia.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('NARIÑO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad de Nariño: San Juan de Pasto, Tumaco, Ipiales, Samaniego, Túquerres, Barbacoas, La Unión, Olaya Herrera, El Charco, Sandoná, Cumbal, Buesaco, San José de Albán, San Lorenzo, Pupiales, La Cruz, Taminango, Roberto Payán, Santacruz, Guachucal, San Pablo, Los Andes, Ricaurte, San Bernardo, El Tablón de Gómez, Magüí Payán, El Tambo, Córdoba, Potosí, Guaitarilla, Chachagüí, Mosquera, Leiva, Providencia, Linares, El Rosario, Francisco Pizarro, La Florida, Tangua, Consacá, Yacuanquer, Policarpa, Colón, Puerres, Santa Bárbara, La Tola, Mallama, Ancuyá, Ospina, Cuaspud, Iles, Arboleda, Imués, Sapuyes, San Pedro de Cartago, Aldana, Funes, El Peñol, Contadero, Cumbitara, Gualmatán, Belén, Nariño, La Llanada.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('PUTUMAYO'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad de Putumayo: Valle del Guamuez, Puerto Asís, Orito, Mocoa, San Miguel, Villagarzón, Sibundoy, Puerto Caicedo, Puerto Leguizamo, Santiago, San Francisco, Puerto Guzmán, Colón.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, utf8_decode('VALLE DEL CAUCA'), 'L,R,T','1','F');
        $pdf->SetFont('Arial','',8);


        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R;');
            $table->easyCell(utf8_decode('Municipios de la comunidad Valle del Cauca: Cali, Buenaventura, Palmira, Tuluá, Cartago, Buga, Jamundí, Yumbo, Candelaria, Florida, El Cerrito, Pradera, Sevilla, Zarzal, Dagua, Roldanillo, La Unión, Guacarí, Caicedonia, Bugalagrande, Ansermanuevo, Ginebra, Trujillo, Andalucía, San Pedro, Riofrío, Toro, Yotoco, Darién, Bolívar, Obando, Restrepo, La Victoria, Alcalá, La Cumbre, Vijes, El Águila, El Cairo, El Dovio, Versalles, Argelia, Ulloa.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
        $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');

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

    

            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
            $pdf->SetFont('Arial','',8);
    
            $pdf->ln(1);
    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, 'CUNDINAMARCA', 'L,R,T','1','F');
            $pdf->SetFont('Arial','',8);
    
    
            $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
                $table->easyCell('1', 'border: B-L-R;');
                $table->easyCell(utf8_decode('Municipios de la comunidad Cundinamarca: Bogotá, Soacha, Fusagasugá, Facatativá, Zipaquirá, Chía, Girardot, Mosquera, Madrid, Funza, Cajicá, Ubaté, Guaduas, Sibaté, La Mesa, Pacho, Tocancipá, Villeta, La Calera, Sopó, Silvania, Tabio, El Colegio, Cota, Chocontá, Cogua, Tenjo, Villapinzón, Tociama, Cáqueza, Yacopi, Puerto Salgar, Nilo, Suesca, Caparrapí, El Rosal, Viotá, La Vega, Subachoque, Anolaima, Guasca, Fómeque, Ubalá, Agua de Dios, Arbeláez, Anapoima, Guachetá, Nemocón, Pasca, Chiachí, Simijaca, Gachancipá, San Anonio del Tequendama, Gachetá, Sasaima, San Bernardo, Susa, Cachipay, Sesquilé, Lenguazaque, Medina, San Juan del Rioseco, La Palma, Bojacá, Carmen de Carupa, Chipaque, San Franciso, Junín, Ricaurte, Quipile, Une, Apulo, Tena, Vergara, Paratebueno, Granada, La Peña, Cucunubá, Ubaque, Machetá, Fosca, Quetame, Albán, Cachalá, Guatavita, Nimaima, Pandi, Nocaima, Paime, San Cayetano, Fúquene, Zipacón, El Peñón, Supatá, Tibacuy, Sutatausa, Tausa, Guayabetal, Topaipí, Cabrera, Quebradanegra, Manta, útica, Vianí, Chaguaní, Venecia, Gama, Guayabal de Síquima, Gutíérrez, Tibirita, Pulí, Jerusalén, Bituima, Guataquí, Villagómez, Nariño, Beltran.'), 'border: T-B-L-R');
    
                $table->printRow();
            $table->endTable(0);
    
            $pdf->ln(1);
    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, 'SANTANDER', 'L,R,T','1','F');
            $pdf->SetFont('Arial','',8);
    
    
            $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
                $table->easyCell('1', 'border: B-L-R;');
                $table->easyCell(utf8_decode('Municipios de la comunidad Santander: Bucaramanga, Floridablanca, Barrancabermeja, San Juan de Girón, Piedecuesta, San Gil, Cimitarra, Puerto Wilches, Lebrija, San Vicente de Chucurí, Rionegro, Barbosa, Sabana de Torres, Vélez, Málaga, El Carmen de Chucurí, Puente Nacional, Landázuri , El Playón, Bolívar, Curití, Charalá, Oiba, Mogotes, Los Santos, Suaita, San Andrés, Sapatoca, Sucre, Simacota, Aratoca, Barichara, La Belleza, Villanueva, Guaca, Tona, Ouerto Parra, Florián, Cerrito, Coromoro, Capitanejo, Concepción, Matanza, Onzaga, El Peñón, La paz, Guadalupe, Molagavita, Betulia, Valle de San José, Carcasí, Chipatá, Ocamonte, San José de Miranda ,Santa Helena del Opón, Albania, Guavatá, Güepsa, Contratación, Enciso, San Benito, Gámbita, Pinchote, Páramo, Suratá, Jesús María, Chima, Charta, Galán, San Joaquín, Confines, Encino, Macaravita, San Miguel, Plamas del Socorro, Socorro, Hato, Santa Bárbara, El Guacamayo, Guapotá, Plamar, Cepitá, Cabrera, Aguada, California, Vetas, Jordán.'), 'border: T-B-L-R');
    
                $table->printRow();
            $table->endTable(0);
    
            $pdf->ln(1);
    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, utf8_decode('BOYACÁ'), 'L,R,T','1','F');
            $pdf->SetFont('Arial','',8);
    
    
            $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
                $table->easyCell('1', 'border: B-L-R;');
                $table->easyCell(utf8_decode('Municipios de la comunidad Boyacá: Tunja, Sogamoso, Duitama, Chiquinquirá, Puerto Boyacá, Paipa, Moniquirá, Samacá, Garagoa, Aquitania, Nobsa, Ventaquemada, Cómbita, Saboyá, Tibasosa, Ráquira, Santa Rosa de Veiterbo, Chita, Otanche, Pauna, Guateque, Úmbita, San Pablo de Borbur, Muzo, Socotá, Ramiriquí, Villa de Leyva, Tibaná, Miraflores, Pesca, Tuta, Toca, Soatá, Belén, Quípama, Sotaquirá, Maripí, Santana, Siachoque, Socha, Turmequé, Jenesano, Tasco, Chitaraque, Boavita, Cubará, Firavitoba, San Luis de Gaceno, Guayatá, Nuevo Colón, Motavita, Güicán, Chíquiza, iza, Soracá, Buenavista, Sutamarchán, San José de Pare, Tota, El Cocuy, Labranzagrande, Chiscas, Togüí, Ciénega, Arcabuco, Paz del Río, Mongua, Zetaquira, Chivatá, Boyacá, Monguí, Gámeza, Macanal, San Mateo, Jericó, Santa María, Cucaita, Sutatenza, Tenza, Cerinza, Coper, San Miguel de Sema, Campohermoso, El Espino, Caldas, Floresta, Sáchica, Tipacoque, Chinavita, Tópaga, Susacón, La Uvita, Viracachá, Somondoco, Páez, Covarachía, La Capilla, Santa Sofía, Gachantivá, Pachavita, Rondón, Sora, Tinjacá, Oicatá, Briceño, Sativanorte, Paya, Corrales, Betéitiva, Tutazá, Almeida, Pajarito, Chivor, Guacamayas, Cuítiva, San Eduardo, Berbeo, Panqueba, La Victoria, Tununguá, Pisba, Sativasur, Busbanzá.'), 'border: T-B-L-R');
    
                $table->printRow();
            $table->endTable(0);
    
            $pdf->ln(1);
            
            $pdf->SetXY(10,235);
            $pdf->SetFont('Arial','B',8);
    
            $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
            $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
            $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
            $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');
    
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
    
    
            $pdf->addPage();
    
    
            $pdf->ln(10);
    
            $pdf->SetFont('Arial','B', 9);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');
            $pdf->SetFont('Arial','',8);
    
            $pdf->ln(1);
    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, 'META', 'L,R,T','1','F');
            $pdf->SetFont('Arial','',8);
    
    
            $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
                $table->easyCell('1', 'border: B-L-R;');
                $table->easyCell(utf8_decode('Municipios de la comunidad Meta: Villavicencio, Acacías, Granada, Puerto López, San Martín, Cumaral, Puerto Gaitán, Vista Hermosa, Fuente de Oro, Puerto Lleras, Restrepo, Lejanías, Guamal, Puerto Concordia, La Uribe, Castilla La Nueva, Puerto Rico, San Juan de Arama, San Carlos de Guaroa, El Castillo, Cubarral, Mesetas, La Macarena, Cabuyaro, Barranca de Upía, El Dorado, El Calvario, San Juanito, Mapiripán.'), 'border: T-B-L-R');
    
                $table->printRow();
            $table->endTable(0);
    
            $pdf->ln(1);
    
    
            $pdf->SetFont('Arial','B',8);
            $pdf->Cell(7, 5, '', 1,'0','C');
            $pdf->Cell(183, 5, utf8_decode('CAQUETÁ'), 'L,R,T','1','F');
            $pdf->SetFont('Arial','',8);
    
    
            $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
                $table->easyCell('1', 'border: B-L-R;');
                $table->easyCell(utf8_decode('Municipios de la comunidad Caquetá: Florencia, San Vicente del Caguán, Cartagena del Chairá, El Doncello, Puerto Rico, La Montañita, El Paujil, Belén de los Andaquíes, Solano, San José del Fragua, Valparaíso, Puerto Milán, Solita, Curillo, Albania, Morelia.'), 'border: T-B-L-R');
    
                $table->printRow();
            $table->endTable(0);
    
            $pdf->ln(1);
    
            $pdf->SetXY(10,235);
            $pdf->SetFont('Arial','B',8);
    
            $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
            $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
            $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');
            $pdf->Cell(110,20,$pdf->Image($code39,$pdf->GetX()+15, $pdf->GetY()+1, 80),'B L R',1,'C');
    
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
    
    } else {

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'RECORRIDOS', 1,'1','F');

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 'L,R,T','1','F');
        
        $pdf->SetFont('Arial','',8);

        $pdf->Cell(7, 5, '1', 'L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Chia, Cajica, Tenjo, Tabio, Zipaquirá, Nemocón, Suesca, Sopo, Aposentos, Neusa, Siecha, Guasca, Guatavita.'), 1,'1','F');

        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('2', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chochontá, Villapinzon, Turmequé, Ramiriqui, Samaca, Sachica, Villa de Leyva, Soraca, Tunja, Combita, Tuta, Sotaquira, Paipa, Duitama, Nobsa, Sogamoso, Mongui, Mongua.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->Cell(7, 5, '3', 'L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Bogotá, La Calera, Santa Isabel, Siecha, Guasca, Meusa, Sopo, Tocancipa, Aposentos, Chia.'), 'L,B,R','1','F');

        $pdf->Cell(7, 5, '4', 'L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Cajica, Zipaquirá, Chochota, Tunja, Duitama, Cerinza, Susacon, Soata, Boavita, Uvita, Guacamayas, San Ignacio, El cocuy, Guican'), 'L,B,R','1','F');
        $pdf->Cell(7, 5, '5', 'L,B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Tocancipa, Gachancipa, Chocontá, Sesquile, Puente de Boyacá, Tunja, Villa de Leyva.'), 'L,B,R','1','F');

        $pdf->ln(1);
        
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA SUR', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Autopista Sur, Soacha, Viota, Granada, Silvania, Fusagasuga, Melgar, Girardot, Mosquera, Madrid, Facatativa, La gran via, La mesa, Mesitas el colegio, Anapoima, Apulo, Tocaima, Agua de Dios, Nilo, Ricaurte, Espinal, Guamo, Saldaña, Purificación, Murillo, Natagaima, La Yeguera, Guacirco, Forcalacillas, Buziraco, Neiva.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->Cell(7, 5, '2', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 13, Tres Esquinas, Funza, Mosquera, Madrid, Bojaca, Facatativa, Zipacon, Cachipay, El Ocaso, La Esperanza, La Gran Via, La Mesa.'), 'L-B-R','1','F');

        $pdf->Cell(7, 5, '3', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Sur, Mondoñedo, Gran Via, El Triunfo, La Mesa, Mesitas del Colegio.'), 'L-B-R','1','F');
        
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('4', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Espinal, Ibagué, Coello Cocora, Cajamarca, Calarca, Armenia, Circasia, Salento, Montenegro, El Meson, Parque del café, La Tebaida, Panaca, Pueblo Tapado, Parque los Arrieros, La Paila, Bugalagrande, Andalucia, Tulua, Buga, Guacari, El Cerrito, Palmira, Yumbo, Cali.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('5', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Soacha, Fusagasuga, Melgar, Girardot, Ibagué, Armenia, Circasia, Salento, El Manzano, La Ye, Huertas, Pereira, Dos Quebradas, La Unión, Renacimiento, Santa Rosa de Cabal, Termales de Santa Rosa de Cabal.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->Cell(7, 5, '6', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Usme, Chipaque, Puente Quetame, Guayabetal, Pirapal, Villavicencio, Restrepo, Acacias, Granada, Fuente de oro, Puerto Lopez.'), 'L-B-R','1','F');

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Sobachoque, El Rosal, Alto del Vino, San Francisco, La Vega, Utica, Villeta.'), 'L-B-R','1','F');
        
        $pdf->Cell(7, 5, '2', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Medellín, Calle 80, Siberia, Cota, Chia, Cajica, Zipaquira. '), 'L-B-R', '1','F');

        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('3', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Calle 80, Madrid, San Franciso, La Vega, Villeta, Guaduas, Cachipai, Puerto Vargas, La Dorada, El Guamo, Puerto Boyaca, Puerto Nare, Garrapata, Puerto Araujo, Dagota, Villa Nueva Lebrija, Bucaramanga, Rio Negro, El Playón.'), 'border: B-L-R');

            $table->printRow();
        $table->endTable(0);

        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('4', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Cajica, Sopo, Tocancipa, El Sisga, Choconta, Villa Pinzon, Ventaquemada, Tunja, Arcabuco, Socorro, San Gil, Curiti, Aratoca, Piedecuesta, La Parcela, Florida Blanca, Bucaramanga, Aguachica, Pailitas San Alberto, Urumita, Barrancas Albania, La Guajira, Maicao, Riohacha.'), 'border: T-B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->Cell(7, 5, '5', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Calle 80, Siberia, Mosquera, La Mesa, Tocaima, Anapoima, Girardot, Flandes, Gualanday, Ibagué.'), 'L-B-R','1','F');

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',7);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');

        $pdf->Cell(90,20,$pdf->Code39($pdf->GetX()+3, $pdf->GetY()+3, $codigo1 ,1,9),'B L R',1,'C');

        $pdf->SetXY(100,235);
        $pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
        $pdf->SetXY(130,240);
        $pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
        $pdf->SetXY(130,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');


        $pdf->addPage();

        $pdf->Cell(0, 15, utf8_decode(''), 0,'1','F');

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA NORTE', 1,'1','F');
        
        $pdf->SetFont('Arial','',8);
        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('1', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Villeta, Guaduas, Honda, La Dorada, Puerto Boyaca, Puerto Araujo, Yarima, Barrancabermeja, San Alberto, San Martin, Los Angeles, Aguachica, Pailita, San Roque, La Aurora, La Loma, Cuatro Vientos La Esperanza, Bosconia, El Copel, San Tomas Tucuringa, Guamachito, La Isabel, Gaira, Rodadero, Playa Blanca, Santa Marta, Taganga, Bahia Concha, Gairaca.'), 'border: B-L-R');

            $table->printRow();
        $table->endTable(0);

        $table = new easyTable($pdf, '{7,183}', 'font-size: 8; font-family:Arial;');
            $table->easyCell('2', 'border: B-L-R; align: C');
            $table->easyCell(utf8_decode('Madrid, Villeta, Guaduas, La Dorada, Doradal, Rio Negro, Envigado, Guatape, Pueblito Paisa, San Rafael, San Carlos, Santa Rosa de Osos, Yarumal, Valdivia, Monte libano, Alto Genoba, Monteria, San Pelayo, San Pues, Lorica, Sincelejo, Santiago de Tolú, San Onofre, Carmen de Bolivar, San Juan, Nepomuceno, Arjona, Turbaco, Cartagena, La Boquilla, Clemencia, Luruaco, Sabana Larga, Calamar, Barranquilla, Cienaga, Gaira, Minca, Buritacá, Palomino, Dibulla, Camarones, Riohacha.'), 'border: B-L-R');

            $table->printRow();
        $table->endTable(0);

        $pdf->ln(1);

        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(7, 5, '', 1,'0','C');
        $pdf->Cell(183, 5, 'ZONA ORIENTE', 1,'1','F');

        $pdf->SetFont('Arial','',8);
        $pdf->Cell(7, 5, '1', 'L-B', '0','C');
        $pdf->Cell(183, 5, utf8_decode('Patios, La Calera, Guasca, Guatavita, Sesquile.'), 'L-B-R', '1','F');

        $pdf->Cell(7, 5, '2','L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Avenida Circunvalar, Monserrate, Choachi, Ubaque, Fomeque'), 'L-B-R','1','F');

        $pdf->Cell(7, 5, '3', 'L-B','0','C');
        $pdf->Cell(183, 5, utf8_decode('Autopista Norte, La Caro, Briceño, Sopo, Guasca, Guatavita, Sesquile.'), 'L-B-R','1','F');

    }

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',7);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');

        $pdf->Cell(90,20,$pdf->Code39($pdf->GetX()+3, $pdf->GetY()+3, $codigo1 ,1,9),'B L R',1,'C');

        $pdf->SetXY(100,235);
        $pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
        $pdf->SetXY(130,240);
        $pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
        $pdf->SetXY(130,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');
}

/* ------------------------------------------------------------ */
/* ------------------- ANEXO USUARIOS FIJOS ------------------- */
/* ------------------------------------------------------------ */


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
            $pdf->Cell(95,5, strtoupper(utf8_decode($luco['nombre_usuario'])), 0,0,'C');
            $pdf->Cell(95,5,$luco['numero_documento'], 0,1,'C');

            $i++;
            }
        }

        while($restante > 0){
            $pdf->SetFont('Arial','',9);
            $pdf->Cell(190, 5, "", 0,'1','C');

            $restante--;
        }

        $pdf->SetXY(10,235);
        $pdf->SetFont('Arial','B',8);

        $pdf->Cell(90,5,'CALLE 73 # 75 - 55 BOGOTA PBX 5559260/61/65','L R T',1,'C');
        $pdf->Cell(90,4,'GLPGERENCIA@ORTSAS.COM','L R',1,'C');
        $pdf->Cell(90,4,'BOGOTA - COLOMBIA','L R',1,'C');

        $pdf->Cell(90,20,$pdf->Code39($pdf->GetX()+3, $pdf->GetY()+3, $codigo1 ,1,9),'B L R',1,'C');

        $pdf->SetXY(100,235);
        $pdf->Cell(30,33,$pdf->Image($qr,$pdf->GetX()+1, $pdf->GetY()+4, 28),'B R T',0,'C');
        $pdf->SetFont('Arial','B',8);
        $pdf->Cell(70,5,'REPRESENTANTE LEGAL O GERENTE','R T',1,'C');
        $pdf->SetXY(130,240);
        $pdf->Cell(70,23,$pdf->Image($sello,$pdf->GetX()+8, $pdf->GetY()+3, 50),'R',1,'C');
        $pdf->SetXY(130,263);
        $pdf->Cell(2,5,'','B',0,'C');
        $pdf->SetFont('Arial','',8);
        $pdf->Cell(66,5,'FIRMA Y SELLO','B T',0,'C');
        $pdf->Cell(2,5,'','B R',1,'C');
    }

$pdf->Output();
ob_end_flush();

?>