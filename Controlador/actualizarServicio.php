<?php 
include ("Sesion/autenticar.php");
require_once("../Modelo/Programacion.php");
include("../Modelo/General.php");

$id_servicio = $_POST['id_servicio'];
$tipo_servicio = $_POST['tipo_servicio'];
$fecha_servicio = date("Y-m-d",strtotime($_POST['fecha_servicio']));
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
    $listado_pax = $_POST['listado_act'];
}

$id_tipo_vehiculo = $_POST['id_tipovehiculo'];
$id_tipo_servicio = $_POST['id_tiposervicio'];
$ciudad = $_POST['ciudad'];
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$centro_costo = $_POST['centro_costo'];
$solicitante = $_POST['solicitante'];

$estado =  'P';

$programacion = new Programacion();

$registrar = $programacion->actualizarServicio($id_servicio, $fecha_servicio, $hora_servicio, $nombre_contacto, $telefono_contacto, $cant_pax, $listado_pax, $id_tipo_vehiculo, $id_tipo_servicio, $ciudad, $origen, $destino, $centro_costo, $solicitante);

if($registrar != ''){
	echo "<script>
	alert('Servicio editado correctamente');
	window.location.href='../Vista/programacion_solicitudes.php';
	</script>";
} else {
	header('Location: ../Vista/programacion_solicitudes.php');
}

?>