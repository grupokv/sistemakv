<?php 

include 'Sesion/autenticar.php';
include'../Vista/Template/scripts.php';
require_once("../Modelo/contratoOcasional.php");
require_once("../Modelo/Fuec.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Ciudad.php");
require_once("../Modelo/Vehiculo.php");

date_default_timezone_set('America/Bogota');

$vehiculo = new Vehiculo();
$fuec = new Fuec();
$cliente = new Cliente();
$ciudad = new Ciudad();
$contratoOcasional = new ContratoOcasional();

$id_vehiculo = $_POST['id_vehiculo'];
$id_cliente = $_POST['id_cliente'];
$id_empresa = $_POST['id_empresa'];
$objeto_contrato = strtoupper($_POST['objeto_contrato']);
$origen = $_POST['origen'];
$destino = $_POST['destino'];
$ciudad_emision = $_POST['id_ciudad'];
$fecha_inicial_contrato_ocasional = $_POST['fecha_inicial_contrato_ocasional'];
$fecha_final_contrato_ocasional = date("Y-m-d",strtotime($fecha_inicial_contrato_ocasional . " + 15 day"));


$docsVencidosVehiculo = $vehiculo->listarPorId($id_vehiculo);
$docsVencidosConductoresPorVehiculo = $vehiculo->listarConductoresPorVehiculo($id_vehiculo);



foreach ($docsVencidosConductoresPorVehiculo as $lcpv) {
    $fecha_licencia = $lcpv['fecha_vencimiento_licencia'];
    //$examen_medico = date('Y-m-d',strtotime($lcpv['fecha_expedicion_examen_medico'] . "+ 1 year"));

    if ($fecha_licencia < $fecha_final_contrato_ocasional) {
   	  $fecha_final_contrato_ocasional = $fecha_licencia;
    }
    
}

$dispositivo_velocidad = date('Y-m-d',strtotime($docsVencidosVehiculo[0]['fecha_exp_disp_velocidad'] . "+ 1 year"));

if ($docsVencidosVehiculo[0]['fecha_vencimiento_rp'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_rp'];

}if ($docsVencidosVehiculo[0]['fecha_vencimiento_to'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_to'];

}if ($docsVencidosVehiculo[0]['fecha_vencimiento_soat'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_soat'];    

}if ($docsVencidosVehiculo[0]['fecha_vencimiento_rt'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_rt'];

}if ($docsVencidosVehiculo[0]['fecha_vencimiento_contra'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_contra'];

}if ($docsVencidosVehiculo[0]['fecha_vencimiento_extra'] < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $docsVencidosVehiculo[0]['fecha_vencimiento_extra'];
	   
}if ($dispositivo_velocidad < $fecha_final_contrato_ocasional) {
	   
	   $fecha_final_contrato_ocasional = $dispositivo_velocidad;

}

$fecha_final_contrato_ocasional;

$fecha_creacion = date('Y-m-d');
$hora_creacion = date('H:i:s');
$valor_contrato = $_POST['valor_contrato'];
$id_responsable = $_POST['id_responsable'];

// CONTRATO FIRMADO CONTRATO OCASIONAL
$fecha = date('YmdHis');

    if (!empty($_FILES['contrato_firmado']['name'])) {

        $carpeta = '../Documentos/ContratosOcasionales';
        $ruta = $carpeta .'/'. $fecha .'-'. $_FILES['contrato_firmado']['name'];
        $contrato_firmado = $fecha .'-'. $_FILES['contrato_firmado']['name'];

        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }

        $ruta_temp = $_FILES['contrato_firmado']['tmp_name'];
        move_uploaded_file($ruta_temp, $ruta);
        
    }


$validarVehiculosEximidosPagos = $contratoOcasional->validarVehiculosEximidosPagos($id_vehiculo, $fecha_creacion);
$validarPaquetesPlusOcasionales = $contratoOcasional->validarPaquetesPlusOcasionales($id_vehiculo, $fecha_creacion);

if (count($validarVehiculosEximidosPagos) > 0) {
	$estado = "F";
}else{


	if (count($validarPaquetesPlusOcasionales) > 0) {
		$estado = "F";
	}else{
		$estado = "P";
	}
}

/*REGISTRO CONTRATO OCASIONAL*/

$registrarCO = $contratoOcasional->registrarContratoOcasionalPropietarios($objeto_contrato, $id_empresa, $id_cliente, $id_vehiculo, $origen, $destino, $ciudad_emision, $fecha_inicial_contrato_ocasional, $fecha_final_contrato_ocasional, $fecha_creacion, $hora_creacion, $valor_contrato, $id_responsable, $estado);

$id_co = $registrarCO;

/* REGISTRO DOCUMENTO OCASIONAL*/

$registrarDocContratoOcasionalProp = $contratoOcasional->registrarDocContratoOcasionalProp($id_co, $contrato_firmado);

$fuec = new Fuec();
$cliente = new Cliente();
$ciudad = new Ciudad();

$listarCiudadOrigen = $ciudad->listarCiudadPorId($origen);
$listarCiudadDestino = $ciudad->listarCiudadPorId($destino);
$listarClientePorId = $cliente->listarClientePorId($id_cliente);

$year = date('Y');
$hoy = date('YmdHis');
$num_interno = $hoy;
$id_contrato = 0;
$tipo_fuec = $_POST['tipo_extracto'];
$con_fuec = $_POST['extracto_con'];
$anexo = 'N';

$datos_aprobacion = $fuec->aprobacionPorEmpresa($id_empresa);
$cod_ciudad = $datos_aprobacion[0]['cod_ciudad'];
$num_aprobacion = $datos_aprobacion[0]['num_aprobacion'];
$year_aprobacion = date('y',strtotime($datos_aprobacion[0]['fecha']));

if(strlen($registrarCO) < 4){
	$registrarCO = str_pad($registrarCO, 4, "0", STR_PAD_LEFT);
}
$num_contrato = substr($registrarCO,-4);

$cantidad = $fuec->listarTotalFuecEmitidos(date('Y'));
$cantidad = ($cantidad[0]['cantidad'] + 1);

if(strlen($cantidad) < 4){
	$cantidad = str_pad($cantidad, 4, "0", STR_PAD_LEFT);
}

$num_unico_emision = $cantidad;

$num_comprobante = $cod_ciudad . $num_aprobacion . $year_aprobacion . $year . $num_contrato . $num_unico_emision;


$registrarFuecO = $fuec->registrarFuec($num_interno, $num_comprobante, $num_unico_emision, $listarCiudadOrigen[0]['ciudad'], $listarCiudadDestino[0]['ciudad'], $tipo_fuec, $con_fuec, $fecha_inicial_contrato_ocasional, $fecha_final_contrato_ocasional, $id_vehiculo, $id_contrato, $id_co, $listarClientePorId[0]['razon_social'], $listarClientePorId[0]['nit_cliente'], $listarClientePorId[0]['direccionC'], $listarClientePorId[0]['telefonoC'], $id_responsable, date('Y-m-d H:i:s'), $anexo, $estado);


$id_modulo = 23;
$id_registro = $registrarCO;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_contrato_ocasional | objeto_contrato | id_empresa |id_cliente | id_vehiculo | origen | destino |
					id_ciudad | fecha_inicial_contrato_ocasional | fecha_final_contrato_ocasional | fecha_creacion | hora_creacion | valor_contrato | id_responsable';
$valores_antiguos =  '';
$valores_nuevos = $registrarCO . ' | '. $objeto_contrato . ' | '  . $id_empresa . ' | '  . $id_cliente . ' | '.
				  $id_vehiculo . ' | '. $origen . ' | '  . $destino . ' | '  . $id_ciudad . ' | ' .  $fecha_inicial_contrato_ocasional. ' | ' . $fecha_final_contrato_ocasional . ' | ' . 
				  $fecha_creacion . ' | ' . $hora_creacion . ' | '. $valor_contrato . ' | '. $id_responsable;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroContratosFijos = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header("Location: ../Resources/fuec/phpbarcode39/img_barcode39.php?id_fuecOcasional=" . $registrarFuecO);

?>

