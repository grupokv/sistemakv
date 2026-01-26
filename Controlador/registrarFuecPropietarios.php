<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
include("../Vista/Template/scripts.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cartera.php");


$fuec = new Fuec();
$vehiculo = new Vehiculo();
$Objcontrato = new Contrato();
$cartera = new Cartera();

$cliente = $_POST["cliente"];
$contrato = $_POST["contrato"];
$id_vehiculo = $_POST["id_vehiculo"];
$origen = mb_strtoupper($_POST["origen"]);
$destino = mb_strtoupper($_POST["destino"]);
$tipo_extracto = mb_strtoupper($_POST["tipo_extracto"]);
$extracto_con = mb_strtoupper($_POST["extracto_con"]);
$nombre_responsable = mb_strtoupper($_POST["nombre_responsable"]);
$num_responsable = $_POST["num_responsable"];
$dir_responsable = mb_strtoupper($_POST["dir_responsable"]);
$tel_responsable = $_POST["tel_responsable"];
$anexo = $_POST["anexo"];
if ($anexo == '') {
	$anexo = 'N';
}else{
	$anexo = 'S';

}

$usuario = $_SESSION['id_usuario'];
$fecha = date('Y-m-d H:i:s');
$year = date('Y');
$hoy = date('YmdHis');

$num_interno = $hoy;

$contratoid = $Objcontrato->listarId($contrato);
$datos_aprobacion = $fuec->aprobacionPorEmpresa($contratoid[0]['id_empresa']);
$cod_ciudad = $datos_aprobacion[0]['cod_ciudad'];
$num_aprobacion = $datos_aprobacion[0]['num_aprobacion'];
$year_aprobacion = date('y',strtotime($datos_aprobacion[0]['fecha']));

if(strlen($contrato) < 4){
	$contrato = str_pad($contrato, 4, "0", STR_PAD_LEFT);
}
$num_contrato = substr($contrato,-4);

$cantidad = $fuec->listarTotalFuecEmitidos(date('Y'));
$cantidad = ($cantidad[0]['cantidad'] + 1);

if(strlen($cantidad) < 4){
	$cantidad = str_pad($cantidad, 4, "0", STR_PAD_LEFT);
}

$num_unico_emision = $cantidad;

$num_comprobante = $cod_ciudad . $num_aprobacion . $year_aprobacion . $year . $num_contrato . $num_unico_emision;
$fecha_actual = date('Y-m-d');

$fecha2 = date("Y-m-d",strtotime($fecha_actual."+ 2 month"));

if($_POST['cambiar_fecha'] == 'S'){
$fecha2 = $_POST['fecha_final'];
}

$docsVencidosVehiculo = $vehiculo->listarPorId($id_vehiculo);
$dispositivo_velocidad = date("Y-m-d",strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad']."+ 1 year"));
$listarConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($id_vehiculo);

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


$estado = 'F';


$fechaValidarAval = explode("-", date("Y-m-d"));
$anioAval = $fechaValidarAval[0];
$mesAval = $fechaValidarAval[1];
$diaAval = $fechaValidarAval[2];

$validarAvalVehiculo = $cartera->consultarAvalIdVehiculoMesAnio($id_vehiculo, $mesAval, $anioAval);
//print_r($validarAvalVehiculo);

if(($validarAvalVehiculo[0]['estado'] == 'E') || ($validarAvalVehiculo[0]['estado'] == 'F') || ($validarAvalVehiculo[0]['estado'] == 'I')){
	$estado = 'F';
}


/* REGISTRO DE FUEC */
$registrarFuecPropietarios = $fuec->registrarFuecPropietarios($num_interno, $num_comprobante, $num_unico_emision, $origen, $destino, $tipo_extracto, $extracto_con, date('Y-m-d'), $fecha_final_fuec, $id_vehiculo, $contrato,'0', $nombre_responsable, $num_responsable, $dir_responsable, $tel_responsable, $usuario, $fecha, $anexo, $estado);

$id = $registrarFuecPropietarios;


/*CREACION Y REGISTRO DE BITACORA DE ACCIONES */
$id_modulo = 22;
$id_registro = $id;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_fuec' . ' | ' . 'num_interno' . ' | ' . 'num_comprobante' . ' | ' . 'origen' . ' | ' . 'destino' . ' | ' . 'tipo_fuec' . ' | ' . 'con_fuec' . ' | ' . 'ruta1'  . ' | ' . 'ruta2' . ' | ' . 'id_vehiculo' . ' | ' . 'id_contrato'. ' | ' . 'responsable' . ' | ' . 'id_responsable' . ' | ' . 'dirResponsable' . ' | ' . 'telResponsable' . ' | ' . 'id_usuario' . ' | ' . 'fecha_creacion';
$valores_antiguos =  '';
$valores_nuevos = $id . ' | '. $num_interno . ' | '  . $num_comprobante . ' | '. $origen . ' | '. $destino . ' | '. $tipo_extracto . ' | '. $extracto_con . ' | '. $ruta1 . ' | '. $ruta2 . ' | '. $id_vehiculo . ' | '. $contrato . ' | '. $nombre_responsable . ' | '.  $num_responsable . ' | '.  $dir_responsable . ' | '.  $tel_responsable . ' | '.  $usuario . ' | '.  $fecha;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);


if(($id != '')and($id != '0')){

    include("Template/scripts.php");
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
		window.location.href = "../Vista/extractosFijosPropietarios.php";
	    
	</script>

<?php } ?>