<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_ciudad']);
$id_pais = $_POST['id_pais'];
$id_departamento = $_POST['id_departamento'];

$ciudad = new Ciudad();

$busqueda = $ciudad->buscarPorNombre($detalle,$id_departamento,$id_pais);
$cant = count($busqueda);

if($cant > 0){

    echo "<script>
    alert('La ciudad ingresada ya se encuentra registrada en el sistema');
    window.location.href = '../Vista/ciudades.php';
    </script>";
    exit;

}

$registrar = $ciudad->registrar($detalle,$id_departamento,$id_pais);

$id_modulo = 30;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_ciudad | id_departamento | id_pais | ciudad';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $id_departamento . ' | ' . $id_pais . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/ciudades.php');

 ?>