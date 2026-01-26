<?php 

require_once '../Modelo/Pre-operacionales.php';

$preoperacionales = new PreOperacionales();

$id_preoperacional = $_POST['id_preoperacional'];

/*puertas*/
if ($_POST['tapas'] == '') {
	$tapas = 'NC';
}else{
	$tapas = $_POST['tapas'];
}

/*espejos_retrovisores*/
if ($_POST['plumillas_limpiavidrios'] == '') {
	$plumillas_limpiavidrios = 'NC';
}else{
	$plumillas_limpiavidrios = $_POST['plumillas_limpiavidrios'];
}

/*ventanas*/
if ($_POST['indicadores_luces_tablero'] == '') {
	$indicadores_luces_tablero = 'NC';
}else{
	$indicadores_luces_tablero = $_POST['indicadores_luces_tablero'];
}

/*PUERTAS*/
if ($_POST['indicador_velocidad'] == '') {
	$indicador_velocidad = 'NC';
}else{
	$indicador_velocidad = $_POST['indicador_velocidad'];
}

if ($_POST['indicador_combustible'] == '') {
	$indicador_combustible = 'NC';
}else{
	$indicador_combustible = $_POST['indicador_combustible'];
}

if ($_POST['indicador_aceite_motor'] == '') {
	$indicador_aceite_motor = 'NC';
}else{
	$indicador_aceite_motor = $_POST['indicador_aceite_motor'];
}

if ($_POST['pito'] == '') {
	$pito = 'NC';
}else{
	$pito = $_POST['pito'];
}

if ($_POST['freno_emergencia'] == '') {
	$freno_emergencia = 'NC';
}else{
	$freno_emergencia = $_POST['freno_emergencia'];
}

if ($_POST['pito_reserva'] == '') {
	$pito_reserva = 'NC';
}else{
	$pito_reserva = $_POST['pito_reserva'];
}

if ($_POST['botiquin'] == '') {
	$botiquin = 'NC';
}else{
	$botiquin = $_POST['botiquin'];
}

if ($_POST['equipo_carretera'] == '') {
	$equipo_carretera = 'NC';
}else{
	$equipo_carretera = $_POST['equipo_carretera'];
}

if ($_POST['kilometraje'] == '') {
	$kilometraje = '0';
}else{
	$kilometraje = $_POST['kilometraje'];
}

$actualizar = $preoperacionales->actualizarInteriorCabina($id_preoperacional, $plumillas_limpiavidrios, $indicadores_luces_tablero, $indicador_velocidad, $indicador_combustible, $indicador_aceite_motor, $pito, $freno_emergencia, $pito_reserva, $botiquin, $equipo_carretera, $kilometraje);

header('Location: ../Vista/preoperacional_desinfeccion.php?id=' . $id_preoperacional);
?>