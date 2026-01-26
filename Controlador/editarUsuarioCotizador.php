<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$pass = $_POST['pass'];
if($pass == ''){
    $pass = $_POST['pass_act'];
}
$cargo = $_POST['cargo'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$estado = $_POST['estado'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->editar_usuario($id,$usuario,$pass,$nombre,$email,$telefono,$cargo,$estado);

if($registrar > 0){
    echo "<script>
    alert('Usuario editado correctamente');
    window.location.href='../Vista/CotizacionAdminUsuarios.php';
    </script>";
} else {
    echo "<script>
    alert('Error al editar usuario');
    window.history.back();
    </script>";
}
?>