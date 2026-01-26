<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Departamento.php");
require_once("../Modelo/General.php");

$id_departamento = $_POST['id_departamento'];
$id_pais = $_POST['id_pais'];
$id_pais_act = $_POST['id_pais_act'];
$nombre_departamento = mb_strtoupper($_POST['nombre_departamento']);
$nombre_departamento_act = mb_strtoupper($_POST['nombre_departamento_act']);

$departamento = new Departamento();

if (($nombre_departamento != $nombre_departamento_act)or($id_pais != $id_pais_act)){
	$busqueda = $departamento->buscarPorNombre($nombre_departamento, $id_pais);
	$cant = count($busqueda);

	if($cant > 0){

    echo "<script>
    alert('El departamento ingresado ya se encuentra registrado en el sistema');
    window.location.href = '../Vista/departamentos.php';
    </script>";
    exit;

	}
}

$actualizar = $departamento->actualizar($nombre_departamento, $id_pais, $id_departamento);

$id_modulo = 29;
$id_registro = $id_departamento;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($id_pais != $id_pais_act) {
	$columnas_modulo .=  'id_pais | ';
	$valores_antiguos .= $id_pais_act.' | ';
	$valores_nuevos .= $id_pais.' | ';
}

if ($nombre_departamento != $nombre_departamento_act) {
	$columnas_modulo .=  'departamento | ';
	$valores_antiguos .= $nombre_departamento_act.' | ';
	$valores_nuevos .= $nombre_departamento.' | ';
}

if($columnas_modulo != ''){

$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/departamentos.php');
?>