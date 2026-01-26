<?php 


include ("Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");


date_default_timezone_set('America/Bogota');

$id_cliente = $_POST['id_cliente'];

$razon_social = mb_strtoupper($_POST['razon_social']);
$razon_social_act = mb_strtoupper($_POST['razon_social_act']);
$sigla = mb_strtoupper($_POST['sigla']);
$sigla_act = mb_strtoupper($_POST['sigla_act']);
$nit_cliente = $_POST['nit_cliente'];
$nit_cliente_act = $_POST['nit_cliente_act'];
$direccion = mb_strtoupper($_POST['direccion']);
$direccion_act = mb_strtoupper($_POST['direccion_act']);
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$correo_electronico_act = mb_strtoupper($_POST['correo_electronico_act']);
$telefono = $_POST['telefono'];
$telefono_act = $_POST['telefono_act'];
$id_pais = $_POST['id_pais'];
$id_pais_act = $_POST['id_pais_act'];
$id_departamento = $_POST['id_departamento'];
$id_departamento_act = $_POST['id_departamento_act'];
$id_ciudad = $_POST['id_ciudad'];
$id_ciudad_act = $_POST['id_ciudad_act'];
$tipo_cliente = $_POST['tipo_cliente'];
$tipo_cliente_act = $_POST['tipo_cliente_act'];

$nombre_rl = mb_strtoupper($_POST['nombre_rl']);
$nombre_rl_act = mb_strtoupper($_POST['nombre_rl_act']);
$id_pais_rl = $_POST['id_pais_rl'];
$id_departamento_rl = $_POST['id_departamento_rl'];
$id_ciudad_rl = $_POST['id_ciudad_rl'];
$id_ciudad_rl_act = $_POST['id_ciudad_rl_act'];
$doc_rl = $_POST['doc_rl'];
$doc_rl_act = $_POST['doc_rl_act'];
$fecha_doc_rl = $_POST['fecha_doc_rl'];
$fecha_doc_rl_act = $_POST['fecha_doc_rl_act'];
$id_pais_exp = $_POST['id_pais_exp'];
$id_departamento_exp = $_POST['id_departamento_exp'];
$id_ciudad_exp = $_POST['id_ciudad_exp'];
$id_ciudad_exp_act = $_POST['id_ciudad_exp_act'];


/*REGISTRAR CONTRATO*/
$cliente = new Cliente();
$registrarC = $cliente->actualizar($razon_social, $sigla, $nit_cliente, $direccion, $correo_electronico, $telefono, $nombre_rl, $id_ciudad_rl, $doc_rl, $fecha_doc_rl, $id_ciudad_exp, $id_ciudad, $id_departamento, $id_pais, $tipo_cliente, $id_cliente);



$id_modulo = 19;
$id_registro = $id_cliente;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($razon_social != $razon_social_act) {
	$columnas_modulo .= 'razon_social |';
	$valores_antiguos .= $razon_social_act;
	$valores_nuevos .= $razon_social;
}

if ($sigla != $sigla_act) {
	$columnas_modulo .= 'sigla |';
	$valores_antiguos .= $sigla_act;
	$valores_nuevos .= $sigla;
}

if ($nit_cliente != $nit_cliente_act) {
	$columnas_modulo .= 'nit_cliente |';
	$valores_antiguos .= $nit_cliente_act;
	$valores_nuevos .= $nit_cliente;
}

if ($direccion != $direccion_act) {
	$columnas_modulo .= 'direccionC |';
	$valores_antiguos .= $direccion_act;
	$valores_nuevos .= $direccion;
}

if ($correo_electronico != $correo_electronico_act) {
	$columnas_modulo .= 'correo_electronico |';
	$valores_antiguos .= $correo_electronico_act;
	$valores_nuevos .= $correo_electronico;
}

if ($telefono != $telefono_act) {
	$columnas_modulo .= 'telefonoC |';
	$valores_antiguos .= $telefono_act;
	$valores_nuevos .= $telefono;
}

if ($id_pais != $id_pais_act) {
	$columnas_modulo .= 'id_pais |';
	$valores_antiguos .= $id_pais_act;
	$valores_nuevos .= $id_pais;
}

if ($id_departamento != $id_departamento_act) {
	$columnas_modulo .= 'id_departamento |';
	$valores_antiguos .= $id_departamento_act;
	$valores_nuevos .= $id_departamento;
}

if ($id_ciudad != $id_ciudad_act) {
	$columnas_modulo .= 'id_ciudad |';
	$valores_antiguos .= $id_ciudad_act;
	$valores_nuevos .= $id_ciudad;
}

if ($tipo_cliente != $tipo_cliente_act) {
	$columnas_modulo .= 'id_segmento |';
	$valores_antiguos .= $tipo_cliente_act;
	$valores_nuevos .= $tipo_cliente;
}

if ($nombre_rl != $nombre_rl_act) {
	$columnas_modulo .= 'representante_legalC |';
	$valores_antiguos .= $nombre_rl_act;
	$valores_nuevos .= $nombre_rl;
}

if ($id_ciudad_rl != $id_ciudad_rl_act) {
	$columnas_modulo .= 'ciudad_residencia_rl |';
	$valores_antiguos .= $id_ciudad_rl_act;
	$valores_nuevos .= $id_ciudad_rl;
}

if ($doc_rl != $doc_rl_act) {
	$columnas_modulo .= 'numero_documentoC |';
	$valores_antiguos .= $doc_rl_act;
	$valores_nuevos .= $doc_rl;
}

if ($fecha_doc_rl != $fecha_doc_rl_act) {
	$columnas_modulo .= 'fecha_expedicionC |';
	$valores_antiguos .= $fecha_doc_rl_act;
	$valores_nuevos .= $fecha_doc_rl;
}

if ($id_ciudad_exp != $id_ciudad_exp_act) {
	$columnas_modulo .= 'lugar_expedicionC |';
	$valores_antiguos .= $id_ciudad_exp_act;
	$valores_nuevos .= $id_ciudad_exp;
}

if ($columnas_modulo != 0) {
		$bitacoraActualizarUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/clientes.php');

?>