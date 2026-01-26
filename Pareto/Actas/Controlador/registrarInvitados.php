<?php 
require_once '../Modelo/Actas.php';

session_start();

$acta = new Acta();
$id_acta = $_POST['id_acta'];
$invitados = $_POST['id_invitado'];
$id_creador_acta = $_SESSION['idus'];

$registrarCreadorActa = $acta->registrarInvitadosActas($id_acta, $id_creador_acta);

for ($i=0; $i < count($_POST['id_invitado']) ; $i++) { 
   $id_invitado = $invitados[$i];
   $registrarInvitados = $acta->registrarInvitadosActas($id_acta, $id_invitado);
}

header('Location: ../Vista/registrarTemas.php?id_acta=' . $id_acta);


 ?>