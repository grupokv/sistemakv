<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/General.php");

$razon_social = mb_strtoupper($_POST['razon_social']);
$sigla = mb_strtoupper($_POST['sigla']);
$nit_cliente = $_POST['nit_cliente'];
$direccion = mb_strtoupper($_POST['direccion']);
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$telefono = $_POST['telefono'];
$id_pais = $_POST['id_pais'];
$id_departamento = $_POST['id_departamento'];
$id_ciudad = $_POST['id_ciudad'];
$tipo_cliente = $_POST['tipo_cliente'];

$nombre_rl = mb_strtoupper($_POST['nombre_rl']);
$id_pais_rl = $_POST['id_pais_rl'];
$id_departamento_rl = $_POST['id_departamento_rl'];
$id_ciudad_rl = $_POST['id_ciudad_rl'];
$doc_rl = $_POST['doc_rl'];

if($_POST['fecha_doc_rl'] == ""){
    $fecha_doc_rl = "0000-00-00";
}else{
    $fecha_doc_rl = $_POST['fecha_doc_rl'];
}

$id_pais_exp = $_POST['id_pais_exp'];
$id_departamento_exp = $_POST['id_departamento_exp'];
$id_ciudad_exp = $_POST['id_ciudad_exp'];
$id_usuario_registro = $_SESSION['id_usuario'];

$cliente = new Cliente();
$registrarC = $cliente->registrar($razon_social, $sigla, $nit_cliente, $direccion, $correo_electronico, $telefono, $nombre_rl, $id_ciudad_rl, $doc_rl, $fecha_doc_rl, $id_ciudad_exp, $id_ciudad, $id_departamento, $id_pais, $tipo_cliente, $id_usuario_registro);

$id_modulo = 19;
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_cliente' . ' | ' . 'razon_social' . ' | ' . 'nit_cliente' . ' | ' . 'direccionC' . ' | ' . 
				   'telefonoC' . ' | ' . 'representante_legalC' . ' | ' . 'ciudad_residencia_rl' . ' | ' . 
				   'numero_documentoC' . ' | ' . 'fecha_expedicionC' . ' | ' . 'lugar_expedicionC' . ' | ' . 'id_ciudad' . ' | ' . 
				   'id_departamento' . ' | ' . 'id_pais' . ' | ' . 'id_segmento' . ' | ' . 'estado';
$valores_antiguos =  '';
$valores_nuevos = $registrarC . ' | '. $razon_social . ' | '  . $nit_cliente . ' | '. $direccion . ' | ' .  $telefono . ' | ' . 
                  $nombre_rl . ' | ' . $id_ciudad_rl . ' | ' . $doc_rl . ' | '. $fecha_doc_rl . ' | ' . $id_ciudad_exp . ' | ' .
                  $id_ciudad . ' | '. $id_departamento . ' | '. $id_pais . ' | '.  $tipo_cliente . ' | ' . 1;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroClientes = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

echo "<script>
	alert('Cliente creado correctamente');
	window.location = '../Vista/clientes.php';
	</script>";

?>