<?php 

include ("Sesion/autenticar.php");
include '../Resources/simplexlsx-master/src/SimpleXLSX.php';

require_once '../Modelo/Programacion.php';

$programacion = new Programacion();

$targetPath = '../Documentos/Uploads/Variables/'. $_FILES['excel']["name"];
move_uploaded_file($_FILES['excel']['tmp_name'], $targetPath);

$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  

if(in_array($_FILES["excel"]["type"], $allowedFileType)){

	if(file_exists($targetPath)){

		$xlsx = new SimpleXLSX($targetPath);

		//Recorremos los campos del fichero
		foreach ($xlsx->rows() as $fila => $campo){
		    //Evitamos la primera columna, ya que tendrán las cabeceras.
		    if($fila<=0){
		        continue;
		    }

		    $id_solicitante = $_SESSION['id_usuario'];
		    $unidad_operativa = mb_strtoupper($campo[0],'utf-8');
		    $fecha_inicial = date('Y-m-d', strtotime($campo[1]));
		    $fecha_final = date('Y-m-d', strtotime($campo[2]));
		    $direccion = mb_strtoupper($campo[3],'utf-8');
		    $lugar_destino = mb_strtoupper($campo[4],'utf-8');
		    $hora_encuentro = date('H:i:s', strtotime($campo[5]));
		    $hora_regreso = date('H:i:s', strtotime($campo[6]));
		    $capacidad = $campo[7];
		    $cant_pax = $campo[8];
		    $observaciones = mb_strtoupper($campo[9],'utf-8');
		    $listarporCodigoTiposServiciosVariables = $programacion->listarporCodigoTiposServiciosVariables($campo[10]);
		    $tipo_servicio = $listarporCodigoTiposServiciosVariables[0]['id'];
		    $num_buses = $campo[11];
		    $fecha_registro = date('Y-m-d H:i:s');

		    $registrarSolicitudesVariables = $programacion->registrarSolicitudesVariables($id_solicitante, $unidad_operativa, $fecha_inicial, $fecha_final, $direccion, $lugar_destino, $hora_encuentro, $hora_regreso, $capacidad, $cant_pax, $observaciones, $tipo_servicio, $num_buses, $fecha_registro);
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
						alertify.alert('CARGA EXITOSA', '¡Se han cargado las solicitudes correctamente en el sistema.', function(){ window.history.back(); });   
				    }
					
					$(window).on("load", modalAviso());

				</script>
		<?php
	}

} else { ?>

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
			alertify.alert('ERROR EN LA CARGA', '¡Se presento un error en la carga de la información, por favor valide el tipo de documento y la información del mismo.', function(){ window.history.back(); });   
	    }
		
		$(window).on("load", modalAviso());

	</script>

<?php } ?>

