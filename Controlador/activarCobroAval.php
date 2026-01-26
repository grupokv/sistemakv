<?php  
include ("../Controlador/Sesion/autenticar.php");	
require_once("../Modelo/Cartera.php");
require_once("../Modelo/Vehiculo.php");

$vehiculo = new Vehiculo();
$cartera = new Cartera();

$opcion_activacion = $_POST['opcion_activacion'];

$id_contrato = $_POST['id_contrato'];
$listarVehiculosPorContrato = $vehiculo->listarVehiculosPorContrato($id_contrato);
$mesesAvalActivos = explode("|", $_POST['mesesAvalActivos']);

$valor_aval = $_POST['valor_aval'];
$estado = 'A';
$id_usuario_activacion = $_SESSION['id_usuario'];

$vehiculos = $_POST['id_vehiculo'];
$id_vehiculos = array();

$cant = 0;

for ($i=0; $i < count($mesesAvalActivos); $i++) { 
	$fecha = explode("-", $mesesAvalActivos[$i]);
	$anio = $fecha[0];
	$mes = $fecha[1];
	$fecha_activacion = $mesesAvalActivos[$i];

	if($opcion_activacion == 1){

		for ($j=0; $j < count($vehiculos); $j++) { 
			$id_vehiculo = $vehiculos[$j];	
			$registrarAval = $cartera->registrarAval($id_vehiculo, $id_contrato, $valor_aval, $estado, $mes, $anio, $fecha_activacion, $id_usuario_activacion);
		}

	}else{

		foreach ($listarVehiculosPorContrato as $lvpc) {
			if(!in_array($lvpc['id_vehiculo'], $id_vehiculos)){
				array_push($id_vehiculos, $lvpc['id_vehiculo']);
			}
		}

		for ($j = 0; $j < count($id_vehiculos); $j++) { 
			$id_vehiculo = $id_vehiculos[$j];	
			$registrarAval = $cartera->registrarAval($id_vehiculo, $id_contrato, $valor_aval, $estado, $mes, $anio, $fecha_activacion, $id_usuario_activacion);	
		}
		
	}
	$cant = $cant + $registrarAval;

}

if ($registrarAval == 1) {
			
	?>

		<!DOCTYPE html>
		<html>
		<head>
	  		<?php include("../Vista/Template/styles.php") ?>
	  		<style>
	  			.ajs-button{
		            border-radius: 5px;
		            background-color: #5e99b1;
		            color: #fff;
		            box-shadow: none;
		            border:0px;
		        }

		        .ajs-header{
		            color: #1b2d3b !important;
		        }
	  		</style>
	  	</head>
		<body>
	    	<?php include("../Vista/Template/scripts.php"); ?>
			<script>

				function modalAviso(){
					alertify.alert('ACTIVACIÓN EXITOSA', '¡Se ha activado correctamente el cobro para los vehiculos seleccionados!', function(){ window.location.href = '../Vista/avalVehiculosCartera.php'; });   
		        }

		        $(window).on("load", modalAviso());

			</script>
		</body>
		</html>

	<?php

}else{

	?>
		<!DOCTYPE html>
		<html>
		<head>
	  		<?php include("../Vista/Template/styles.php") ?>
	  		<style>
	  			.ajs-button{
		            border-radius: 5px;
		            background-color: #5e99b1;
		            color: #fff;
		            box-shadow: none;
		            border:0px;
		        }

		        .ajs-header{
		            color: #1b2d3b !important;
		        }
	  		</style>
	  	</head>
		<body>
	    	<?php include("../Vista/Template/scripts.php"); ?>
			<script>

				function modalAviso(){
					alertify.alert('FALLO EN LA ACTIVACIÓN', '¡Se ha producido un fallo en el cobro de los vehiculos seleccionados!, por favor intente nuevamente.', function(){ window.location.href = '../Vista/activar_cobroAvales.php'; });   
		        }

		        $(window).on("load", modalAviso());

			</script>
		</body>
		</html>
	<?php

}

?>