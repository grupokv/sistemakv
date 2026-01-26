<?php 

require_once '../Modelo/Programacion.php';
require_once '../Modelo/Vehiculo.php';

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');


$programacion = new Programacion();
$vehiculo = new Vehiculo();

$id_asignacion = $_POST['id_servicio_adicional'];
$fecha_inicio = date('Y-m-d H:i:s', strtotime($_POST['fecha_servicio'] . ' ' . $_POST['hora_inicial']));
$kms_inicio = $_POST['kms_inicial'];
$fecha_final = date('Y-m-d H:i:s', strtotime($_POST['fecha_servicio'] . ' ' . $_POST['hora_final']));
$kms_final = $_POST['kms_final'];


$combustible = $_POST['combustible'];
$galones_combustible = $_POST['galones_gasolina'];
$valor_total_combustible = $_POST['valor_total_combustible'];
$peajes = $_POST['peajes'];
$cant_peajes = $_POST['cant_peajes'];
$valor_total_peajes = $_POST['valor_total_peajes'];

$detalle_servicio = $programacion->listarAsignacionIdAsignacion($id_asignacion);
$listarVehiculoPorId = $vehiculo->listarPorId($detalle_servicio[0]['id_vehiculo']);


$soportesArray = array();

if(!empty($_FILES['soporte_peajes']['name'])){
	for ($i=0; $i < count($_FILES['soporte_peajes']['name']); $i++) { 

        $carpeta = '../Documentos/Asignaciones'. '/'. $listarVehiculoPorId[0]['placa'] . '/' . str_pad($id_asignacion, 5, "0", STR_PAD_LEFT);
        $ruta = $carpeta .'/'. $fecha .'-'. $_FILES['soporte_peajes']['name'][$i];

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }

        $ruta_temp = $_FILES['soporte_peajes']['tmp_name'][$i];
        move_uploaded_file($ruta_temp, $ruta);
	        
		array_push($soportesArray, $fecha .'-'. $_FILES['soporte_peajes']['name'][$i]);

	}
}else{
	$soportesArray = "";
}



$soportes_peajes = json_encode($soportesArray);
$parqueadero = $_POST['parqueadero'];
$valor_total_parqueadero = $_POST['valor_total_parqueadero'];
$pernoctada = $_POST['pernoctada'];
$valor_total_pernoctada = $_POST['valor_total_pernoctada'];
$funcionario_transportado = $_POST['funcionario_transportado'];

$registrarAdicionalesServicio = $programacion->registrarAdicionalesServicio($id_asignacion, $fecha_inicio, $kms_inicio, $fecha_final, $kms_final,  $combustible, $galones_combustible, $valor_total_combustible, $peajes, $cant_peajes, $valor_total_peajes, $soportes_peajes, $parqueadero, $valor_total_parqueadero, $pernoctada, $valor_total_pernoctada, $funcionario_transportado);

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
		<?php if($registrarAdicionalesServicio == 1){ ?>

		function modalAviso(){
			alertify.alert('INFORMACIÓN GUARDADA', '¡Se ha registrado correctamente la información ingresada para el servicio seleccionado!', function(){ <?php header('Location: ../Vista/desinfeccion_ind.php?id=' . $detalle_servicio[0]['id_solicitud']); ?>  });   
        }

        $(window).on("load", modalAviso());

		<?php } ?>

	</script>