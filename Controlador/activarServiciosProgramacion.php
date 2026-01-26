<?php  

require_once ("../Modelo/Programacion.php");
require_once ("../Modelo/General.php");

$programacion = new Programacion();
$mes = $_POST['mes'];


if ($mes != "") {
	$mesTexto = explode("-", $mes);
	$textMonthSelect = mes($mesTexto[1]);
	//$frecuencia = 'LUNES';

	$listar_programaciones = $programacion->listar_programaciones();
	//print_r($buscarProgramacionPorFrecuencia);

	if (count($listar_programaciones) > 0) {

		foreach ($listar_programaciones as $lpf) {
			$frecuencia = $lpf['frecuencia'];
			$dia = explode(",", $frecuencia);

			for ($i=0; $i < count($dia); $i++) { 
				//echo $dia[$i];
	    
			    if ($dia[$i] == 'LUNES') {
			        $day = 'monday';
			    }else if ($dia[$i] == 'MARTES') {
			        $day = 'tuesday';
			    }else if ($dia[$i] == 'MIERCOLES') {
			        $day = 'wednesday';
			    }else if ($dia[$i] == 'JUEVES') {
			        $day = 'thursday';
			    }else if ($dia[$i] == 'VIERNES') {
			        $day = 'friday';
			    }else if ($dia[$i] == 'SABADO') {
			        $day = 'saturday';
			    }else if ($dia[$i] == 'DOMINGO') {
			        $day = 'sunday';
			    }

			    //echo $day;

			    $diaMes = array();   

			    $primerDía = strtotime("first " . $day ." of " . $mes);
			    $temp = $primerDía;
			    
			    array_push($diaMes, date("Y-m-d", $temp));
			    $ultimoDia = strtotime("last " . $day . " of " . $mes);
			    
			    while($temp != $ultimoDia){
			        
			        $temp = strtotime(date("Y-m-d", $temp) . "+1 week");
			        array_push($diaMes, date("Y-m-d", $temp));

			    }

				$cant = 0;
			    for ($a=0; $a < count($diaMes); $a++) { 
			    	//echo $diaMes[$i];
			    	$registrarServiciosProgramacion = $programacion->registrarServiciosProgramacion($diaMes[$a], $lpf['localidad'], $lpf['codigo_identificativo'], $lpf['proyecto'], $lpf['unidad_operativa'], strtoupper($lpf['punto_inicio']), strtoupper($lpf['punto_final']), $lpf['entrada_salida'], $lpf['horario'], $lpf['frecuencia'], $lpf['observaciones'], $lpf['capacidad_servicio'], $lpf['nombre_monitora'], $lpf['telefono_monitora'], $lpf['id_vehiculo_facturacion'], $lpf['id_vehiculo_liquidacion'], $lpf['id_conductor'], $lpf['valor_pagar'], $lpf['valor_pagar_monitora'], $lpf['valor_facturar'], $lpf['id_programacion']);


				    $cant = $cant + $registrarServiciosProgramacion;
			    }

			}
		}	
	}

}else{
	$cant = 0;
}

if ($cant > 0) { ?>
	
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
			alertify.alert('PROGRAMACIÓN EXITOSA', '¡Se han programado correctamente los servicios para el mes de ' + ' <?php echo "<b>" . strtoupper($textMonthSelect) . "</b>" ?>' + ', por favor revise la activación de los mismos en el sistema.', function(){ window.history.back(); });   
        }
    	
    	$(window).on("load", modalAviso());

	</script>

<?php } else { ?>

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
				alertify.alert('ERROR EN LA PROGRAMACIÓN DE LOS SERVICIOS', 'No se selecciono el mes para la programacion de los servicios.', function(){ window.history.back(); });   
	        }
	    	
	    	$(window).on("load", modalAviso());

		</script>

<?php } ?>