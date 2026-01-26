<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/General.php");

$id_ciudad = $_POST['id_ciudad'];
$id_departamento = $_POST['id_departamento'];
$id_departamento_act = $_POST['id_departamento_act'];
$id_pais = $_POST['id_pais'];
$id_pais_act = $_POST['id_pais_act'];
$nombre_ciudad = mb_strtoupper($_POST['nombre_ciudad']);
$nombre_ciudad_act = mb_strtoupper($_POST['nombre_ciudad_act']);

$ciudad = new Ciudad();

if (($nombre_ciudad != $nombre_ciudad_act)or($id_departamento != $id_departamento_act)or($id_pais != $id_pais_act)){
	$busqueda = $ciudad->buscarPorNombre($nombre_ciudad, $id_departamento, $id_pais);
	$cant = count($busqueda);

	if($cant > 0){

    echo "<script>
    alert('La ciudad ingresada ya se encuentra registrada en el sistema');
    window.location.href = '../Vista/ciudades.php';
    </script>";
    exit;

	}
}

$actualizar = $ciudad->actualizar($nombre_ciudad, $id_departamento, $id_pais, $id_ciudad);

$id_modulo = 30;
$id_registro = $id_ciudad;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($id_departamento != $id_departamento_act) {
	$columnas_modulo .=  'id_departamento | ';
	$valores_antiguos .= $id_departamento_act.' | ';
	$valores_nuevos .= $id_departamento.' | ';
}

if ($id_pais != $id_pais_act) {
	$columnas_modulo .=  'id_pais | ';
	$valores_antiguos .= $id_pais_act.' | ';
	$valores_nuevos .= $id_pais.' | ';
}

if ($nombre_ciudad != $nombre_ciudad_act) {
	$columnas_modulo .=  'ciudad | ';
	$valores_antiguos .= $nombre_ciudad_act.' | ';
	$valores_nuevos .= $nombre_ciudad.' | ';
}

if($columnas_modulo != ''){

$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/ciudades.php');
?>