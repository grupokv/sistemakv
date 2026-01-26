<?php
session_start();
date_default_timezone_set('America/Bogota');
require_once '../Modelo/SeguimientoActualizacion.php';
include ("../Controlador/Sesion/autenticar.php");
require_once '../Modelo/Vehiculo.php';

$seguimiento = new Seguimiento_Actualizacion();
$vehiculo = new Vehiculo();

$id_usuario = $_SESSION['id_usuario'];
$placa = $_POST['placa'];
$id_propietario = $_POST['id_propietario'];
$id_vehiculo = $_POST['id_vehiculo'];

$tarjeta_operacion = $_FILES['tarjeta_operacion']['name'];
$fecha_vencimiento_to = $_POST['fecha_vencimiento_to'];
$licencia_transito = $_FILES['licencia_transito']['name'];
$fecha_vencimiento_lt = $_POST['fecha_vencimiento_lt'];
$soat = $_FILES['soat']['name'];
$fecha_vencimiento_soat = $_POST['fecha_vencimiento_soat'];
$revision_tecnomecanica = $_FILES['revision_tecnomecanica']['name'];
$fecha_vencimiento_rt = $_POST['fecha_vencimiento_rt'];
$revision_preventiva = $_FILES['revision_preventiva']['name'];
$fecha_vencimiento_rp = $_POST['fecha_vencimiento_rp'];
$poliza_contra = $_FILES['poliza_contra']['name'];
$fecha_vencimiento_contra = $_POST['fecha_vencimiento_contra'];
$poliza_extra = $_FILES['poliza_extra']['name'];
$fecha_vencimiento_extra = $_POST['fecha_vencimiento_extra'];
$disp_velocidad = $_FILES['disp_velocidad']['name'];
$fecha_exp_disp_velocidad = $_POST['fecha_exp_disp_velocidad'];
$contrato_vinculacion = $_FILES['contrato_vinculacion']['name'];
$fecha_exp_contrato_vinculacion = $_POST['fecha_exp_contrato_vinculacion'];
$ficha_tecnica_homologacion = $_FILES['ficha_tecnica_homologacion']['name'];
$seguro_todo_riesgo = $_FILES['seguro_todo_riesgo']['name'];
$fecha_vencimiento_seguro_todo_riesgo = $_POST['fecha_vencimiento_seguro_todo_riesgo'];

$act_tarjeta_operacion = $_FILES['act_tarjeta_operacion']['name'];
$act_fecha_vencimiento_to = $_POST['act_fecha_vencimiento_to'];
$act_licencia_transito = $_FILES['act_licencia_transito']['name'];
$act_fecha_vencimiento_lt = $_POST['act_fecha_vencimiento_lt'];
$act_soat = $_FILES['act_soat']['name'];
$act_fecha_vencimiento_soat = $_POST['act_fecha_vencimiento_soat'];
$act_revision_tecnomecanica = $_FILES['act_revision_tecnomecanica']['name'];
$act_fecha_vencimiento_rt = $_POST['act_fecha_vencimiento_rt'];
$act_revision_preventiva = $_FILES['act_revision_preventiva']['name'];
$act_fecha_vencimiento_rp = $_POST['act_fecha_vencimiento_rp'];
$act_poliza_contra = $_FILES['act_poliza_contra']['name'];
$act_fecha_vencimiento_contra = $_POST['act_fecha_vencimiento_contra'];
$act_poliza_extra = $_FILES['act_poliza_extra']['name'];
$act_fecha_vencimiento_extra = $_POST['act_fecha_vencimiento_extra'];
$act_disp_velocidad = $_FILES['act_disp_velocidad']['name'];
$act_fecha_exp_disp_velocidad = $_POST['act_fecha_exp_disp_velocidad'];
$act_contrato_vinculacion = $_FILES['act_contrato_vinculacion']['name'];
$act_fecha_exp_contrato_vinculacion = $_POST['act_fecha_exp_contrato_vinculacion'];
$act_ficha_tecnica_homologacion = $_FILES['act_ficha_tecnica_homologacion']['name'];
$act_seguro_todo_riesgo = $_FILES['act_seguro_todo_riesgo']['name'];
$act_fecha_vencimiento_seguro_todo_riesgo = $_POST['act_fecha_vencimiento_seguro_todo_riesgo'];

$fotografia_frontal = $_FILES['fotografia_frontal']['name'];
$fotografia_trasera = $_FILES['fotografia_trasera']['name'];
$fotografia_lateral_izq = $_FILES['fotografia_lateral_izq']['name'];
$fotografia_lateral_der = $_FILES['fotografia_lateral_der']['name'];

$act_fotografia_frontal = $_FILES['act_fotografia_frontal']['name'];
$act_fotografia_trasera = $_FILES['act_fotografia_trasera']['name'];
$act_fotografia_lateral_izq = $_FILES['act_fotografia_lateral_izq']['name'];
$act_fotografia_lateral_der = $_FILES['act_fotografia_lateral_der']['name'];

$tipo_propietario = $_POST['tipo_propietario'];
$propiedad = $_POST['propiedad'];
$nombre_propietario = $_POST['nombre_propietario'];
$correo_electronico = $_POST['correo_electronico'];
$telefono_propietario = $_POST['telefono_propietario'];
$fecha_nac_propietario = $_POST['fecha_nac_propietario'];
$direccion_propietario = $_POST['direccion_propietario'];
$ciudad_propietario = $_POST['ciudad_propietario'];
$camara_comercio = $_FILES['camara_comercio']['name'];
$contrato_banco = $_FILES['contrato_banco']['name'];
$hoja_vida = $_FILES['hoja_vida']['name'];
$rut = $_FILES['rut']['name'];
$poder_apoderado = $_FILES['poder_apoderado']['name'];

$act_tipo_propietario = $_POST['act_tipo_propietario'];
$act_propiedad = $_POST['act_propiedad'];
$act_nombre_propietario = $_POST['act_nombre_propietario'];
$act_correo_electronico = $_POST['act_correo_electronico'];
$act_telefono_propietario = $_POST['act_telefono_propietario'];
$act_fecha_nac_propietario = $_POST['act_fecha_nac_propietario'];
$act_direccion_propietario = $_POST['act_direccion_propietario'];
$act_ciudad_propietario = $_POST['act_ciudad_propietario'];
$act_camara_comercio = $_FILES['act_camara_comercio']['name'];
$act_contrato_banco = $_FILES['act_contrato_banco']['name'];
$act_hoja_vida = $_FILES['act_hoja_vida']['name'];
$act_rut = $_FILES['act_rut']['name'];
$act_poder_apoderado = $_FILES['act_poder_apoderado']['name'];

$nombre_rc = $_POST['nombre_rc'];
$telefono_rc = $_POST['telefono_rc'];
$direccion_rc = $_POST['direccion_rc'];
$nombre_rl = $_POST['nombre_rl'];
$telefono_rl = $_POST['telefono_rl'];
$direccion_rl = $_POST['direccion_rl'];
$nombre_rf = $_POST['nombre_rf'];
$telefono_rf = $_POST['telefono_rf'];
$direccion_rf = $_POST['direccion_rf'];
$nombre_rp = $_POST['nombre_rp'];
$telefono_rp = $_POST['telefono_rp'];
$direccion_rp = $_POST['direccion_rp'];

$act_nombre_rc = $_POST['act_nombre_rc'];
$act_telefono_rc = $_POST['act_telefono_rc'];
$act_direccion_rc = $_POST['act_direccion_rc'];
$act_nombre_rl = $_POST['act_nombre_rl'];
$act_telefono_rl = $_POST['act_telefono_rl'];
$act_direccion_rl = $_POST['act_direccion_rl'];
$act_nombre_rf = $_POST['act_nombre_rf'];
$act_telefono_rf = $_POST['act_telefono_rf'];
$act_direccion_rf = $_POST['act_direccion_rf'];
$act_nombre_rp = $_POST['act_nombre_rp'];
$act_telefono_rp = $_POST['act_telefono_rp'];
$act_direccion_rp = $_POST['act_direccion_rp'];

$fechaRegistro = date('YmdHis');
$carpeta = '../Documentos/Vehiculos'. '/'. $placa;

if (!empty($_FILES['tarjeta_operacion']['name'])) {
	
	$id_modulo = 11;
	$columna = 'tarjeta_operacion | fecha_vencimiento_to';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['tarjeta_operacion']['name'];
	$ruta_temp = $_FILES['tarjeta_operacion']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_to, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['licencia_transito']['name'])) {
	
	$id_modulo = 11;
	$columna = 'licencia_transito | fecha_vencimiento_lt';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['licencia_transito']['name'];
	$ruta_temp = $_FILES['licencia_transito']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_lt, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['soat']['name'])) {
	
	$id_modulo = 11;
	$columna = 'soat | fecha_vencimiento_soat';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['soat']['name'];
	$ruta_temp = $_FILES['soat']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_soat, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['revision_tecnomecanica']['name'])) {
	
	$id_modulo = 11;
	$columna = 'revision_tecnomecanica | fecha_vencimiento_rt';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['revision_tecnomecanica']['name'];
	$ruta_temp = $_FILES['revision_tecnomecanica']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_rt, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['revision_preventiva']['name'])) {
	
	$id_modulo = 11;
	$columna = 'revision_preventiva | fecha_vencimiento_rp';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['revision_preventiva']['name'];
	$ruta_temp = $_FILES['revision_preventiva']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_rp, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['poliza_contra']['name'])) {
	
	$id_modulo = 11;
	$columna = 'poliza_contra | fecha_vencimiento_contra';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['poliza_contra']['name'];
	$ruta_temp = $_FILES['poliza_contra']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_contra, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['poliza_extra']['name'])) {
	
	$id_modulo = 11;
	$columna = 'poliza_extra | fecha_vencimiento_extra';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['poliza_extra']['name'];
	$ruta_temp = $_FILES['poliza_extra']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_extra, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['disp_velocidad']['name'])) {
	
	$id_modulo = 11;
	$columna = 'disp_velocidad | fecha_exp_disp_velocidad';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['disp_velocidad']['name'];
	$ruta_temp = $_FILES['disp_velocidad']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_exp_disp_velocidad, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['contrato_vinculacion']['name'])) {
	
	$id_modulo = 11;
	$columna = 'contrato_vinculacion | fecha_exp_contrato_vinculacion';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['contrato_vinculacion']['name'];
	$ruta_temp = $_FILES['contrato_vinculacion']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_exp_contrato_vinculacion, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['ficha_tecnica_homologacion']['name'])) {
	
	$id_modulo = 11;
	$columna = 'ficha_tecnica_homologacion';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['ficha_tecnica_homologacion']['name'];
	$ruta_temp = $_FILES['ficha_tecnica_homologacion']['tmp_name'];
	$fecha = '0000-00-00';
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['seguro_todo_riesgo']['name'])) {
	
	$id_modulo = 11;
	$columna = 'seguro_todo_riesgo | fecha_vencimiento_seguro_todo_riesgo';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['seguro_todo_riesgo']['name'];
	$ruta_temp = $_FILES['seguro_todo_riesgo']['tmp_name'];
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_seguro_todo_riesgo, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['fotografia_frontal']['name'])) {
	
	$id_modulo = '11-1';
	$columna = 'fotografia_frontal';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['fotografia_frontal']['name'];
	$ruta_temp = $_FILES['fotografia_frontal']['tmp_name'];
	$fecha = '0000-00-00';
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['fotografia_trasera']['name'])) {
	
	$id_modulo = '11-1';
	$columna = 'fotografia_trasera';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['fotografia_trasera']['name'];
	$ruta_temp = $_FILES['fotografia_trasera']['tmp_name'];
	$fecha = '0000-00-00';
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['fotografia_lateral_izq']['name'])) {
	
	$id_modulo = '11-1';
	$columna = 'fotografia_lateral_izq';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['fotografia_lateral_izq']['name'];
	$ruta_temp = $_FILES['fotografia_lateral_izq']['tmp_name'];
	$fecha = '0000-00-00';
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha, $id_vehiculo, $id_revision);
}

if (!empty($_FILES['fotografia_lateral_der']['name'])) {
	
	$id_modulo = '11-1';
	$columna = 'fotografia_lateral_der';
	$estado = 'P';
	$documento = $fechaRegistro.'-'.$_FILES['fotografia_lateral_der']['name'];
	$ruta_temp = $_FILES['fotografia_lateral_der']['tmp_name'];
	$fecha = '0000-00-00';
	$id_revision = 0;
    $ruta = $carpeta.'/'.$documento;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
            
	$seguimiento = new Seguimiento_Actualizacion();
	$registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha, $id_vehiculo, $id_revision);
}

if($tipo_propietario == ''){ $tipo_prop = $act_tipo_propietario; } else { $tipo_prop = $tipo_propietario; }
if($propiedad == ''){ $prop = $act_propiedad; } else { $prop = $propiedad; }
if($nombre_propietario == ''){ $nombres = $act_nombre_propietario; } else { $nombres = $nombre_propietario; }
if($correo_electronico == ''){ $email = $act_correo_electronico; } else { $email = $correo_electronico; }
if($telefono_propietario == ''){ $tel = $act_telefono_propietario; } else { $tel = $telefono_propietario; }
if($fecha_nac_propietario == ''){ $nac = $act_fecha_nac_propietario; } else { $nac = $fecha_nac_propietario; }
if($direccion_propietario == ''){ $dir = $act_direccion_propietario; } else { $dir = $direccion_propietario; }
if($ciudad_propietario == ''){ $ciudad = $act_ciudad_propietario; } else { $ciudad = $ciudad_propietario; }

if (!empty($_FILES['camara_comercio']['name'])) {
	$camara = $fechaRegistro.'-'.$_FILES['camara_comercio']['name'];
	$ruta_temp = $_FILES['camara_comercio']['tmp_name'];
    $ruta = $carpeta.'/'.$camara;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
} else {
	$camara = $act_camara_comercio;
}

if (!empty($_FILES['contrato_banco']['name'])) {
	$banco = $fechaRegistro.'-'.$_FILES['contrato_banco']['name'];
	$ruta_temp = $_FILES['contrato_banco']['tmp_name'];
    $ruta = $carpeta.'/'.$banco;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
} else {
	$banco = $act_contrato_banco;
}

if (!empty($_FILES['hoja_vida']['name'])) {
	$hv = $fechaRegistro.'-'.$_FILES['hoja_vida']['name'];
	$ruta_temp = $_FILES['hoja_vida']['tmp_name'];
    $ruta = $carpeta.'/'.$hv;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
} else {
	$hv = $act_hoja_vida;
}

if (!empty($_FILES['rut']['name'])) {
	$archivo_rut = $fechaRegistro.'-'.$_FILES['rut']['name'];
	$ruta_temp = $_FILES['rut']['tmp_name'];
    $ruta = $carpeta.'/'.$archivo_rut;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
} else {
	$archivo_rut = $act_rut;
}

if (!empty($_FILES['poder_apoderado']['name'])) {
	$poder = $fechaRegistro.'-'.$_FILES['poder_apoderado']['name'];
	$ruta_temp = $_FILES['poder_apoderado']['tmp_name'];
    $ruta = $carpeta.'/'.$poder;
	if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }
    move_uploaded_file($ruta_temp, $ruta);
} else {
	$poder = $act_poder_apoderado;
}


$propietario = $vehiculo->actualizarInfoPropietario($id_vehiculo, $tel, $nac, $dir, $ciudad, $tipo_prop, $prop, $camara, $banco, $hv, $archivo_rut, $poder);


$cant_rc = $vehiculo->buscarReferencia($id_vehiculo,'COMERCIAL');
//print_r($cant_rc);
$cant_rl = $vehiculo->buscarReferencia($id_vehiculo,'LABORAL');
//print_r($cant_rl);
$cant_rf = $vehiculo->buscarReferencia($id_vehiculo,'FAMILIAR');
//print_r($cant_rf);
$cant_rp = $vehiculo->buscarReferencia($id_vehiculo,'PERSONAL');
//print_r($cant_rp);


if(count($cant_rc) > 0){
	if(($nombre_rc != '')and($telefono_rc != '')){
		$propietario = $vehiculo->actualizarRefPropietario($id_vehiculo,'COMERCIAL',$nombre_rc,$telefono_rc,$direccion_rc,$estado);
	}
} else {
	if(($nombre_rc != '')and($telefono_rc != '')){
		$propietario = $vehiculo->registrarRefPropietario($id_vehiculo,'COMERCIAL',$nombre_rc,$telefono_rc,$direccion_rc,'A');
	}
}

if(count($cant_rl) > 0){
	if(($nombre_rl != '')and($telefono_rl != '')){
		$propietario = $vehiculo->actualizarRefPropietario($id_vehiculo,'LABORAL',$nombre_rl,$telefono_rl,$direccion_rl);
	}
} else {
	if(($nombre_rl != '')and($telefono_rl != '')){
		$propietario = $vehiculo->registrarRefPropietario($id_vehiculo,'LABORAL',$nombre_rl,$telefono_rl,$direccion_rl,'A');
	}
}

if(count($cant_rf) > 0){
	if(($nombre_rf != '')and($telefono_rf != '')){
		$propietario = $vehiculo->actualizarRefPropietario($id_vehiculo,'FAMILIAR',$nombre_rf,$telefono_rf,$direccion_rf);
	}
} else {
	if(($nombre_rf != '')and($telefono_rf != '')){
		$propietario = $vehiculo->registrarRefPropietario($id_vehiculo,'FAMILIAR',$nombre_rf,$telefono_rf,$direccion_rf,'A');
	}
}

if(count($cant_rp) > 0){
	if(($nombre_rp != '')and($telefono_rp != '')){
		$propietario = $vehiculo->actualizarRefPropietario($id_vehiculo,'PERSONAL',$nombre_rp,$telefono_rp,$direccion_rp);
	}
} else {
	if(($nombre_rp != '')and($telefono_rp != '')){
		$propietario = $vehiculo->registrarRefPropietario($id_vehiculo,'PERSONAL',$nombre_rp,$telefono_rp,$direccion_rp,'A');
	}
}

echo "Hola";

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
		<?php if ($_SESSION['id_perfil'] == 3) { ?>
			function modalAviso(){
				alertify.alert('INFORMACIÓN ACTUALIZADA', '¡La información del vehiculo ha sido cargado correctamente! \n Nota:  Si usted realizo una carga de algun documento del vehiculo, por favor espere a confirmación y validación del mismo para su debida actualización.', function(){ window.location.href = '../Vista/inicioConductores.php'; });   
	        }
	    <?php } else if (($_SESSION['id_perfil'] == 2) || ($_SESSION['id_perfil'] == 8)) { ?>
	    	function modalAviso(){
				alertify.alert('INFORMACIÓN ACTUALIZADA', '¡La información del vehiculo ha sido cargado correctamente! \n Nota: Si usted realizo una carga de algun documento del vehiculo, por favor espere a confirmación y validación del mismo para su debida actualización.', function(){ window.location.href = '../Vista/inicioPropietarios.php'; });   
	        }
	    <?php } ?>

        $(window).on("load", modalAviso());

	</script>
