<?php  

include ("../Controlador/Sesion/autenticar.php");
require_once ("../Modelo/Programacion.php");

$programacion = new Programacion();

if ($_POST) {
	$localidad = $_POST['localidad'];
	$codigo_identificativo = $_POST['codigo_identificativo'];
	$proyecto = $_POST['proyecto'];
	$unidad_operativa = $_POST['unidad_operativa'];
	$punto_inicio = strtoupper($_POST['punto_inicio']);
	$punto_final = strtoupper($_POST['punto_final']);
	$entrada_salida = $_POST['entrada_salida'];
	$horario = $_POST['horario'];

	$frec = $_POST['frecuencia'];

	//print_r($frecuencia);
	$frecuencia = '';

	for ($i=0; $i < count($frec); $i++) { 

		if ($i == (count($frec) - 1)){
			$frecuencia .= $frec[$i];
		
		}else{
			$frecuencia .= $frec[$i] . ',';
		}
	}

	if ($_POST['confirmarObservaciones'] == 'S') {
		$observaciones = $_POST['observaciones'];
	}else{
		$observaciones = 'NO HAY OBSERVACIONES';
	}

	$capacidad_servicio = $_POST['capacidad_servicio'];
	$nombre_monitora = strtoupper($_POST['nombre_monitora']);
	$telefono_monitora = $_POST['telefono_monitora'];
	$id_vehiculo_facturacion = $_POST['id_vehiculo'];
	$id_vehiculo_liquidacion = $_POST['id_vehiculo'];
	$id_conductor = $_POST['id_conductor'];
	$valor_pagar = $_POST['valor_pagar'];
	$valor_pagar_monitora = $_POST['valor_pagar_monitora'];
	$valor_facturar = $_POST['valor_facturar'];

	$registrarProgramacion = $programacion->registrarProgramacion($localidad, $codigo_identificativo, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar);

	header("Location: ../Vista/programaciones.php");
	
}

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
	</body>
	</html>

	<script>

		function modalAviso(){
			alertify.alert('REGISTRO EXITOSO', '¡Se ha registrado correctamente!', function(){ window.history.back(); });   
        }
    	
    	$(window).on("load", modalAviso());

	</script>