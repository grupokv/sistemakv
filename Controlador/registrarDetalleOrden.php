<?php
date_default_timezone_set('America/Bogota');

include ("Sesion/autenticar.php");
include("../Vista/Template/scripts.php");

require_once("../Modelo/OrdenServicio.php");

$orden = new OrdenServicio();
$id_orden = $_POST['id_orden'];
$categoria = $_POST['categoria'];
$subcategoria = $_POST['subcategoria'];
$cantidad = $_POST['cantidad'];
$valor = $_POST['valorTotal'];
$valor_act = $_POST['valor_actual'];
$nuevovalor = $valor_act + $valor;

$id = $orden->registrarDetalle($id_orden, $categoria, $subcategoria, $cantidad, $valor, $nuevovalor);

if(($id != '')&&($id != '0')){
	?>
	<script>
	var r = confirm("Desea agregar otro servicio?");
	if (r == true)
	{
		window.location.href='../Vista/registrarDetalleServicio.php?id='+<?php echo $id_orden;?>;
	} else {
		alert('Orden de servicio finalizada con exito');
	  	window.location.href='../Vista/ordenes_servicio.php';
	}
	</script>
	<?php
} else {
	echo ("<script>
    window.alert('Ocurrio un error durante el registro por favor intente nuevamente');
    window.location.href='../Vista/ordenes_servicio.php';
    </script>");
}
?>

