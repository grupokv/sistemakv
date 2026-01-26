<?php
require_once("../Controlador/Sesion/CotizadorAutenticar.php");
require_once("../Modelo/CotizadorKV.php");

$id = $_POST['id'];
$valor = $_POST['valor'];

$cotizadorkv = new CotizadorKV();
$registrar = $cotizadorkv->editar_descuento($id,$valor);

if($registrar > 0){
    echo "<script>
    alert('Descuento editado correctamente');
    window.location.href='../Vista/CotizacionAdminDescuentos.php';
    </script>";
} else {
    echo "<script>
    alert('Error al editar descuento');
    window.history.back();
    </script>";
}
?>