<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$id_usuario = $_POST['id_usuario'];
$rol = $_POST['rol'];
$tipo_usuario = $_POST['tipo_usuario'];
$id_cliente = $_POST['id_cliente'];

if(isset($_POST['valor_cliente'])){
    $valor_cliente = 1;
}else{
    $valor_cliente = 0;
}

$lectura_reportes = $_POST['lectura_reportes'];

$reportes = '';
for ($i=0; $i < count($lectura_reportes); $i++) { 
    if($i+1 == count($lectura_reportes)){
        $reportes .= $lectura_reportes[$i];
    }else{
        $reportes .= $lectura_reportes[$i] . ',';
    }
}


$clientes = '';
for ($i=0; $i < count($id_cliente); $i++) { 
    if($i+1 == count($id_cliente)){
        $clientes .= $id_cliente[$i];
    }else{
        $clientes .= $id_cliente[$i] . ',';
    }
}

$registro = $_POST['registro'];
$consulta = $_POST['consulta'];
$anulacion = $_POST['anulacion'];
$fecha_asignacion = date('Y-m-d H:i:s');
$id_usuario_asignacion = $_SESSION['id_usuario'];

for ($i=0; $i < count($id_usuario); $i++) { 
    $registrarPermisosUsuario = $operativo->registrarPermisosUsuario($rol, $tipo_usuario, $id_usuario[$i], $clientes, $registro, $consulta, $valor_cliente, $reportes, $anulacion, $fecha_asignacion, $id_usuario_asignacion);   
}

echo "<script>alert('Asignación realizada correctamente.'); window.location.href = '../Vista/permisosUsuariosOperativo.php';</script>";

?>