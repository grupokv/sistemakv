<?php
require('../Modelo/CotizadorKV.php');
require('../Resources/fpdf/fpdf.php');

$id = base64_decode($_GET['id']);

$cotizadorkv = new CotizadorKV();

$datos_cot = $cotizadorkv->listarCotizacionPorId($id);
$paginas = $cotizadorkv->buscarPaginas($datos_cot[0]['id_empresa']);
$datos_ase = $cotizadorkv->listar_usuario_id($datos_cot[0]['id_creador']);
$cant = count($paginas);

class PDF extends FPDF
{
	
}

$pdf=new PDF('L','mm',array(452,254));

for($i=0;$i<$cant;$i++){
    
    $pdf->AddPage();
    $ruta_imagen = "../Pages_Cotizador/".$datos_cot[0]['id_empresa']."/Diapositiva".($i+1).".JPG"; 
    
    $pdf->Image($ruta_imagen,'0','0','452','254','JPG');
    
    if($paginas[$i]['pag_valores'] == 'S'){
        $pdf->Ln(25);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('COTIZACIÓN No.'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,$datos_cot[0]['id_cotizacion'],0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('NOMBRE CLIENTE:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['nombre_cliente']),0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('NIT o No. DOCUMENTO:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,$datos_cot[0]['ident_cliente'],0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('DIRECCIÓN'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['dir_cliente']),0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('NOMBRE CONTACTO'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['contacto_cliente']),0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(210,8);
        $pdf->Cell(80,8,utf8_decode('CORREO ELECTRONICO'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['email_cliente']),0,1,'L');
        
        $pdf->Ln(15);
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('SERVICIO DE TRANSPORTE CON DESTINO A:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['destino']),0,1,'L');
        
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('VALOR TOTAL:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,'$ '.number_format(utf8_decode($datos_cot[0]['valor_estandar']),0,'.','.'),0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('DESCUENTO ESPECIAL:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,'$ '.number_format(utf8_decode($datos_cot[0]['valor_descuento']),0,'.','.').' ('.$datos_cot[0]['descuento'].'%)',0,1,'L');
        
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('VALOR FINAL:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,'$ '.number_format(utf8_decode($datos_cot[0]['valor_final']),0,'.','.'),0,1,'L');
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('CAPACIDAD VEHICULO:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        $pdf->Cell(145,8,utf8_decode($datos_cot[0]['cant_pax']).' Pasajeros',0,1,'L');
        
        $pdf->SetFont('Arial','B',18);
        $pdf->Cell(50,8);
        $pdf->Cell(120,8,utf8_decode('OBSERVACIONES:'),0,0,'R');
        $pdf->SetFont('Arial','',18);
        $pdf->Cell(2,8);
        
        $line_height = 4;
        $width = 220;
        $text = (utf8_decode($datos_cot[0]['observaciones']));    
        $height = (ceil(($pdf->GetStringWidth($text) / $width)) * $line_height);
        
        $pdf->Multicell($width,$height,$text,0,1);
        
    }
    
    if($i==($cant-1)){
        $pdf->Ln(163);
        $pdf->SetFont('Arial','B',20);
        $pdf->SetTextColor(255,255,255);
        $pdf->Cell(16,12);
        $pdf->Cell(60,12,'DATOS ASESOR',0,1,'L');
        $pdf->Cell(16,12);
        $pdf->Cell(45,12,'NOMBRE:',0,0,'L');
        $pdf->SetFont('Arial','',20);
        $pdf->Cell(120,12,$datos_ase[0]['nombre'],0,1,'L');
        $pdf->Ln(-2);
        $pdf->Cell(16,12);
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(45,12,'E-MAIL:',0,0,'L');
        $pdf->SetFont('Arial','',20);
        $pdf->Cell(120,12,$datos_ase[0]['correo'],0,1,'L');
        $pdf->Ln(-2);
        $pdf->Cell(16,12);
        $pdf->SetFont('Arial','B',20);
        $pdf->Cell(45,12,'TELEFONO:',0,0,'L');
        $pdf->SetFont('Arial','',20);
        $pdf->Cell(120,12,$datos_ase[0]['telefono'],0,1,'L');
    }
    
}

$pdf->Output();
?>