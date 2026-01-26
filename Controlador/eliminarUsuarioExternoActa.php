<?php 

require_once '../Modelo/Actas.php';

$id_acta = $_POST['id_acta'];
$id_invitado = $_POST['id_invitado'];

$acta = new Acta;

$eliminar = $acta->eliminarInivitadoExternos($id_acta, $id_invitado);



?>