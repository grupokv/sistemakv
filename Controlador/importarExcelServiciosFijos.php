<?php 

include '../Resources/simplexlsx-master/src/SimpleXLSX.php';

require_once '../Modelo/Programacion.php';
require_once '../Modelo/Vehiculo.php';

$programacion = new Programacion();
$vehiculo = new Vehiculo();

//$targetPath = '../Documentos/Uploads/Servicios.xlsx';

//$allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  

/*if(in_array($_FILES["excel"]["type"], $allowedFileType)){

	*/

	if(file_exists("../Documentos/Uploads/Servicios.xlsx")){
		$xlsx = new SimpleXLSX("../Documentos/Uploads/Servicios.xlsx");

		$i = 1;
		//Recorremos los campos del fichero
		foreach ($xlsx->rows() as $fila => $campo){
		    //Evitamos la primera columna, ya que tendrán las cabeceras.
		    if($fila<=0){
		        continue;
		    }

		    $localidad = mb_strtoupper($campo[0],'utf-8');
		    $codigo_identificativo = "RF-" . $i;
		    $proyecto =  mb_strtoupper($campo[1],'utf-8');
		    $listarUnidadOperativaLIKE = $programacion->listarUnidadOperativaLIKE($campo[2]);
		    if (count($listarUnidadOperativaLIKE) > 0) {
		    	$unidad_operativa = $listarUnidadOperativaLIKE[0]['id_unidad'];
		    }else{
		    	$unidad_operativa = 0;
		    }
		    $punto_inicio = mb_strtoupper($campo[3],'utf-8');
		    $punto_final = "";
		    $entrada_salida =  mb_strtoupper($campo[4],'utf-8');
		    $horario = date('H:i:s', strtotime($campo[5]));
		    $frecuencia = $campo[6];
		    $observaciones = "";
		    $capacidad_servicio = $campo[7];
		    $nombre_monitora = mb_strtoupper($campo[8],'utf-8');
		    $telefono_monitora = $campo[9];
		    $listarPorPlaca = $vehiculo->listarPorPlaca(mb_strtoupper($campo[10]));
		    //print_r($listarPorPlaca);
		    if (count($listarPorPlaca) > 0) {
			    $id_vehiculo_facturacion = $listarPorPlaca[0]['id_vehiculo'];
			    $id_vehiculo_liquidacion = $listarPorPlaca[0]['id_vehiculo'];
		    }else{
			    $id_vehiculo_facturacion = 0;
			    $id_vehiculo_liquidacion = 0;
			}

		    $id_conductor = 0;
		    $valor_pagar = 0;
		    $valor_pagar_monitora = 0;
		    $valor_facturar = 0;

		    $registrarProgramacion = $programacion->registrarProgramacion($localidad, $codigo_identificativo, $proyecto, $unidad_operativa, $punto_inicio, $punto_final, $entrada_salida, $horario, $frecuencia, $observaciones, $capacidad_servicio, $nombre_monitora, $telefono_monitora, $id_vehiculo_facturacion, $id_vehiculo_liquidacion, $id_conductor, $valor_pagar, $valor_pagar_monitora, $valor_facturar);

		    $i++;
		}
	}

?>

