<?php  
require_once '../Modelo/Actas.php';

date_default_timezone_set('America/Bogota');
session_start();
$acta = new Acta();


$cliente = strtr(strtoupper($_POST['cliente']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
$empresa = $_POST['empresa'];
$nombre_acta = strtr(strtoupper($_POST['nombre_acta']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
$fecha_reunion = $_POST['fecha_reunion'];
$hora_inicial_acta = $_POST['hora_inicial_acta'];
$hora_final_acta = $_POST['hora_final_acta'];
$id_responsable = $_SESSION['id_usuario'];
$fecha_hora_creacion = date('Y-m-d H:i:s');


$registrarActa = $acta->registrarActa($cliente, $empresa, $nombre_acta, $fecha_reunion, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_hora_creacion);


$usuario = $_POST['nombre_usuario'];
$documento = $_POST['numero_documento'];

$cant_usuExterno = count($usuario);


for ($i=0; $i < $cant_usuExterno ; $i++) { 	
	$nombre_usuario_externo = strtr(strtoupper($_POST['nombre_usuario'][$i]), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
	$numero_documento_externo = $_POST['numero_documento'][$i];
	$proveniente_de = strtr(strtoupper($_POST['cliente']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
	$id_usuario_interno = 0;
	$id_acta = $registrarActa;

	$registrarInvitadosExternosActa = $acta->registrarInvitadosActa($nombre_usuario_externo, $numero_documento_externo, $proveniente_de, $id_usuario_interno, $id_acta);
}

$cant_usuInterno = count($_POST['id_invitado']);

for ($i=0; $i < $cant_usuInterno ; $i++) { 
	$nombre_usuario_externo1 = '';
	$numero_documento_externo1 = '';
	$proveniente_de1 = '';
	$id_usuario_interno1 = $_POST['id_invitado'][$i];
	$id_acta1 = $registrarActa;

	$registrarInvitadosInternosActa = $acta->registrarInvitadosActa($nombre_usuario_externo1, $numero_documento_externo1, $proveniente_de1, $id_usuario_interno1, $id_acta1);
}

header('Location: ../Vista/registrarActasTemas.php?id_acta=' . $registrarActa);

?>