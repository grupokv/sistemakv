<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Pais.php");
require_once("../Modelo/General.php");

$id_pais = $_POST['id_pais'];
$nombre_pais = mb_strtoupper(($_POST['nombre_pais']);
$nombre_pais_act = mb_strtoupper(($_POST['nombre_pais_act']);

$pais = new Pais();

if ($nombre_pais != $nombre_pais_act) {
	$busqueda = $pais->buscarPorNombre($nombre_pais);
	$cant = count($busqueda);

	if($cant > 0){

    echo "<script>
    alert('El pais ingresado ya se encuentra registrado en el sistema');
    window.location.href = '../Vista/paises.php';
    </script>";
    exit;

	}
}

$actualizar = $pais->actualizar($nombre_pais, $id_pais);

$id_modulo = 28;
$id_registro = $id_pais;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

if ($nombre_pais != $nombre_pais_act) {
	$columnas_modulo .=  'id_pais | pais';
	$valores_antiguos .= $id_pais.' | '.$nombre_pais_act;
	$valores_nuevos .= $id_pais.' | '.$nombre_pais;
}

if($columnas_modulo != ''){

$bitacoraActualizarSegmento = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);
}

header('Location: ../Vista/paises.php');
?>