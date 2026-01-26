<?php 


include ("Sesion/autenticar.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/General.php");


date_default_timezone_set('America/Bogota');

$id_cliente = $_POST['id_cliente'];

$razon_social = mb_strtoupper($_POST['razon_social']);
$razon_social_act = mb_strtoupper($_POST['razon_social_act']);
$nit_cliente = $_POST['nit_cliente'];
$nit_cliente_act = $_POST['nit_cliente_act'];
$direccion = mb_strtoupper($_POST['direccion']);
$direccion_act = mb_strtoupper($_POST['direccion_act']);
$telefono = $_POST['telefono'];
$telefono_act = $_POST['telefono_act'];
$id_pais = $_POST['id_pais'];
$id_pais_act = $_POST['id_pais_act'];
$id_departamento = $_POST['id_departamento'];
$id_departamento_act = $_POST['id_departamento_act'];
$id_ciudad = $_POST['id_ciudad'];
$id_ciudad_act = $_POST['id_ciudad_act'];

$nombre_rl = mb_strtoupper($_POST['nombre_rl']);
$nombre_rl_act = mb_strtoupper($_POST['nombre_rl_act']);
$id_pais_rl = $_POST['id_pais_rl'];
$id_departamento_rl = $_POST['id_departamento_rl'];

if ($_POST['id_ciudad_rl'] == "") {
	$id_ciudad_rl = 0;
}else{
	$id_ciudad_rl = $_POST['id_ciudad_rl'];
}

$id_ciudad_rl_act = $_POST['id_ciudad_rl_act'];
$doc_rl = $_POST['doc_rl'];
$doc_rl_act = $_POST['doc_rl_act'];

if ($_POST['fecha_doc_rl'] == "") {
	$fecha_doc_rl = '0000-00-00';
}else{

	$fecha_doc_rl = $_POST['fecha_doc_rl'];
}
$fecha_doc_rl_act = $_POST['fecha_doc_rl_act'];
$id_pais_exp = $_POST['id_pais_exp'];
$id_departamento_exp = $_POST['id_departamento_exp'];

if ($_POST['id_ciudad_exp'] == "") {
	$id_ciudad_exp = 0;
}else{
	$id_ciudad_exp = $_POST['id_ciudad_exp'];
}

$id_ciudad_exp_act = $_POST['id_ciudad_exp_act'];


/*REGISTRAR CONTRATO*/
$cliente = new Cliente_Convenio();

$registrarC = $cliente->actualizar($razon_social, $nit_cliente, $direccion, $telefono, $nombre_rl, $id_ciudad_rl, $doc_rl, $fecha_doc_rl, $id_ciudad_exp, $id_ciudad, $id_departamento, $id_pais, $id_cliente);



$id_modulo = 39;
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
		$bitacoraActualizarUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
}

header('Location: ../Vista/clientes_convenios.php');

?>