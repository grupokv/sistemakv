<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/General.php");	
require_once("../Modelo/ConceptosCobro.php");

$id = $_POST['id'];
$detalle = mb_strtoupper($_POST['detalle']);
$cuenta = $_POST['cuentapuc'];
$contra = $_POST['contrapuc'];
$fecha = $_POST['fecha'];
$estado = $_POST['estado'];
$frecuencia = $_POST['frecuencia'];
$concepto = new ConceptoCobro();
$busqueda = $concepto->buscarPorDetalle($detalle);
$cant = count($busqueda);

$registrar = $concepto->actualizar($id,$detalle,$cuenta,$contra,$estado,$frecuencia,$fecha);
if($id != 0){
echo "<script LANGUAGE='JavaScript'>    
alert('Actualizacion realizada correctamente');    
window.location.href = '../Vista/conceptos_cobro.php';   
</script>";
} else {    
echo "<script>    
alert('Ocurrio un error al actualizar el concepto, por favor intente nuevamente');    
window.location.href = '../Vista/conceptos_cobro.php';    
</script>";    
exit;
}
?>