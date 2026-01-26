<?php
ob_start();
require_once ('../../Modelo/Actas.php');
require_once ('../../Recursos/fpdf-easytable-master/exfpdf.php');
require_once ('../../Recursos/fpdf-easytable-master/easyTable.php');
require_once ('../../Modelo/Usuarios.php');
require_once ('../../Modelo/Agendas.php');

$acta = new Acta();
$usuario = new Usuario();
$agenda = new Agenda();

$listarActaPorId = $acta->listarPorId($_GET['id_acta']);

$listarInvitadosPorActa = $acta->listarInvitadosPorActa($_GET['id_acta']);
$contarInvitados = count($listarInvitadosPorActa);

$listarAgendaPorIdActa = $agenda->listarAgendaPorIdActa($_GET['id_acta']);
$listarSituacionesPorIdActa = $agenda->listarSituacionesPorIdActa($_GET['id_acta']);

class PDF extends exFPDF
{
 
    function Header(){


	    $acta = new Acta();
		$listarActaPorId2 = $acta->listarPorId($_GET['id_acta']);

    	$this->SetFont('Arial','',14);

		$this->Cell(190, 8, '', 'T,L,R','1','C');
		$this->Cell(190, 7, utf8_decode(strtr(strtoupper($listarActaPorId2[0]['titulo_reunion']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ")), 'L,R','1','C');

    	$this->SetFont('Arial','',9);
		$this->Cell(190, 3, utf8_decode(" ACTA N° " .strtoupper($listarActaPorId2[0]['id_acta'])), 'L, R','1','C');
		$this->Cell(190, 7, '', 'L,R','1','C');
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

$pdf->SetFont('Arial','B',7);
$pdf->Cell(63, 4, utf8_decode('REALIZADA EL'), 'T, L , R','0','C');
$pdf->Cell(64, 4, utf8_decode('INICIADA A LAS'), 'T, L , R','0','C');
$pdf->Cell(63, 4, utf8_decode('FINALIZADA A LAS'), 'T, L , R','1','C');

$pdf->SetFont('Arial','',8);
$pdf->Cell(63, 6, utf8_decode(strtoupper($listarActaPorId[0]['fecha_acta'])), 'B, L, R','0','C');
$pdf->Cell(64, 6, utf8_decode(strtoupper($listarActaPorId[0]['hora_inicial_acta'])), 'B, L, R','0','C');
$pdf->Cell(63, 6, utf8_decode(strtoupper($listarActaPorId[0]['hora_final_acta'])), 'B, L, R','1','C');


$pdf->SetFont('Arial','B',8);
$pdf->Cell(190, 7, utf8_decode('ASISTENTES'), 1,'1','C');

$pdf->SetFont('Arial','',6);

foreach ($listarInvitadosPorActa as $lia) {
	$listarUsuariosPorId = $usuario->listarUsuariosPorId($lia['id_invitado']);
	foreach ($listarUsuariosPorId as $lupi) {
		$listarCargoPorUsuario = $usuario->listarCargoPorUsuario($lupi['id_cargo']);
		$pdf->Cell(10, 5, "", 'L','0','C');
		$pdf->Cell(180, 5, $listarCargoPorUsuario[0]['nombre'] . ':  ' . $lupi['nombre'] , 'R','1','F');
	}
}

$pdf->SetFont('Arial','B',7);
$pdf->Cell(95, 4, "AGENDAS", 1,'0','C');
$pdf->Cell(95, 4, "LISTA DE TEMAS A TRATAR" , 1,'1','C');

$pdf->SetFont('Arial','', 6);

$table = new easyTable($pdf, '%{50,50}', 'border:1; paddingY:4;');

$cuenta = 1;
foreach ($listarAgendaPorIdActa as $laia) {
	
$table->easyCell($cuenta++ . ')'.  strtoupper($laia['tema']));
$table->easyCell(strtoupper($laia['descripcion']));
$table->printRow();

}

 $table->endTable(0);

$pdf->SetFont('Arial','B', 8);
$pdf->Cell(190, 7, "DESARROLLO", 1,'1','C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(57, 5, utf8_decode("SITUACIÓN A SOLUCIONAR"), 1,'0','C');
$pdf->Cell(53, 5, utf8_decode("ACTIVIDADES/SOLUCIÓN"), 1,'0','C');
$pdf->Cell(31, 5, utf8_decode("RESPONSABLE"), 1,'0','C');
$pdf->Cell(26, 5, utf8_decode("REPORTAR A"), 1,'0','C');
$pdf->Cell(23, 5, utf8_decode("FECHA LIMITE"), 1,'1','C');

$pdf->SetFont('Arial','', 6);
$table1 = new easyTable($pdf, '%{30,28,16,14,12}',  'border:1; paddingY:4;');


foreach ($listarSituacionesPorIdActa as $lspia) {

	$listarResponsable = $usuario->listarUsuariosPorId($lspia['id_responsable']);
	$listarReportar = $usuario->listarUsuariosPorId($lspia['id_reportado_a']);

$table1->easyCell(strtoupper($lspia['descripcion_situacion']));
$table1->easyCell(strtoupper($lspia['actividades_soluciones']));
$table1->easyCell(strtoupper($listarResponsable[0]['nombre']));
$table1->easyCell(strtoupper($listarReportar[0]['nombre']));
$table1->easyCell(strtoupper($lspia['fecha_limite']));
$table1->printRow();
}

$table1->endTable(0);
$pdf->SetFont('Arial','B', 6);
$pdf->Cell(95, 5, utf8_decode('FIRMA DEL GERENTE (CONVOCA REUNIÓN) '), 'B, L, R','0','C');
$pdf->Cell(95, 5, utf8_decode('FIRMA DE LA SECRETARIA (ASIGNADA) '), 'B, L, R','1','C');


$pdf->Cell(95, 25, "", 'T, L, R', '0', 'C');
$pdf->Cell(95, 25, "", 'T, L, R', '1', 'C');

$pdf->Cell(95, 6, utf8_decode('_____________________________________'), 'B, L, R','0','C');
$pdf->Cell(95, 6, utf8_decode('_____________________________________'), 'B, L, R','1','C');

$pdf->SetFont('Arial','B', 6);
$pdf->Cell(64, 5, utf8_decode("NOMBRES Y APELLIDOS DE LOS ASISTENTES"), 1,'0','C');
$pdf->Cell(63, 5, utf8_decode("FIRMA"), 1,'0','C');
$pdf->Cell(63, 5, utf8_decode("CARGO / EMPRESA"), 1,'1','C');

$pdf->SetFont('Arial','',6);

foreach ($listarInvitadosPorActa as $lia) {
	$listarUsuariosPorId = $usuario->listarUsuariosPorId($lia['id_invitado']);
	foreach ($listarUsuariosPorId as $lupi) {
		$listarCargoPorUsuario = $usuario->listarCargoPorUsuario($lupi['id_cargo']);
	
		$pdf->Cell(64, 12, $lupi['nombre'] , 1,'0','C');
		$pdf->Cell(63, 12, "" , 1,'0','C');
		$pdf->Cell(63, 12, $listarCargoPorUsuario[0]['nombre'] , 1,'1','C');
	}
}

$pdf->Output();

?>
