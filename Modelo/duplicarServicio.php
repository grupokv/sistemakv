<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
include("../Modelo/General.php");

$programacion = new Programacion();

$fechaSer = $_POST['fecha_servicio'];
$fechas = explode(',',$fechaSer[0]);

for ($i=0; $i < count($fechas); $i++) { 

    $id_solicitud = $_POST['id_solicitud'];
   // $datossolicitud = $programacion->solicitudPorId($id_solicitud);

    $id_cliente = $_POST['id_cliente']; 
    $tipo = $_POST['tipo']; 
    $fecha = date('Y-m-d H:i:s'); 
    $fecha_servicio = $fechas[$i]; 
    $hora_servicio = date("H:i:s",strtotime($_POST['hora_servicio'])); 
    $nombre_contacto = mb_strtoupper($_POST['nombre_contacto']); 
    $telefono_contacto = $_POST['telefono_contacto']; 
    $cant_pax = $_POST['cant_pax']; 
    $fecha_archivo = date('YmdHis');

    if (!empty($_FILES['listado_pax']['name'])) {

        $carpeta = 'D:\sistemakv\Documentos\Servicios';
        $ruta = $carpeta .'/'. $fecha_archivo .'-'. $_FILES['listado_pax']['name'];
        $listado_pax = $fecha_archivo .'-'. $_FILES['listado_pax']['name'];

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }

        $ruta_temp = $_FILES['listado_pax']['tmp_name'];
        move_uploaded_file($ruta_temp, $ruta);
        
    } else {
        $listado_pax = "";
    }

    $id_tipo_vehiculo = $_POST['id_tipovehiculo']; 
    $id_tipo_servicio = $_POST['id_tiposervicio'];
    $ciudad = $_POST['ciudad'];
    $origen = $_POST['origen'];
    $destino = $_POST['destino'];
    $centro_costo = $_POST['centro_costo'];
    $solicitante = $_POST['solicitante'];
    $creador =  $_SESSION['id_usuario'];

    $estado =  'A';

    $registrar = $programacion->registrarServicio($id_solicitud, $creador, $id_cliente, $tipo, $fecha, $fecha_servicio, $hora_servicio, $nombre_contacto, $telefono_contacto, $cant_pax, $listado_pax, $id_tipo_vehiculo, $id_tipo_servicio, $ciudad, $origen, $destino, $centro_costo, $solicitante, $estado);

    $id_servicio = $registrar;
	$id_vehiculo = $_POST['id_vehiculo'];
	$id_conductor = $_POST['id_conductor'];
	$costo = $_POST['costo'];
	$tipo = 'D';

	$programacion = new Programacion();

	$registrarAsignacionDeServicio = $programacion->registrarAsignacion($id_servicio, $id_vehiculo, $id_conductor, 'A', $fecha, $tipo, $costo);

}

    $idas = $programacion->serviciosPorTipoIdSolicitud($id_solicitud,'IDA');
    $cant_idas = count($idas);
    
    $retornos = $programacion->serviciosPorTipoIdSolicitud($id_solicitud,'VUELTA');
    $cant_retornos = count($retornos);

//echo $id_solicitud = $_POST['id_solicitud'];
$listarSolicitudId = $programacion->solicitudPorId($id_solicitud);

if ($_POST['tipo'] == 'IDA') {
    if($listarSolicitudId[0]['servicios_ida'] < $cant_idas){
        $cantidad = ($listarSolicitudId[0]['servicios_ida'] + count($fechas));
        //echo $listarSolicitudId[0]['servicios_ida'];
        //echo count($fechas);
        //echo $cantidad;
        $actualizarIDA = $programacion->actualizarCantidadIdas($id_solicitud,$cantidad);
    }
}else{
    if($listarSolicitudId[0]['servicios_retorno'] < $cant_retornos){
        $cantidad = ($listarSolicitudId[0]['servicios_retorno'] + count($fechas));
        $actualizarRETORNO = $programacion->actualizarCantidadRetornos($id_solicitud,$cantidad);
    }
}


	echo "<script>alert('Servicio duplicado correctamente');window.location.href='../Vista/asignaciones.php';</script>";

?>