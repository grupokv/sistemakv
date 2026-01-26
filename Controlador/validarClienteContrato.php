<?php  

include("Sesion/autenticar.php");
require_once '../Modelo/Contrato.php';

$id_contrato = $_POST['id_contrato'];

$contrato = new Contrato();
$listarContratoId = $contrato->listarId($id_contrato);

echo $listarContratoId[0]['id_cliente'];

?>