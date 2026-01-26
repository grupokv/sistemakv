<?php 
require_once '../Modelo/Convenio.php';

$convenio = new Convenio();

$id_convenio = $_POST['id_convenio'];
$id_empresa = $_POST['id_empresa'];
$fecha_inicio_convenio = $_POST['fecha_inicio_convenio'];
$fecha_final_convenio = $_POST['fecha_final_convenio'];
$id_ciudad_convenio = $_POST['id_ciudad'];
$id_vehiculo = $_POST['id_vehiculo'];
$id_conductor = $_POST['id_conductor'];
$id_contrato = $_POST['id_contrato'];
$objeto = $_POST['objeto_contrato_conv'];
$id_cliente = $_POST['id_cliente'];
$fecha_creacion_convenio = $_POST['fecha_creacion_convenio'];
$hora_creacion_convenio = $_POST['hora_creacion_convenio'];
$id_responsable = $_POST['id_responsable'];

$actualizarConvenios = $convenio->actualizar($id_convenio, $id_empresa, $fecha_inicio_convenio, $fecha_final_convenio, $id_ciudad_convenio, $id_vehiculo, $id_conductor, $id_contrato, $objeto, $id_cliente, $fecha_creacion_convenio, $hora_creacion_convenio, $id_responsable);

header('Location: ../Vista/convenios.php');

 ?>