<?php 

require_once '../Modelo/Actas.php';

$acta = new Acta();

$id_acta = $_POST['id_acta'];
$invitados = $_POST['id_invitado'];


	for ($i=0; $i < count($_POST['id_invitado']) ; $i++) { 
		$id_invitado = $invitados[$i];
        $registrarInvitados = $acta->registrarInvitadosActas($id_acta, $id_invitado);
    }

 ?>