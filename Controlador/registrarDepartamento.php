<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/Departamento.php");
require_once("../Modelo/General.php");

$detalle = mb_strtoupper($_POST['nombre_departamento']);
$id_pais = $_POST['id_pais'];

$departamento = new Departamento();

$busqueda = $departamento->buscarPorNombre($detalle,$id_pais);
$cant = count($busqueda);

if($cant > 0){

    echo "<script>
    alert('El departamento ingresado ya se encuentra registrado en el sistema');
    window.location.href = '../Vista/departamentos.php';
    </script>";
    exit;

}

$registrar = $departamento->registrar($detalle,$id_pais);

$id_modulo = 29;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_departamento | id_pais | nombre_departamento';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $id_pais . ' | ' . $detalle;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/departamentos.php');

 ?>