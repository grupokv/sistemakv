<?php 

require_once '../Modelo/Pre-operacionales.php';

$preoperacionales = new PreOperacionales();

$id = $_POST['id_preoperacional'];

/*puertas*/
if ($_POST['tapas'] == '') {
	$tapas = 'NC';
}else{
	$tapas = $_POST['tapas'];
}

/*espejos_retrovisores*/
if ($_POST['niveles_aceite_motor'] == '') {
	$niveles_aceite_motor = 'NC';
}else{
	$niveles_aceite_motor = $_POST['niveles_aceite_motor'];
}

/*ventanas*/
if ($_POST['radiador_ventilador_correas'] == '') {
	$radiador_ventilador_correas = 'NC';
}else{
	$radiador_ventilador_correas = $_POST['radiador_ventilador_correas'];
}

/*PUERTAS*/
if ($_POST['mangueras'] == '') {
	$mangueras = 'NC';
}else{
	$mangueras = $_POST['mangueras'];
}

if ($_POST['transmision'] == '') {
	$transmision = 'NC';
}else{
	$transmision = $_POST['transmision'];
}

if ($_POST['filtro_aire'] == '') {
	$filtro_aire = 'NC';
}else{
	$filtro_aire = $_POST['filtro_aire'];
}

if ($_POST['fugas_motor'] == '') {
	$fugas_motor = 'NC';
}else{
	$fugas_motor = $_POST['fugas_motor'];
}

if ($_POST['bomba_freno_clutch'] == '') {
	$bomba_freno_clutch = 'NC';
}else{
	$bomba_freno_clutch = $_POST['bomba_freno_clutch'];
}

if ($_POST['bateria_bornes_soporte'] == '') {
	$bateria_bornes_soporte = 'NC';
}else{
	$bateria_bornes_soporte = $_POST['bateria_bornes_soporte'];
}

if ($_POST['direccion_nivel_aceite_hidraulico'] == '') {
	$direccion_nivel_aceite_hidraulico = 'NC';
}else{
	$direccion_nivel_aceite_hidraulico = $_POST['direccion_nivel_aceite_hidraulico'];
}

if ($_POST['depositivo_lavabrisas'] == '') {
	$depositivo_lavabrisas = 'NC';
}else{
	$depositivo_lavabrisas = $_POST['depositivo_lavabrisas'];
}

if ($_POST['conexiones_electricas'] == '') {
	$conexiones_electricas = 'NC';
}else{
	$conexiones_electricas = $_POST['conexiones_electricas'];
}

$actualizar = $preoperacionales->actualizarCompartimientoMotor($id, $tapas, $niveles_aceite_motor, $radiador_ventilador_correas, $mangueras, $transmision, $filtro_aire, $fugas_motor, $bomba_freno_clutch, $bateria_bornes_soporte, $direccion_nivel_aceite_hidraulico, $depositivo_lavabrisas, $conexiones_electricas);

header('Location: ../Vista/preoperacional_InteriorCabina.php?id=' . $id);

?>