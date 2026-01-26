<?php 

ob_start();
require('../../Resources/fuec/fpdf.php');
require('../../Resources/fpdf-easytable-master/exfpdf.php');
require('../../Resources/fpdf-easytable-master/easyTable.php');
require_once '../../Modelo/Actas.php';
require_once '../../Modelo/Usuario.php';
require_once '../../Modelo/Cargo.php';

$id_acta = $_GET['id_acta'];

$acta = new Acta();
$usuario = new Usuario();
$cargo = new Cargo();

$listarActa = $acta->listarActasId($id_acta);
$listarInvitadosActaId = $acta->listarInvitadosActaId($id_acta);
$listarTemaActaId = $acta->listarTemaActaId($id_acta);
$listarSituacionActaId = $acta->listarSituacionActaId($id_acta);


class PDF extends exFPDF{
	
	function Header(){

		$id_acta = $_GET['id_acta'];
		$acta = new Acta();
		$listarActa = $acta->listarActasId($id_acta);

		$this->SetFont('Arial','B', 9);
		if($listarActa[0]['empresa'] == 1){
			$this->Cell(50, 20, $this->Image('../../Resources/fuec/img/logo-ort.png', $this->GetX()+7, $this->GetY()+1, 36), 'L,T,R', '0', 'C');
		}else if($listarActa[0]['empresa'] == 2){
			$this->Cell(50, 20, $this->Image('../../Resources/fuec/img/logo-lp.png', $this->GetX()+7, $this->GetY()+1, 36), 'L,T,R', '0', 'C');
		}else{
			$this->Cell(50, 20, $this->Image('../../Resources/img/kingvision_transparente.png', $this->GetX()+7, $this->GetY()+1, 40), 'L,T,R', '0', 'C');
		}
		
		
		$this->Cell(90, 9, utf8_decode('DIRECCIONAMIENTO ESTRATÉGICO'), 'T,R,B','0','C');
		$this->SetFont('Arial','BI', 8);
		$this->Cell(50, 9, utf8_decode('Codigo: DE-F-03'), 'T,R,B','1','C');
		
		$this->Cell(50, 8, "", 'L,R', '0', 'C');
		$this->SetFont('Arial','B', 8.5);
		$this->Cell(90, 8, utf8_decode("ACTA DE REUNIÓN"), 'R', '0', 'C');	
		$this->SetFont('Arial','BI', 8);
		$this->Cell(50, 8, utf8_decode("Versión: 6"), 'L,R,B', '1', 'C');
		
		$this->Cell(50, 8, "", 'L,R,B', '0', 'C');
		$this->Cell(90, 8, "", 'B', '0', 'C');
		$this->SetFont('Arial','BI', 8);
		$this->Cell(50, 8, "Vigencia: 28/11/2022", 'L,R,B', '1', 'C');

		$this->ln(5);
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
	$pdf->Cell(190, 1, "", 0, 1, 'C');

	$pdf->SetFont('Arial','', 7);
	$table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("DATOS DEL ACTA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();    
	$table->endTable(0);

	$pdf->Ln(1);

	$table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
		$table->easyCell(strtr(strtoupper(utf8_decode($listarActa[0]['nombre_acta'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 'border: L,T,B; align:C; valign:C; ');
		$table->printRow();    
	$table->endTable(0);

	$pdf->Ln(1);

	$table = new easyTable($pdf, '{62,1,127}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("FECHA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->easyCell("");
		$table->easyCell(utf8_decode("DURACIÓN"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();   
	$table->endTable(0);

	$pdf->Ln(1);

	$pdf->SetFont('Arial','',8);
	$pdf->Cell(62, 5, $listarActa[0]['fecha_reunion'], 'T,L,R,B', 0, 'C');
	$pdf->Cell(1, 5, "", '0', 0, 'C');
	$pdf->Cell(63, 5, "DESDE: " . date('g:i A', strtotime($listarActa[0]['hora_inicial_acta'])), 'T,L,R,B', 0, 'C');
	$pdf->Cell(1, 5, "", '0', 0, 'C');
	$pdf->Cell(63, 5, "HASTA: " . date('g:i A', strtotime($listarActa[0]['hora_final_acta'])), 'T,L,R,B', 1, 'C');
	
	$pdf->Ln(1);

	$pdf->SetFont('Arial','B',7);

	$table = new easyTable($pdf, '%{100}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("ASISTENTES"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();    
	$table->endTable(0);

	$pdf->SetFont('Arial','',7);
	$pdf->Cell(190, 1, "", 'L-R-T', 1, 'C');
	foreach ($listarInvitadosActaId as $liai) {
		
		if (($liai['nombre_usuario_externo'] != '') AND ($liai['id_usuario_interno'] == 0)) {
			$pdf->Cell(22, 4, "", 'L', 0, 'C');
			$pdf->Cell(168, 4, strtr(strtoupper(utf8_decode($liai['nombre_usuario_externo'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . '  -  ' . $liai['numero_documento_externo'], 'R', 1, 'J');
		}else{
			$listarUsuarios = $usuario->listarUsuarioPorId($liai['id_usuario_interno']);
			$pdf->Cell(22, 4, "", 'L', 0, 'C');
			$pdf->Cell(168, 4,  strtr(strtoupper(utf8_decode($listarUsuarios[0]['nombre'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ") . '  -  ' . $listarUsuarios[0]['usuario'], 'R', 1, 'J');
		}	
	
	}
	$pdf->Cell(190, 1, "", 'L-R-B', 1, 'C');
	
	$pdf->Ln(1);

	$table = new easyTable($pdf, '{95,95}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("TEMAS A TRATAR"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->easyCell(utf8_decode("DESARROLLO"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();    
	$table->endTable(0);
		
	$pdf->SetFont('Arial','',7);
		if (count($listarTemaActaId) > 0) {
			$table = new easyTable($pdf, '%{50,50}', 'font-size: 6.5; ');
				foreach ($listarTemaActaId as $ltai) {
					$table->easyCell(utf8_decode($ltai['nombre_tema']), 'border: B-L-R; align:C;');
					$table->easyCell(utf8_decode($ltai['descripcion_tema']), 'border: B-R; align:C;');
					$table->printRow();
				}
			$table->endTable(0);
		}else{

			$pdf->SetFont('Arial','B',7);
			$pdf->Cell(190, 4, "NO SE REGISTRO NINGUN TEMA", 'L-R-B', 1, 'C');
		}


	$pdf->Ln(1);

	
	$table = new easyTable($pdf, '{190}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("PLAN DE ACCIÓN"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();    
	$table->endTable(0);
		
	$pdf->Ln(1);

	if (count($listarSituacionActaId) > 0) {

		$pdf->SetFont('Arial','B',7);
		$table = new easyTable($pdf, '%{27,27,14,12,11,9}', 'font-size: 7; ');
			$table->easyCell(utf8_decode("SITUACIÓN"), 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->easyCell(utf8_decode("ACTIVIDAD"), 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->easyCell("RESPONSABLE(S)", 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->easyCell("REPORTAR A", 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->easyCell("FECHA LIMITE", 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->easyCell("PRIORIDAD", 'border: R; border-color:#a1a1a1; align:C; bgcolor: #274054; font-color: #FFF;');
			$table->printRow();
		$table->endTable(0);

			$pdf->Ln(1);

			$pdf->SetFont('Arial','',7);

			$table = new easyTable($pdf, '%{27,27,14,12,11,9}', 'font-size: 6.8; ');
				foreach ($listarSituacionActaId as $ltai) {
					$table->easyCell(strtr(strtoupper(utf8_decode($ltai['descripcion_situacion'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 'border: B-L-R-T; align:J;');
					$table->easyCell(strtr(strtoupper(utf8_decode($ltai['solucion_situacion'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 'border: T-B-R; align:J;');
					
					$responsables = explode(",", $ltai['id_responsable']);
					
					$nombres_resp = '';
					for ($i=0; $i < count($responsables); $i++) { 
						$listarResponsable = $usuario->listarUsuarioPorId($responsables[$i]);
						$listarCargoIdResponsable = $cargo->listarCargosPorId($listarResponsable[0]['id_cargo']);
						
						if($i == (count($responsables)-1)){
							$nombres_resp .= $listarCargoIdResponsable[0]['nombre_cargo'];
						}else{
							$nombres_resp .= $listarCargoIdResponsable[0]['nombre_cargo'].', ';
						}
						
						//echo $nombres_resp.'<br/>';
					}
                    
                    
					$table->easyCell(utf8_decode($nombres_resp),'border: T-B-R; align:C;');

					$listarReportarA = $usuario->listarUsuarioPorId($ltai['id_reportar_a']);
					//print_r($listarReportarA);
					$listarCargoIdReportar = $cargo->listarCargosPorId($listarReportarA[0]['id_cargo']);

					$table->easyCell(utf8_decode(strtoupper($listarCargoIdReportar[0]['nombre_cargo'])), 'border: T-B-R; align:C;');
					
					$table->easyCell(utf8_decode($ltai['fecha_limite']), 'border: T-B-R; align:C;');
					if ($ltai['prioridad'] == 1) {
						$table->easyCell("BAJA", 'border: T-B-R; align:C;');
					}else if($ltai['prioridad'] == 2){
						$table->easyCell("MEDIA", 'border: T-B-R; align:C;');
					}else{
						$table->easyCell("ALTA", 'border: T-B-R; align:C;');
					}
					$table->printRow();
				}

			$table->endTable(0);
	}else{

	        $pdf->SetFont('Arial','B',7);
			$pdf->Cell(190, 4, utf8_decode("NO SE REGISTRO NINGUNA SITUACIÓN Y SOLUCIÓN"), 'T-L-R-B', 1, 'C');
	}


	$pdf->SetFont('Arial','B',7);
	$pdf->Cell(190, 1, "", 'B', 1, 'C');
	
	$table = new easyTable($pdf, '{63,1,62,1,63}', 'font-size: 7; ');    
		$table->easyCell(utf8_decode("NOMBRE DE LOS ASISTENTES"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->easyCell("");
		$table->easyCell(utf8_decode("CARGO"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->easyCell("");
		$table->easyCell(utf8_decode("FIRMA"), 'bgcolor: #274054; font-color: #FFF; align:C; valign:M; font-style:"B"; ');
		$table->printRow();    
	$table->endTable(0);
		

	$pdf->SetFont('Arial','',7);

	$pdf->SetFont('Arial','',6.7);
	foreach ($listarInvitadosActaId as $liai) {
		
		if (($liai['nombre_usuario_externo'] != '') AND ($liai['id_usuario_interno'] == 0)) {
			$pdf->Cell(63, 11, strtr(strtoupper(utf8_decode($liai['nombre_usuario_externo'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 'B-L-R', 0, 'C');
			$pdf->Cell(1, 11, "", '0', 0, 'C');
			$pdf->Cell(62, 11, "USUARIO EXTERNO", 'L-B-R', 0, 'C');
			$pdf->Cell(1, 11, "", '0', 0, 'C');
			$pdf->Cell(63, 11, "", 'L-B-R', 1, 'C');
		}else{
			$listarUsuarios = $usuario->listarUsuarioPorId($liai['id_usuario_interno']);
			$pdf->Cell(63, 11,  strtr(strtoupper(utf8_decode($listarUsuarios[0]['nombre'])), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ"), 'B-R-L', 0, 'C');
			$listarCargoId = $cargo->listarCargosPorId($listarUsuarios[0]['id_cargo']);
			$pdf->Cell(1, 11, "", '0', 0, 'C');
			$pdf->Cell(62, 11, utf8_decode($listarCargoId[0]['nombre_cargo']), ',L-B-R', 0, 'C');
			$pdf->Cell(1, 11, "", '0', 0, 'C');
			$listarFirmaUsuario = $usuario->listarFirmasUsuarios($liai['id_usuario_interno']);
			
			if (count($listarFirmaUsuario) > 0) {
				$firma = "../../Resources/firmas" . '/' . $listarFirmaUsuario[0]['firma'];
				$pdf->Cell(63, 11, $pdf->Image($firma, $pdf->GetX()+20, $pdf->GetY()+1, 20), 'L-B-R', 1, 'C');
			}else{
				$pdf->Cell(63, 11, "", 'L,B,R', 1, 'C');
			}
		}	
	
	}

$listarUsuarioPorId = $usuario->listarUsuarioPorId($listarActa[0]['id_responsable']);
$listarCargoIdCreador = $cargo->listarCargosPorId($listarUsuarioPorId[0]['id_cargo']);

$pdf->SetFont('Helvetica','B',6);
$pdf->Cell(190, 5, utf8_decode("EMITIDO POR : " . $listarUsuarioPorId[0]['nombre'] . ' - ' . $listarCargoIdCreador[0]['nombre_cargo'] . ' | FECHA EMISIÓN: ' . $listarActa[0]['fecha_hora_creacion']), 0, 1,'R');

	


	$pdf->Output();

 ?>		}
