<?php 

require_once '../Modelo/Pre-operacionales.php';

$preoperacionales = new PreOperacionales();

$id_preoperacional = $_POST['id_preoperacional'];

/*puertas*/
if ($_POST['puertas'] == '') {
	$puertas = 'NC';
}else{
	$puertas = $_POST['puertas'];
}

/*espejos_retrovisores*/
if ($_POST['espejos_retrovisores'] == '') {
	$espejos_retrovisores = 'NC';
}else{
	$espejos_retrovisores = $_POST['espejos_retrovisores'];
}

/*ventanas*/
if ($_POST['ventanas'] == '') {
	$ventanas = 'NC';
}else{
	$ventanas = $_POST['ventanas'];
}

/*PUERTAS*/
if ($_POST['vidrio_frontal'] == '') {
	$vidrio_frontal = 'NC';
}else{
	$vidrio_frontal = $_POST['vidrio_frontal'];
}

if ($_POST['llantas_rines'] == '') {
	$llantas_rines = 'NC';
}else{
	$llantas_rines = $_POST['llantas_rines'];
}

if ($_POST['llanta_repuesto'] == '') {
	$llanta_repuesto = 'NC';
}else{
	$llanta_repuesto = $_POST['llanta_repuesto'];
}

if ($_POST['luces_delanteras'] == '') {
	$luces_delanteras = 'NC';
}else{
	$luces_delanteras = $_POST['luces_delanteras'];
}

if ($_POST['luces_freno'] == '') {
	$luces_freno = 'NC';
}else{
	$luces_freno = $_POST['luces_freno'];
}

if ($_POST['luces_reserva'] == '') {
	$luces_reserva = 'NC';
}else{
	$luces_reserva = $_POST['luces_reserva'];
}

if ($_POST['luces_parqueo_direccionales'] == '') {
	$luces_parqueo_direccionales = 'NC';
}else{
	$luces_parqueo_direccionales = $_POST['luces_parqueo_direccionales'];
}

if ($_POST['sistema_suspension'] == '') {
	$sistema_suspension = 'NC';
}else{
	$sistema_suspension = $_POST['sistema_suspension'];
}

if ($_POST['sistema_frenos'] == '') {
	$sistema_frenos = 'NC';
}else{
	$sistema_frenos = $_POST['sistema_frenos'];
}

if ($_POST['sistema_direccion'] == '') {
	$sistema_direccion = 'NC';
}else{
	$sistema_direccion = $_POST['sistema_direccion'];
}

$actualizar = $preoperacionales->actualizarExterior($id_preoperacional, $puertas, $espejos_retrovisores, $ventanas, $vidrio_frontal, $llantas_rines, $llanta_repuesto, $luces_delanteras, $luces_freno, $luces_reserva, $luces_parqueo_direccionales, $sistema_suspension, $sistema_frenos, $sistema_direccion);

header('Location: ../Vista/preoperacional_compartimientoMotor.php?id=' . $id_preoperacional);

?>