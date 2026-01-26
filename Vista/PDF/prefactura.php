<?php

ob_start();
include ("../../Controlador/Sesion/autenticar.php");
require('../../Resources/fuec/fpdf.php');
require('../../Resources/fpdf-easytable-master/exfpdf.php');
require('../../Resources/fpdf-easytable-master/easyTable.php');
require_once("../../Modelo/EmpresaEnt.php");
require_once("../../Modelo/Operativo.php");
require_once("../../Modelo/Contrato.php");
require_once("../../Modelo/Usuario.php");
require_once("../../Modelo/Cliente.php");
require_once("../../Modelo/Ciudad.php");

$operativo = new Operativo();
$contrato = new Contrato();
$usuario = new Usuario();
$cliente = new Cliente();
$empresa = new Empresa();
$ciudad = new Ciudad();

if ($_GET) {

    if ($_GET['id_cliente'] != "") {
        $id_cliente = " = " . $_GET['id_cliente'];
    }else{
        if($clientes == 'ALL'){
            $id_cliente = "LIKE '%%'";
        }else{
            $id_cliente = "IN ('". $clientes ."')";
        }
    }

    if ($_GET['tipo_servicio'] != "") {
        $tipo_servicio = $_GET['tipo_servicio'];
    }else{
        $tipo_servicio = "";
    }
    
    if ($_GET['fecha_inicial'] != "") {
        $fecha = $_GET['fecha_inicial'];
    }else{
        $fecha = "0000-00-00";
    }
    
    if ($_GET['fecha_final'] != "") {
        $fecha2 = $_GET['fecha_final'];
    }else{
        $fecha2 = "9999-99-99";
    }
    
    if ($_GET['emisor'] != "") {
        $emisor = $_GET['emisor'];
    }else{
        $emisor = "";
    }
    
    if ($_GET['id_vehiculo'] != "") {
        $id_vehiculo = " = '" . $_GET['id_vehiculo']. "'";
    }else{
        $id_vehiculo = "LIKE '%%'";
    }
    
    if ($_GET['id_conductor'] != "") {
        $id_conductor = " = '" . $_GET['id_conductor']. "'";
    }else{
        $id_conductor = "LIKE '%%' ";
    }
    
    if ($_GET['pend_asignacion'] != "") {
        $estado = " = '" . $_GET['pend_asignacion'] . "'";
    }else{
        $estado = " != 'E' ";
    }
    
    if ($_GET['id_producto'] != "") {
        $id_producto = $_GET['id_producto'];
    }else{
        $id_producto = "";
    }

}

/* DATA GENERAL */
$listarServicios = $operativo->reporteServiciosConsolidadoCliente($fecha, $fecha2, $id_cliente, $tipo_servicio, $emisor, $id_vehiculo, $id_conductor, $estado, $id_producto);

$totalcliente = 0; 
$totalmovil = 0; 

foreach ($listarServicios as $ls) {
    $totalcliente =  ($totalcliente + $ls['valor_cliente']); 
    $totalmovil = ($totalmovil + $ls['valor_movil']);  
}

$valorTotal = ($totalcliente + $totalmovil);

/* CLIENTE FACTURACIÓN */
$listarClienteID = $cliente->cliente_ID($_GET['id_cliente']);

/* CONTRATO */
$listarContratoID = $contrato->listarId($_GET['id_contrato']);

/* EMPRESA */
$listarEmpresaPorId = $empresa->listarPorId($listarContratoID[0]['id_empresa']);
$logo = $listarEmpresaPorId[0]['logo'];

date_default_timezone_set('America/Bogota');

class PDF extends exFPDF{

    function  Header(){
        
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

$pdf->SetFont('Helvetica','B', 15);
$table = new easyTable($pdf, '{50,76,64}', 'font-size: 15; ');        
    $table->easyCell("", 'img: ../../Resources/fpdf/img/'. $logo . ',h20;');
    $table->easyCell("");
    $table->easyCell(utf8_decode("FACTURA PROFORMA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
    $table->printRow();    
$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{50,76,64}', 'font-size: 7; ');        
    $table->easyCell('No . ' . date('HisYmd'), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B";');
    $table->easyCell("");
    $table->easyCell(utf8_decode($listarEmpresaPorId[0]['nombre_empresa'] . " NIT." . $listarEmpresaPorId[0]['nit_empresa']), 'font-color:#BF1F1F; align:C; valign:M; font-style:"B"; ');
    $table->printRow();    
$table->endTable(0);

$pdf->Ln(5);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{63,63,1,25,38}', 'font-size: 6.5; ');
            
    $table->easyCell("SERVICIO ESPECIALIZADO EN TRANSPORTE ESCOLAR EMPRESARIAL Y TURISMO A NIVEL NACIONAL", 'border: L,B,T; align:C; valign:M; ');
    $table->easyCell("NO SOMOS GRANDES CONTRIBUYENTES NI AUTORRETENEDORES REGIMEN COMUN ACTIVIDAD ECONOMICA ICA 4921 ", 'border: L,B,T,R; align:C; valign:M; font-style:"";');
    $table->easyCell("");
    $table->easyCell(utf8_decode("FECHA FACTURACIÓN"), 'border: L,B,T; align:C; valign:M; font-style:"B"; ');
    $table->easyCell(date('Y-m-d'), 'border: L,B,T,R; align:C; valign:M; font-style:""; ');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Helvetica','B',6.4);
$pdf->Cell(190, 4, utf8_decode("CALLE 73 # 75 - 55 - TELÉFONO : 559260 - CORREO ELECTRÓNICO : ASISTCONTABLE@LINEASPREIUM.COM - BOGOTÁ D.C. COLOMBIA"), 1, 1,'C');

$pdf->Ln(3);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{35,90,25,40}', 'font-size: 7; ');
            
    $table->easyCell(utf8_decode("NOMBRE"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; ');
    $table->easyCell(utf8_decode($listarClienteID[0]['razon_social']), 'border: L,B,T; align:C; valign:M; font-style:"";');
    $table->easyCell(utf8_decode("No. SERVICIO"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:"B"; ');
    $table->easyCell($_GET['num_servicio'], 'border: L,B,T,R; align:C; valign:M; font-style:""; ');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{35,90,25,40}', 'font-size: 7; ');
            
    $table->easyCell(utf8_decode("DIRECCIÓN"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; ');
    $table->easyCell(utf8_decode($listarClienteID[0]['direccionC']), 'border: L,B,T; align:C; valign:M; font-style:"";');
    $table->easyCell(utf8_decode("TELÉFONO"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:"B"; ');
    $table->easyCell(utf8_decode($listarClienteID[0]['telefonoC']), 'border: L,B,T,R; align:C; valign:M; font-style:""; ');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(1);


$listarCiudadCliente = $ciudad->listarCiudadPorId($listarClienteID[0]['id_ciudad']);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{35,60,35,60}', 'font-size: 7; ');
            
    $table->easyCell(utf8_decode("NIT"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; ');
    $table->easyCell(utf8_decode($listarClienteID[0]['nit_cliente']), 'border: L,B,T; align:C; valign:M; font-style:"";');
    $table->easyCell(utf8_decode("CIUDAD"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:"B"; ');
    $table->easyCell(utf8_decode($listarCiudadCliente[0]['ciudad']), 'border: L,B,T,R; align:C; valign:M; font-style:""; ');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{35,60,35,60}', 'font-size: 7; ');
    $text = "CONTRATO No " . $_GET['id_contrato'] . " - " . $listarClienteID[0]['razon_social'] . ', GENERADO DESDE ' . $fecha . ' HASTA ' . $fecha2 . '.';
    $table->easyCell(utf8_decode("POR CONCEPTO DE"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M;');
    $table->easyCell($text, 'border: L,B,T; align:C; valign:M; font-style:"";');
    $table->easyCell(utf8_decode("RESPONSABLE"), 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:"B"; ');
    $table->easyCell($listarContratoID[0]['nombre_responsable'], 'border: L,B,T,R; align:C; valign:M; font-style:""; ');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(3);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{30,80,40,40}', 'font-size: 7;');
            
    $table->easyCell(utf8_decode("CANTIDAD"), 'bgcolor: #274054; font-color: #FFF; border: T,R; border-color:#fff; align:C; valign:M;');
    $table->easyCell(utf8_decode("DESCRIPCIÓN"), 'bgcolor: #274054; font-color: #FFF; border: L,T,R; border-color:#fff; align:C; valign:M;');
    $table->easyCell(utf8_decode("VALOR UNITARIO"), 'bgcolor: #274054; font-color: #FFF; border: L,T,R; border-color:#fff; align:C; valign:M;');
    $table->easyCell(utf8_decode("VALOR TOTAL"), 'bgcolor: #274054; font-color: #FFF; border: L,T; border-color:#fff; align:C; valign:M;');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(1);

/* DATA */ 
$restantes = 12;

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{30,80,40,40}', 'font-size: 7;');
            
    $table->easyCell($listarServicios[0]['total'], 'border: L,T; align:C; valign:M;');
    $table->easyCell(utf8_decode("SERVICIO DE TRANSPORTE ESPECIAL"), 'border: T; align:C; valign:M;');
    $table->easyCell('$ -', 'border: T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ '. number_format($totalcliente), 'border: T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->SetFont('Helvetica','B', 7);

for ($i=0; $i < $restantes; $i++) { 
    if($i+1 === $restantes){
        $table = new easyTable($pdf, '{190}', 'font-size: 7;');
            $table->easyCell(utf8_decode(""), 'border: L,B,R; align:C; valign:M;');
            $table->printRow();
        $table->endTable(0);  

        $pdf->Ln(3);
    }else{
        $table = new easyTable($pdf, '{190}', 'font-size: 7;');
            $table->easyCell(utf8_decode("  "), 'border: L,R; align:C; valign:M;');
            $table->printRow();
        $table->endTable(0);  
    }
}

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{109,1,40,40}', 'font-size: 7;');
            
    $table->easyCell("");
    $table->easyCell("");
    $table->easyCell('SUBTOTAL', 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ '. number_format($totalcliente), 'border: L,B,T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->Ln(1);

$table = new easyTable($pdf, '{109,1,40,40}', 'font-size: 7;');
            
    $table->easyCell("");
    $table->easyCell("");
    $table->easyCell('DESCUENTOS', 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ -', 'border: L,B,T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->Ln(1);


$table = new easyTable($pdf, '{109,1,40,40}', 'font-size: 7;');
            
    $table->easyCell("");
    $table->easyCell("");
    $table->easyCell('RETEFUENTE', 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ -', 'border: L,B,T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->Ln(1);


$table = new easyTable($pdf, '{109,1,40,40}', 'font-size: 7;');
            
    $table->easyCell("");
    $table->easyCell("");
    $table->easyCell('RETEICA', 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ -', 'border: L,B,T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->Ln(1);

$table = new easyTable($pdf, '{109,1,40,40}', 'font-size: 7;');
            
    $table->easyCell("");
    $table->easyCell("");
    $table->easyCell('VALOR TOTAL', 'bgcolor: #274054; font-color: #FFF; border: L,B,T; align:C; valign:M; font-style:B; ');
    $table->easyCell('$ '. number_format($totalcliente), 'border: L,B,T,R; align:C; valign:M; font-style:B; ');

    $table->printRow();
        
$table->endTable(0);   

$pdf->Ln(3);

$pdf->SetFont('Helvetica','B', 7);
$table = new easyTable($pdf, '{30,160}', 'font-size: 7;');
            
    $table->easyCell(utf8_decode("OBSERVACIONES: "), 'border: T,L,B; align:C; valign:M; font-style:B;');
    $table->easyCell(utf8_decode(""), 'border: T,B,R; align:C; valign:M;');

    $table->printRow();
        
$table->endTable(0);

$pdf->Ln(3);

$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(190, 5, "SON: ", 1, 1,'C');

$pdf->SetFont('Helvetica','', 7);
$table = new easyTable($pdf, '{190}', 'font-size: 7;');
    $table->easyCell(utf8_decode("1. La presente factura de venta constituye Titulo valor en los términos de la ley 1231 de 2008. 2. Si la factura es cancelada con cheque y éste fuese devuelto por cualquier razón causará el 20% de sanción, según artículo 722 del C.C. y únicamente es considerada cancelada cuando se haga efectivo el valor respectivo. 3. En caso de mora en el pago de las fechas estipuladas, se cobrará un interés moratorio diario a la tasa máxima permitida por la ley. 4. Se hace constar que la persona distinta al cliente está autorizada por el cliente para firmar confesar la deuda y obligar al cliente."), 'border: L,T,B,R; align:C; valign:M;');
    $table->printRow();
$table->endTable(0);

$pdf->Ln(3);

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(70, 5, "", 'L,T,R', 0,'C');
$pdf->Cell(120, 5, "Recibi de conformidad el servicio de que trata esta factura y acepto el valor estipulado en la misma", 'T,R,B', 1,'C');

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(70, 5, "", 'L,R', 0,'C');
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(30, 5, "NOMBRE", 'B', 0,'J');
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(40, 5, "", 'R,B', 0,'C');
$pdf->Cell(50, 5, "", 'R', 1,'C');

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(70, 5, "", 'L,R', 0,'C');
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(30, 5, "DOCUMENTO", 'B', 0,'J');
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(40, 5, "", 'R,B', 0,'C');
$pdf->Cell(50, 5, "", 'R', 1,'C');

$pdf->SetFont('Helvetica','',7);
$pdf->Cell(70, 5, "", 'L,R', 0,'C');
$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(30, 5, "FECHA RECIBO", 'B', 0,'J');
$pdf->SetFont('Helvetica','',7);
$pdf->Cell(40, 5, "", 'R,B', 0,'C');
$pdf->Cell(50, 5, "", 'R', 1,'C');


$pdf->SetFont('Helvetica','B',7);
$pdf->Cell(4, 5, "", 'L,B', 0,'C');
$pdf->Cell(62, 5, "FIRMA Y SELLOS AUTORIZADOS", 'T,B', 0,'C');
$pdf->Cell(4, 5, "", 'B', 0,'C');

$pdf->Cell(35, 5, "", 'B,R', 0,'J');
$pdf->Cell(35, 5, "", 'B', 0,'J');

$pdf->Cell(4, 5, "", 'B', 0,'C');
$pdf->Cell(42, 5, "FIRMA Y SELLO CLIENTE", 'T,B', 0,'C');
$pdf->Cell(4, 5, "", 'B,R', 1,'C');

$pdf->Ln(3);

$listarUsuarioPorId = $usuario->listarUsuarioPorId($_SESSION['id_usuario']);

$pdf->SetFont('Helvetica','B',6);
$pdf->Cell(190, 5, "EMITIDO POR : " . $listarUsuarioPorId[0]['nombre'] . ' -  ' . date('Y-m-d g:i A'), 0, 1,'R');

$pdf->Output();	

?>