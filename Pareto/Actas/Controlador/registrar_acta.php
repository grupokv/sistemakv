<?php 
session_start();
require_once '../Modelo/Actas.php';


$titulo_reunion = $_POST['titulo_reunion'];
$fecha_acta = $_POST['fecha_acta'];
$hora_inicial_acta = date("H:i:s",strtotime($_POST['hora_inicial_acta']));
$hora_final_acta = date("H:i:s",strtotime($_POST['hora_final_acta']));
$id_responsable = $_SESSION['idus'];
$fecha_creacion = date('Y-m-d');
$hora_creacion = date('H:i:s');

$acta = new Acta();
$registrarActa = $acta->registrarActas($titulo_reunion, $fecha_acta, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_creacion, $hora_creacion);

 ?>