<?php 

ob_start();
include ("Sesion/autenticar.php");

require('../../Resources/fuec/fpdf.php');
require('../../Resources/fpdf-easytable-master/exfpdf.php');
require('../../Resources/fpdf-easytable-master/easyTable.php');
require('../../Modelo/ConceptosCobro.php');
require('../../Modelo/Vehiculo.php');
require('../../Modelo/Usuario.php');
require('../../Modelo/General.php');
require('../../Modelo/Cartera.php');
date_default_timezone_set('America/Bogota');

$vehiculo = new Vehiculo();
$cartera = new Cartera();
$usuario = new Usuario();
$conceptoCobro = new ConceptoCobro();

$id = explode("-", $_GET['num_id_comprobante']);

$num_id_comprobante = $id[0];
$id_usuario = $id[1];

$listarPagosComprobantesPorNumIdComprobante = $conceptoCobro->listarPagosComprobantesPorNumIdComprobante($num_id_comprobante);
$listarPorIdCobrosPropietario = $conceptoCobro->listarPorIdCobrosPropietario($listarPagosComprobantesPorNumIdComprobante[0]['id_cobro_propietario']);

$listarVehiculoPorId = $vehiculo->listarPorId($listarPorIdCobrosPropietario[0]['id_vehiculo']);
$listarPropietarioVehiculo = $usuario->listarUsuarioPorId($listarVehiculoPorId[0]['id_propietario']);
$listarUsuarioPorId = $usuario->listarUsuarioPorId($id_usuario);

$ListaConceptos = array();

foreach($listarPagosComprobantesPorNumIdComprobante As $lpc){
    $listarCobrosPropietario1 = $conceptoCobro->listarPorIdCobrosPropietario($lpc['id_cobro_propietario']);
    $listarConceptoPorId1 = $conceptoCobro->listarPorId($listarCobrosPropietario1[0]['id_concepto']);
    $fechaPagoServicio1 = explode("-", $listarCobrosPropietario1[0]['fecha_cobro']);
    $mes1 = $fechaPagoServicio1[1];
    $anio1 = $fechaPagoServicio1[0];
    array_push ($ListaConceptos, $listarConceptoPorId1[0]['detalle_concepto'] . ' - ' . strtoupper(mes($mes1)));
}

$conceptos = "";

for($i = 0; $i < count($ListaConceptos); $i++){
    if((count($ListaConceptos) - 1) == $i){
        $conceptos .=  $ListaConceptos[$i];   
    }else{
        $conceptos .=  $ListaConceptos[$i] . ", ";     
    }
    
}

$nombreArchivo = date('YmdHis') . "-RECIBOCAJAKV.pdf";
$fecha_creacion = date('Y-m-d H:i:s');

$registrarReciboCaja = $conceptoCobro->registrarReciboCaja($nombreArchivo, $fecha_creacion);


class PDF extends exFPDF{
	
    function  Header(){

        $vehiculo2 = new Vehiculo();
        $conceptoCobro2 = new ConceptoCobro();

        $id2 = explode("-", $_GET['num_id_comprobante']);

        $num_id_comprobante2 = $id2[0];

        $listarPagosComprobantesPorNumIdComprobante2 = $conceptoCobro2->listarPagosComprobantesPorNumIdComprobante($num_id_comprobante2);
        $listarPorIdCobrosPropietario2 = $conceptoCobro2->listarPorIdCobrosPropietario($listarPagosComprobantesPorNumIdComprobante2[0]['id_cobro_propietario']);

        $listarVehiculoPorId2 = $vehiculo2->listarPorId($listarPorIdCobrosPropietario2[0]['id_vehiculo']);
      

        if (($listarVehiculoPorId2[0]['numero_movil'] >= 1)&&($listarVehiculoPorId2[0]['numero_movil'] <= 999)){ 
            $this->SetFont('Arial','B',9);
            $this->Cell(20, 10, "", 0, '0','J');
            $this->Cell(145,27,$this->Image("../../Resources/fpdf/img/logo-ort.jpg", $this->GetX()+6, $this->GetY()+1, 40),0,1,'J');
            $this->SetFont('Arial','B',9);
            $this->Cell(20, 5, "", 0, '0','J');
            $this->Cell(145, 5, utf8_decode("ORGANIZACIÓN ORT SAS"), 0, '1','J');
            $this->Cell(20, 5, "", 0, '0','J');
            $this->Cell(51, 5, utf8_decode("NIT: ") . "830099803", 0, '0','C');
            $this->Cell(119, 5, "", 0, '1','J');
            $this->Ln(5);

        } else if (($listarVehiculoPorId2[0]['numero_movil'] >= 1000) && ($listarVehiculoPorId2[0]['numero_movil'] <= 1999)){ 
            $this->SetFont('Arial','B',9);
            $this->Cell(20, 10, "", 0, '0','J');
            $this->Cell(145,27,$this->Image("../../Resources/img/logo-lp.png", $this->GetX()-2, $this->GetY()+1, 40),0,1,'J');
            $this->SetFont('Arial','B',9);
            $this->Cell(20, 5, "", 0, '0','J');
            $this->Cell(145, 5, utf8_decode("LINEAS PREMIUM SAS"), 0, '1','J');
            $this->Cell(7, 5, "", 0, '0','J');
            $this->Cell(61, 5, utf8_decode("NIT: ") . "900461872 - 8", 0, '0','C');
            $this->Cell(119, 5, "", 0, '1','J');
            $this->Ln(5);
        }
        
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

$id_recibo_caja = "KV - " . str_pad($registrarReciboCaja, 4, "0", STR_PAD_LEFT);

$table = new easyTable($pdf, '{99,75,16}', 'font-size: 9; height:15; ');    
    $table->rowStyle('min-height:15');
    $table->easyCell("");
    $table->easyCell(utf8_decode("RECIBO CAJA N° ") . $id_recibo_caja, 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
    $table->easyCell("");
    $table->printRow();    
$table->endTable(0);

$pdf->Ln(1);

$table = new easyTable($pdf, '{16,158,16}', 'font-size: 8;');    
    $table->easyCell("");
    $table->easyCell(utf8_decode("BENEFICIARIO"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
    $table->easyCell("");
    $table->printRow();    
$table->endTable(0);

$pdf->Ln(1);

$pdf->SetFont('Arial','',7);
$pdf->Cell(16, 5, "", 0, 0,'J');
$pdf->Cell(158, 5, utf8_decode($listarPropietarioVehiculo[0]['nombre']), '1', 0,'C');
$pdf->Cell(16, 5, "", 0, 1,'J');

$pdf->Ln(1);

$table = new easyTable($pdf, '{16,80,1,77,16}', 'font-size: 8;');    
    $table->easyCell("");
    $table->easyCell(utf8_decode("NIT - CEDULA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
    $table->easyCell("");
    $table->easyCell(utf8_decode("POR CONCEPTO(S) DE"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
    $table->easyCell("");
    $table->printRow();    
$table->endTable(0);

$pdf->Ln(1);

$table = new easyTable($pdf, '{16,80,1,77,16}', 'font-size: 7; ');           
    $table->easyCell("");
    $table->easyCell(utf8_decode($listarPropietarioVehiculo[0]['usuario']), 'border: L,R,B,T; align:C;');
    $table->easyCell("");
    $table->easyCell(utf8_decode($conceptos), 'border: L,R,T; align:C;');
    $table->easyCell("");
    $table->printRow();      
$table->endTable(0);

$table = new easyTable($pdf, '{16,28,26,26,1,77,16}', 'font-size: 8; ');           
    $table->easyCell("");
    $table->easyCell(utf8_decode("DIRRECCIÓN"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("CIUDAD"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("TELEFONO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell("");
    $table->easyCell(utf8_decode(""), 'border: L,R; align:C;');
    $table->easyCell("");
    $table->printRow();      
$table->endTable(0);


$pdf->SetFont('Arial','',7);
$table = new easyTable($pdf, '{16,28,26,26,1,77,16}', 'font-size: 7; ');

    $table->easyCell("");
    $table->easyCell(utf8_decode(strtoupper($listarVehiculoPorId[0]['direccion_propietario'])), 'border: L,B; align:C;' );
    $table->easyCell(utf8_decode(strtoupper($listarVehiculoPorId[0]['direccion_propietario'])), 'border: L,R,B; align:C;');
    $table->easyCell(utf8_decode(strtoupper($listarVehiculoPorId[0]['telefono_propietario'])), 'border: L,R,B; align:C;');
    $table->easyCell("");
    $table->easyCell(utf8_decode(""), 'border: L,R,B; align:C;');
    $table->easyCell("");
    
    $table->printRow();
    
$table->endTable(0);

$pdf->Ln(1);

$table = new easyTable($pdf, '{16,42,42,1,37,36,16}', 'font-size: 8;');           
    $table->easyCell("");
    $table->easyCell(utf8_decode("FECHA DOCUMENTO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("FECHA VENCIMIENTO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell("");
    $table->easyCell(utf8_decode("ELABORADO POR"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("CHEQUE No."), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode(""));
    $table->easyCell("");
    $table->printRow();      
$table->endTable(0);


$pdf->Ln(1);

$fechaDoc = explode("-", date("Y-m-d"));
$anio = $fechaDoc[0];
$mes = mes($fechaDoc[1]);
$dia = $fechaDoc[2];

$table = new easyTable($pdf, '{16,42,42,1,37,36,16}', 'font-size: 7; ');

    $table->easyCell("");
    $table->easyCell(utf8_decode($dia . " DE " . strtoupper($mes) . " DE " . $anio), 'border: L,B,T; align:C;' );
    $table->easyCell(utf8_decode($dia . " DE " . strtoupper($mes) . " DE " . $anio), 'border: L,R,B,T; align:C;');
    $table->easyCell("");
    $table->easyCell(utf8_decode($listarUsuarioPorId[0]['nombre']), 'border: L,R,B,T; align:C;');
    $table->easyCell(utf8_decode(""), 'border: R,B,T; align:C;');
    $table->easyCell("");
    
    $table->printRow();
    
$table->endTable(0);

$pdf->Ln(2);

$table = new easyTable($pdf, '{16,32,68,29,29,16}', 'font-size: 8;');           
    $table->easyCell("");
    $table->easyCell(utf8_decode("CODIGO CUENTA"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("CONCEPTO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("DEBITO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("CREDITO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell("");
    $table->printRow();      
$table->endTable(0);


$valorTotalCredito = array();

foreach($listarPagosComprobantesPorNumIdComprobante As $lpc){
    array_push($valorTotalCredito, $lpc['valor_servicio']);
}

$totalDatos = count($listarPagosComprobantesPorNumIdComprobante);

$listarAnticiposCarteraPorComprobante = $cartera->listarAnticiposCarteraPorComprobante($num_id_comprobante);

//print_r($listarAnticiposCarteraPorComprobante);

$table = new easyTable($pdf, '{16,32,68,29,29,16}', 'font-size: 8; ');
    if($totalDatos > 0){
        foreach($listarPagosComprobantesPorNumIdComprobante As $lpcpnic){

            $listarCobrosPropietario = $conceptoCobro->listarPorIdCobrosPropietario($lpcpnic['id_cobro_propietario']);
            $listarConceptoPorId = $conceptoCobro->listarPorId($listarCobrosPropietario[0]['id_concepto']);
            $listarVehiculo = $vehiculo->listarPorId($listarCobrosPropietario[0]['id_vehiculo']);
            $listarPropietario = $usuario->listarUsuarioPorId($listarVehiculo[0]['id_propietario']);
            $listarBancosId = $conceptoCobro->listarBancosId($lpcpnic['banco_consignacion']);
            
            $table->easyCell("");
            $table->easyCell(utf8_decode($listarConceptoPorId[0]['cuenta_puc']), 'border: R,L; align:C;');
            $fechaPagoServicio = explode("-", $listarCobrosPropietario[0]['fecha_cobro']);
            $mes = $fechaPagoServicio[1];
            $anio = $fechaPagoServicio[0];
            $table->easyCell(utf8_decode("PAGO " . $listarConceptoPorId[0]['detalle_concepto'] . " - " . strtoupper(mes($mes)) . " DEL " . $anio), 'border: R; align:C;');
            $table->easyCell(utf8_decode(" - "), 'border: R; align:C;');
            $table->easyCell(utf8_decode("$ " . number_format($lpcpnic['valor_servicio'])), 'border: R; align:C;');
            $table->easyCell(""); 
        
            $table->printRow();
           
        }
        
        
        if($lpcpnic['valor_pagado'] != array_sum($valorTotalCredito)){
            
            $listarConceptoPorIdAnticipo = $conceptoCobro->listarPorId($listarAnticiposCarteraPorComprobante[0]['id_concepto']);
            
            $table->easyCell("");
            $table->easyCell(utf8_decode($listarConceptoPorIdAnticipo[0]['cuenta_puc']), 'border: R,L; align:C;');
            $fechaAnticipo = explode("-", $listarAnticiposCarteraPorComprobante[0]['fecha_inicial_valido']);
            $mes = $fechaAnticipo[1];
            $anio = $fechaAnticipo[0];
            
            $table->easyCell(utf8_decode("PAGO ANTICIPO " . $listarConceptoPorIdAnticipo[0]['detalle_concepto']. " - " . strtoupper(mes($mes)) . " DEL " . $anio), 'border: R; align:C;');
            $table->easyCell(utf8_decode(" - "), 'border: R; align:C;');
            $table->easyCell(utf8_decode("$ " . number_format($listarAnticiposCarteraPorComprobante[0]['valor_anticipo'])), 'border: R; align:C;');
            $table->easyCell(""); 
            
            $table->printRow();
        }
        
        
        $table->easyCell("");
            $table->easyCell(utf8_decode($listarBancosId[0]['cuenta_puc']), 'border: R,L; align:C;');
            $table->easyCell(utf8_decode("PAGO " . $listarBancosId[0]['descripcion']), 'border: R; align:C;');
            $table->easyCell(utf8_decode("$ " . number_format($lpcpnic['valor_pagado'])), 'border: R; align:C;');
            $table->easyCell(utf8_decode(" - "), 'border: R; align:C;');
            $table->easyCell(""); 
            
            $table->printRow();
        $table->endTable(0);

        $pdf->Cell(16, 7, "", 0, 0,'J');
        $pdf->Cell(32, 7, "", 'R,L,B', 0,'C');
        $pdf->Cell(68, 7, "", 'R,B', 0,'C');
        $pdf->Cell(29,7, "", 'R,B', 0,'C');
        $pdf->Cell(29, 7, "", 'R,B', 0,'C');
        $pdf->Cell(16, 7, "", 0, 1,'J');
        
    
    }
	
$pdf->Ln(1);

$pdf->SetFont('Arial','B',8.1);
$table = new easyTable($pdf, '{16,64,36,29,29,16}', 'font-size: 8; ');

    $table->easyCell("");
    $table->easyCell(utf8_decode("VALOR EN LETRAS"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B";');
    $table->easyCell(utf8_decode("TOTAL DEL DOCUMENTO"), 'bgcolor: #274054; font-color: #FFF; border: L,R,B,T; align:C; font-style:"B"; ');
    $table->easyCell(utf8_decode("$ " . number_format($lpcpnic['valor_pagado'])), 'border: R,B,T; align:C;');
    $table->easyCell(utf8_decode("$ " . number_format(array_sum($valorTotalCredito) + $listarAnticiposCarteraPorComprobante[0]['valor_anticipo'])), 'border: R,B,T; align:C;');
    $table->easyCell("");

    $table->printRow();

$table->endTable(0);

$pdf->SetFont('Arial','',7);
$table = new easyTable($pdf, '{16,64,94,16}', 'font-size: 7; ');
    
    $table->easyCell("", 0, 0,'J');
    $table->easyCell(utf8_decode(strtoupper(convertir($lpcpnic['valor_pagado'])) . " PESOS M/CTE"), 'border: R,B,T,L; align:C;');
    $table->easyCell(utf8_decode("FIRMA Y SELLO DEL BENEFICIARIO"), 'border: R,T; align:C;');
    $table->easyCell("", 0, 1,'J');

    $table->printRow();

$table->endTable(0);

$pdf->SetFont('Arial','',7);

$pdf->Cell(16, 5, "", 0, 0,'J');
$pdf->Cell(64, 5, "REVISADO POR", 'R,L', 0,'C');
$pdf->Cell(94, 5, "", 'R,L', 0,'C');
$pdf->Cell(16, 5, "", 0, 1,'J');

$pdf->Cell(16, 5, "", 0, 0,'J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(64, 5, "CONTABILIDAD", 'R,L,B', 0,'C');
$pdf->SetFont('Arial','',7);
$pdf->Cell(94, 5, "", 'R,L', 0,'C');
$pdf->Cell(16, 5, "", 0, 1,'J');

$pdf->Cell(16, 5, "", 0, 0,'J');
$pdf->Cell(64, 5, "APROBADO POR", 'R,L', 0,'C');
$pdf->Cell(94, 5, "", 'R,B,L', 0,'C');
$pdf->Cell(16, 5, "", 0, 1,'J');

$pdf->Cell(16, 5, "", 0, 0,'J');
$pdf->SetFont('Arial','B',7);
$pdf->Cell(64, 5, "TESORERIA", 'R,L,B', 0,'C');
$pdf->Cell(94, 5, "CC/NIT", 'R,B,L', 0,'C');
$pdf->Cell(16, 5, "", 0, 1,'J');

// $pdf->Output("F", "../../Documentos/RecibosCaja/ . $nombreArchivo");
$pdf->Output();
	
?>