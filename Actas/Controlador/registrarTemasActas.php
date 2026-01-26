<?php 
require_once '../Modelo/Agendas.php';

$agenda = new Agenda();

	$tema_acta = $_POST['tema'];
	$descripcion_acta = $_POST['descripcion'];
	$id_acta = $_POST['id_acta'];

for ($i=0; $i < count($tema_acta); $i++) { 

	$tema = $tema_acta[$i];
	$descripcion = $descripcion_acta[$i];

	$registrarAgenda = $agenda->registrarAgenda($id_acta, $tema, $descripcion);
}

 ?>