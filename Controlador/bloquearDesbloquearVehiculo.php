<?php 

require_once("../Modelo/Vehiculo.php");

$id_vehiculo = $_POST['id_vehiculo'];
$estado = $_POST['estadoVehiculo'];
$soporte_documento = $_FILES['docCambioEstado']['name'];

$vehiculo = new Vehiculo();

if (!isset($id_vehiculo)) {
	echo "<script>
    window.location.href='../vista/vehiculos.php';
    </script>";
    exit();
}else{
  
	$fecha = date('YmdHis');
	
	if (!empty($_FILES['docCambioEstado']['name'])) {

		$carpeta = '../Documentos/Vehiculos/SoportesEstados/';
		$ruta = $carpeta .'/'. $fecha .'-'. $soporte_documento;
		$soporte_documento = $fecha .'-'. $soporte_documento;

		if (!file_exists($carpeta)) {
			mkdir($carpeta, 0757, true);
		}

		$ruta_temp = $_FILES['docCambioEstado']['tmp_name'];
		move_uploaded_file($ruta_temp, $ruta);
	}

	$cambiarEstadoVehiculo = $vehiculo->cambiarEstadoVehiculo($id_vehiculo, $estado, $soporte_documento);

}

header('Location: ../Vista/vehiculos.php');



?>
