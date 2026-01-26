<?php 

require_once '../Modelo/SeguimientoActualizacion.php';
require_once '../Modelo/FotografiaVehiculo.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Vehiculo.php';

$id_seguimiento = $_POST['id_seguimiento'];
$boton_enviar = $_POST['enviar'];

$seguimiento = new Seguimiento_Actualizacion();
$fotografiaVehiculo = new FotografiaVehiculo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
	
	if ($boton_enviar == 1) {
		$estado = 'R';
		$actualizarEstado = $seguimiento->actualizarEstado($id_seguimiento, $estado, strtoupper($_POST['novedad_rechazo']));
	}else {
		$estado = 'A';
		$novedad_rechazo = '/';
		$actualizarEstado = $seguimiento->actualizarEstado($id_seguimiento, $estado, strtoupper($novedad_rechazo));

		$listarPorId = $seguimiento->listarPorId($id_seguimiento);

		$columnas = explode(" | ", $listarPorId[0]['columnas']);
		$nombre_documento = trim($columnas[0]);
		$fecha_vencimiento = $columnas[1];

		if ($listarPorId[0]['id_modulo'] == 11) {

			if (($nombre_documento == 'fotografia_frontal') || ($nombre_documento == 'fotografia_trasera') || ($nombre_documento == 'fotografia_lateral_izq') || ($nombre_documento == 'fotografia_lateral_der')) {

				$actualizarFotografiaPorDocumento = $fotografiaVehiculo->actualizarPorFotografia($listarPorId[0]['id_registro'], $nombre_documento, $listarPorId[0]['documento']);
				
			}else{

				$actualizarDocumentoPorId = $vehiculo->actualizarPorDocumento($listarPorId[0]['id_registro'], $nombre_documento, $listarPorId[0]['documento'], $fecha_vencimiento, $listarPorId[0]['nueva_fecha_vencimiento']);

			}

		}else{

			if ($listarPorId[0]['nueva_fecha_vencimiento'] == '0000-00-00') {

				$palabraBuscar   = '_ss';
				$pos = strpos($listarPorId[0]['columnas'], $palabraBuscar);

				if ($pos === true) {
					
					$seguridad_social = explode("_", $listarPorId[0]['columnas']);
					$mes_ss = $seguridad_social[0];

					$listarSSPorId = $conductor->listarSSPorId($listarPorId[0]['id_registro']);

					if ($listarSSPorId > 0) {
						$actualizarDocumentoSeguridadSocial = $conductor->actualizarDocumentoSeguridadSocial($listarPorId[0]['id_registro'], $mes_ss, $listarPorId[0]['documento']);
					}else{
						$registrarDocumentoSS = registrarDocumentoSS($listarPorId[0]['id_registro'], $mes_ss, $$listarPorId[0]['documento']);
					}


				}else{
					$actualizarDocumentoPorId = $conductor->actualizarPorDocumento($listarPorId[0]['id_registro'], $nombre_documento, $listarPorId[0]['documento']);
				}


				
			}else{
				$actualizarDocumentoPorId = $conductor->actualizarPorDocumentoYFechaVencimiento($listarPorId[0]['id_registro'], $nombre_documento, $listarPorId[0]['documento'], $fecha_vencimiento, $listarPorId[0]['nueva_fecha_vencimiento']);
			}

		}
	}

	header("Location: ../Vista/SeguimientoActualizaciones.php");

?>