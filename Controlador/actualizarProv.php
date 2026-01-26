<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/ProveedorMantenimiento.php");
require_once("../Modelo/General.php");

$id = $_POST['id'];
$nombre_empresa = mb_strtoupper($_POST['nombre_empresa']);
$nombre_empresa_act = mb_strtoupper($_POST['nombre_empresa_act']);
$nit_empresa = $_POST['nit_empresa'];
$nit_empresa_act = $_POST['nit_empresa_act'];
$direccion = mb_strtoupper($_POST['direccion']);
$direccion_act = mb_strtoupper($_POST['direccion_act']);
$telefono = $_POST['telefono'];
$telefono_act = $_POST['telefono_act'];
$email = $_POST['email'];
$email_act = $_POST['email_act'];
$estado = $_POST['estado'];

$proveedor = new ProveedorMantenimiento();
$actualizarEmp = $proveedor->actualizar($id, $nombre_empresa, $nit_empresa, $direccion, $telefono, $email, $estado);

$id_modulo = 47;
$id_registro = $id;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');



/*Nombre Empresa*/
	if ($nombre_empresa != $nombre_empresa_act) {
		$columnas_modulo .= 'nombre_empresa |';
		$valores_antiguos .= $nombre_empresa_act . ' | ';
		$valores_nuevos .= $nombre_empresa . ' | ';
	}

/*Nit Empresa*/
	if ($nit_empresa != $nit_empresa_act) {
		$columnas_modulo .= 'nit_empresa |';
		$valores_antiguos .= $nit_empresa_act . ' | ';
		$valores_nuevos .= $nit_empresa . ' | ';
	}

/*Direccion*/
	if ($direccion != $direccion_act) {
		$columnas_modulo .= 'direccion |';
		$valores_antiguos .= $direccion_act . ' | ';
		$valores_nuevos .= $direccion . ' | ';
	}

/*Telefono*/
	if ($telefono != $telefono_act) {
		$columnas_modulo .= 'telefono |';
		$valores_antiguos .= $telefono_act . ' | ';
		$valores_nuevos .= $telefono . ' | ';
	}

/*Pais*/
	if ($email != $email_act) {
		$columnas_modulo .= 'email |';
		$valores_antiguos .= $email_act . ' | ';
		$valores_nuevos .= $email . ' | ';
	}




	if ($columnas_modulo != '') {
			$bitacoraRegistroEmpresa = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
														  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
														  $hora_actividad);
	}
header('Location: ../Vista/proveedores_mantenimiento.php');
 ?>

