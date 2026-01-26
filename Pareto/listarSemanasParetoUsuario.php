<?php
session_start();
require('bd/datos.php');

$querys = new consultas;
$paretos = $querys->paretos_us_anio($_POST['id_usuario'], date('Y'));

$cant = count($paretos);

$html = '';
if ($cant > 0) {
	$html .= '<option value="">SELECCIONAR SEMANA</option>';
	foreach ($paretos as $p) {
		$html .= '<option value="' . $p['id'] .'"> Semana ' . $p['semana'] . " | " . $p['fecha_inicial'] . " - " . $p['fecha_final'] .'</option>';
	}
}

echo $html;

?>