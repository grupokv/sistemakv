<?php
include("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Fuec.php");

$empresa = $_POST["empresa"];
$cliente = $_POST["cliente"];
$contrato = $_POST["contrato"];
$vehiculo = $_POST["vehiculo"];
$origen = $_POST["origen"];
$destino = $_POST["destino"];
$tipo_extracto = $_POST["tipo_extracto"];
$extracto_con = $_POST["extracto_con"];
$nombre_responsable = $_POST["nombre_responsable"];
$num_responsable = $_POST["num_responsable"];
$dir_responsable = $_POST["dir_responsable"];
$tel_responsable = $_POST["tel_responsable"];

$usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');

$fuec = new Fuec();
$id = $fuec->RegistrarPreliminar($origen,$destino,$tipo_extracto,$extracto_con,$vehiculo,$contrato,$nombre_responsable,$num_responsable,$dir_responsable,$tel_responsable,$usuario,$fecha);

echo $id;
?>
