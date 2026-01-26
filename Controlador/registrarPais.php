<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Pais.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_pais']);

$pais = new Pais();

$busqueda = $pais->buscarPorNombre($detalle);
$cant = count($busqueda);

if($cant > 0){

    echo "<script>
    alert('El pais ingresado ya se encuentra registrado en el sistema');
    window.location.href = '../Vista/paises.php';
    </script>";
    exit;

}

$registrar = $pais->registrar($detalle);

$id_modulo = 28;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_pais | nombre_pais';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/paises.php');

 ?>