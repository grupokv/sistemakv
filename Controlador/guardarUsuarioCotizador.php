<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$nombre = $_POST['nombre'];
$usuario = $_POST['usuario'];
$pass = $_POST['pass'];
$cargo = $_POST['cargo'];
$telefono = $_POST['telefono'];
$email = $_POST['email'];
$estado = $_POST['estado'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->guardar_usuario($usuario,$pass,$nombre,$email,$telefono,$cargo,$estado);

if($registrar > 0){
    echo "<script>
    alert('Usuario registrado correctamente');
    window.location.href='../Vista/CotizacionAdminUsuarios.php';
    </script>";
} else {
    echo "<script>
    alert('Error al registrar usuario');
    window.history.back();
    </script>";
}
?>