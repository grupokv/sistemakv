<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/ProveedorMantenimiento.php");
require_once("../Modelo/General.php");


/*empresa*/
$nombre_empresa = mb_strtoupper($_POST['nombre_empresa']);
$nit_empresa = $_POST['nit_empresa'];
$direccion = mb_strtoupper($_POST['direccion']);
$telefono = $_POST['telefono'];
$email = $_POST['email_empresa'];


$prov = new ProveedorMantenimiento();
$registrar = $prov->registrar($nombre_empresa, $nit_empresa, $direccion, $telefono, $email);

$id_modulo = 47;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_empresa | nombre_empresa | nit_empresa | direccion | telefono | email | estado  ';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $nombre_empresa . ' | ' . $nit_empresa . ' | ' . $direccion . ' | ' . $telefono . ' | ' . 
					$email . ' | ' . 'A';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroEmpresa = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/proveedores_mantenimiento.php');

 ?>