<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/ConceptosCobro.php");
include("../Modelo/TipoVehiculo.php");
require_once("../Modelo/General.php");

$tv = new TipoVehiculo();
$listado_tv = $tv->listar();
$cantidad = count($listado_tv);

$id = $_POST['id'];

$concepto = new ConceptoCobro();

if($cantidad > 0){
    
    foreach($listado_tv as $lt){
	
	$busqueda = $concepto->buscarValor($id,$lt['id_tipo_vehiculo']);
	$campo = "valor_".$lt['id_tipo_vehiculo'];
	$valor = $_POST[$campo];
	if(count($busqueda) > 0){
		$actualizar = $concepto->actualizarValor($id,$lt['id_tipo_vehiculo'],$valor);
	} else {
		$registrar = $concepto->registrarValor($id,$lt['id_tipo_vehiculo'],$valor);
	}	
    
    }

    echo "<script>
    alert('Valores actualizados correctamente');
    window.location.href = '../Vista/conceptos_cobro.php';
    </script>";
    exit;

} else {    
	echo "<script> 
	alert('Ocurrio un error al actualizar los valores, por favor intente nuevamente');    
	window.location.href = '../Vista/conceptos_cobro.php';    
	</script>";    
	exit;
}
?>