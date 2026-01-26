<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id_borrar'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->eliminar_usuario($id);

if($registrar > 0){
    echo "<script>
    alert('Usuario eliminado correctamente');
    window.location.href='../Vista/CotizacionAdminUsuarios.php';
    </script>";
} else {
    echo "<script>
    alert('Error al eliminar usuario');
    window.history.back();
    </script>";
}
?>