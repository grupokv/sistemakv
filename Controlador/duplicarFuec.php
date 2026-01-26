<?php
date_default_timezone_set('America/Bogota');

include ("Sesion/autenticar.php");
include("../Vista/Template/scripts.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");


$fuec = new Fuec();
$objVehiculo = new Vehiculo();
$Objcontrato = new Contrato();

$vehiculo = $_POST["vehiculo"];
$id_fuec = $_POST["id_fuec"];

$listarFuecId = $fuec->listarFuecPorId($id_fuec);

//print_r($listarFuecId);

$id_contrato = $listarFuecId[0]['id_contrato'];

$listarContrato = $Objcontrato->listarId($id_contrato);



$fecha = date('Y-m-d H:i:s');
$year = date('Y');
$hoy = date('YmdHis');

$num_interno = $hoy;

$datos_aprobacion = $fuec->aprobacionPorEmpresa($listarContrato[0]['id_empresa']);

$cod_ciudad = $datos_aprobacion[0]['cod_ciudad'];
$num_aprobacion = $datos_aprobacion[0]['num_aprobacion'];
$year_aprobacion = date('y',strtotime($datos_aprobacion[0]['fecha']));
$estado = 'F';

if(strlen($id_contrato) < 4){
	$id_contrato = str_pad($id_contrato, 4, "0", STR_PAD_LEFT);
}
$num_id_contrato = substr($id_contrato,-4);

$cantidad = $fuec->listarTotalFuecEmitidos(date('Y'));
$cantidad = ($cantidad[0]['cantidad'] + 1);

if(strlen($cantidad) < 4){
	$cantidad = str_pad($cantidad, 4, "0", STR_PAD_LEFT);
}

$num_unico_emision = $cantidad;

$num_comprobante = $cod_ciudad . $num_aprobacion . $year_aprobacion . $year . $num_id_contrato . $num_unico_emision;


$fecha_actual = date('Y-m-d');
//sumo 1 mes
$fecha2 = date("Y-m-d",strtotime($fecha_actual."+ 3 month"));


$docsVencidosVehiculo = $objVehiculo->listarPorId($vehiculo);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $objVehiculo->listarConductoresPorVehiculo($vehiculo);
$contratoid = $Objcontrato->listarId($id_contrato);
//print_r($docsVencidosVehiculo);

$fecha_final_fuec = $fecha2;

/*RP*/


foreach ($listarConductoresPorVehiculo as $lcpv) {
    if ($lcpv['fecha_vencimiento_licencia'] < $fecha_final_fuec) {
        $fecha_final_fuec = $lcpv['fecha_vencimiento_licencia'];
    }
}

if ($docsVencidosVehiculo[0]['fecha_vencimiento_rp'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_rp'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_to'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_to'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_soat'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_soat'];    
}if ($contratoid[0]['fecha_final_contrato'] < $fecha_final_fuec) {
    $fecha_final_fuec = $contratoid[0]['fecha_final_contrato'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];
}if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fecha_final_fuec) {
    $fecha_final_fuec = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
}if ($dispositivo_velocidad < $fecha_final_fuec) {
    $fecha_final_fuec = $dispositivo_velocidad;
}

$id = $fuec->registrarFuec($num_interno,$num_comprobante, $num_unico_emision, $listarFuecId[0]['origen'], $listarFuecId[0]['destino'], $listarFuecId[0]['tipo_fuec'], $listarFuecId[0]['con_fuec'], date('Y-m-d'), $fecha_final_fuec, $vehiculo, $id_contrato, '0', $listarFuecId[0]['responsable'], $listarFuecId[0]['idResponsable'], $listarFuecId[0]['dirResponsable'], $listarFuecId[0]['telResponsable'], $_SESSION['id_usuario'], $fecha, $listarFuecId[0]['anexo'], $estado);

$id_modulo = 22;
$id_registro = $id;
$tipo_actividad = 'DUPLICAR';
$columnas_modulo = 'id_fuec' . ' | ' . 'num_interno' . ' | ' . 'num_comprobante' . ' | ' . 'origen' . ' | ' . 'destino' . ' | ' . 'tipo_fuec' . ' | ' . 'con_fuec' . ' | ' . 'fecha_inicial_fuec'  . ' | ' . 'fecha_final_fuec'  . ' | ' . 'ruta1'  . ' | ' . 'ruta2' . ' | ' . 'id_vehiculo' . ' | ' . 'id_id_contrato'. ' | ' . 'responsable' . ' | ' . 'id_responsable' . ' | ' . 'dirResponsable' . ' | ' . 'telResponsable' . ' | ' . 'id_usuario' . ' | ' . 'fecha_creacion';
$valores_antiguos =  '';
$valores_nuevos = $id . ' | '. $num_interno . ' | '  . $num_comprobante . ' | '. $listarFuecId[0]['origen'] . ' | '. $listarFuecId[0]['destino'] . ' | '. $listarFuecId[0]['tipo_fuec'] . ' | '. $listarFuecId[0]['con_fuec'] . ' | '. $listarFuecId[0]['fecha_inicial_fuec'] . ' | '. $listarFuecId[0]['fecha_final_fuec'] . ' | '.  $vehiculo . ' | '. $id_contrato . ' | '. $listarFuecId[0]['responsable'] . ' | '.  $listarFuecId[0]['idResponsable'] . ' | '.  $listarFuecId[0]['dirResponsable'] . ' | '.  $listarFuecId[0]['telResponsable'] . ' | '. $_SESSION['id_usuario'] . ' | '.  $fecha;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);


if(($id != '')and($id != '0')){

	?>
	<script>
	  var id = <?php echo $id;?>;
	  var parametros = {
	    "id" : id
	  };
	  $.ajax({
	      data:  parametros,
	      url:   '../Resources/fuec/phpbarcode39/img_barcode39.php',
	      type:  'post',
	      beforeSend: function () {
	      },
	      success:  function (response) {
	      }
	  });
	  var parametros = {
	    "id" : id
	  };
	  $.ajax({
	      data:  parametros,
	      url:   '../Resources/fuec/phpqrcode/img_qr.php',
	      type:  'post',
	      beforeSend: function () {
	      },
	      success:  function (response) {
	      }
	  });

	  	alert("Extracto generado correctamente");
		window.location.href = "../Vista/fuec.php";
	</script>
	<?php
}
?>

