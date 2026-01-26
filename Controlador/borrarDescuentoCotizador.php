<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id_borrar'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->eliminar_descuento($id);

if($registrar > 0){
    echo "<script>
    alert('Descuento eliminado correctamente');
    window.location.href='../Vista/CotizacionAdminDescuentos.php';
    </script>";
} else {
    echo "<script>
    alert('Error al eliminar descuento');
    window.history.back();
    </script>";
}
?>