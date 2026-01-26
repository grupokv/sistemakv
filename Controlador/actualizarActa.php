<?php 
require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_acta = $_POST['id_acta'];
$cliente = $_POST['cliente'];
$empresa = $_POST['empresa'];
$nombre_acta = $_POST['nombre_acta'];
$fecha_reunion = $_POST['fecha_reunion'];
$hora_inicial_acta = $_POST['hora_inicial_acta'];
$hora_final_acta = $_POST['hora_final_acta'];
$id_responsable = $_POST['id_responsable'];
$fecha_hora_creacion = $_POST['fecha_hora_creacion'];

$actualizarActa = $acta->actualizarActa($id_acta, $cliente, $empresa, $nombre_acta, $fecha_reunion, $hora_inicial_acta, $hora_final_acta, $id_responsable, $fecha_hora_creacion);

if ($_POST['AsistPersonasE'] == 'S') {
	$usuario = $_POST['nombre_usuario'];
	$cant_usuExterno = count($usuario);

	for ($i=0; $i < $cant_usuExterno ; $i++) { 	
		$nombre_usuario_externo = strtr(strtoupper($_POST['nombre_usuario'][$i]), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		$numero_documento_externo = $_POST['numero_documento'][$i];
		$proveniente_de = strtr(strtoupper($_POST['cliente']), "àèìòùáéíóúçñäëïöü","ÀÈÌÒÙÁÉÍÓÚÇÑÄËÏÖÜ");
		$id_usuario_interno = 0;
		$id_acta = $id_acta;

		$registrarInvitadosExternosActa = $acta->registrarInvitadosActa($nombre_usuario_externo, $numero_documento_externo, $proveniente_de, $id_usuario_interno, $id_acta);
	}
}


$eliminarInivitadosInternos = $acta->eliminarInivitadosInternos($id_acta);
$cant_usuInterno = count($_POST['id_invitado']);

for ($i=0; $i < $cant_usuInterno ; $i++) { 

	$nombre_usuario_externo1 = '';
	$numero_documento_externo1 = '';
	$proveniente_de1 = '';
	$id_usuario_interno1 = $_POST['id_invitado'][$i];
	$id_acta1 = $id_acta;



	$registrarInvitadosInternosActa = $acta->registrarInvitadosActa($nombre_usuario_externo1, $numero_documento_externo1, $proveniente_de1, $id_usuario_interno1, $id_acta1);

}

echo ("<script LANGUAGE='JavaScript'>

    window.location.href='../Vista/ActualizarTemasActas.php?id_acta=".$id_acta."';
    </script>");




?>