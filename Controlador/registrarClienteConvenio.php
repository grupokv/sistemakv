<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/General.php");

$razon_social = mb_strtoupper($_POST['razon_social']);
$nit_cliente = $_POST['nit_cliente'];
$direccion = mb_strtoupper($_POST['direccion']);
$telefono = $_POST['telefono'];
$id_pais = $_POST['id_pais'];
$id_departamento = $_POST['id_departamento'];
$id_ciudad = $_POST['id_ciudad'];

$nombre_rl = mb_strtoupper($_POST['nombre_rl']);
$id_pais_rl = $_POST['id_pais_rl'];
$id_departamento_rl = $_POST['id_departamento_rl'];
$id_ciudad_rl = $_POST['id_ciudad_rl'];
$doc_rl = $_POST['doc_rl'];
$fecha_doc_rl = $_POST['fecha_doc_rl'];
$id_pais_exp = $_POST['id_pais_exp'];
$id_departamento_exp = $_POST['id_departamento_exp'];
$id_ciudad_exp = $_POST['id_ciudad_exp'];


/*REGISTRAR CONTRATO*/
$cliente = new Cliente_Convenio();
$registrarC = $cliente->registrar($razon_social,$nit_cliente,$direccion,$telefono,$nombre_rl,$id_ciudad_rl,$doc_rl,$fecha_doc_rl,$id_ciudad_exp,$id_ciudad,$id_departamento,$id_pais,$id_cliente);
 

$id_modulo = 39;
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_cliente' . ' | ' . 'razon_social' . ' | ' . 'nit_cliente' . ' | ' . 'direccionC' . ' | ' . 
				   'telefonoC' . ' | ' . 'representante_legalC' . ' | ' . 'ciudad_residencia_rl' . ' | ' . 
				   'numero_documentoC' . ' | ' . 'fecha_expedicionC' . ' | ' . 'lugar_expedicionC' . ' | ' . 'id_ciudad' . ' | ' . 
				   'id_departamento' . ' | ' . 'id_pais' . ' | ' . 'estado';
$valores_antiguos =  '';
$valores_nuevos = $registrarC . ' | '. $razon_social . ' | '  . $nit_cliente . ' | '. $direccion . ' | ' .  $telefono . ' | ' . 
                  $nombre_rl . ' | ' . $id_ciudad_rl . ' | ' . $doc_rl . ' | '. $fecha_doc_rl . ' | ' . $id_ciudad_exp . ' | ' .
                  $id_ciudad . ' | '. $id_departamento . ' | '. $id_pais . ' | ' . 1;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroClientes = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header('Location: ../Vista/clientes_convenios.php');

?>