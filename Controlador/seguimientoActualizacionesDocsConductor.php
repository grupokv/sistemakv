<?php  
session_start();
date_default_timezone_set('America/Bogota');

require_once '../Modelo/SeguimientoActualizacion.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Conductor.php';
require_once '../Modelo/Vehiculo-Conductor.php';
require_once '../Modelo/General.php';
require_once '../Modelo/referenciasConductor.php';
require_once '../Modelo/Usuario.php';

$referenciasConductor = new ReferenciasConductor();
$seguimiento = new Seguimiento_Actualizacion();
$seguimiento = new Seguimiento_Actualizacion();
$vehiculoConductor = new Vehiculo_Conductor();
$objVehiculo = new Vehiculo();
$usuario = new Usuario();


    $id_usuario = $_SESSION['id_usuario'];
    $id_conductor = $_POST['id_conductor'];
    $nombre_conductor = mb_strtoupper($_POST['nombre_conductor']);
    $nombre_conductor_act = mb_strtoupper($_POST['nombre_conductor_act']);
    $numero_documento_conductor = $_POST['numero_documento_conductor'];
    $fecha_nacimiento_conductor = $_POST['fecha_nacimiento_conductor'];
    $fecha_nacimiento_conductor_act = $_POST['fecha_nacimiento_conductor_act'];
    $fotocopia_documento = $_FILES['fotocopia_documento']['name'];
    $act_fotocopia_documento = $_POST['act_fotocopia_documento'];
    $fotocopia_licencia = $_FILES['fotocopia_licencia']['name'];
    $fotocopia_licencia_act = $_POST['fotocopia_licencia_act'];
    $num_licencia = $_POST['num_licencia'];
    $num_licencia_act = $_POST['num_licencia_act'];
    $categoria_licencia = $_POST['categoria_licencia'];
    $categoria_licencia_act = $_POST['categoria_licencia_act'];
    $fecha_vencimiento_licencia = $_POST['fecha_vencimiento_licencia'];
    $fecha_vencimiento_licencia_act = $_POST['fecha_vencimiento_licencia_act'];
    $telefono1 = $_POST['telefono1'];
    $telefono1_act = $_POST['telefono1_act'];
    $telefono2 = $_POST['telefono2'];
    $telefono2_act = $_POST['telefono2_act'];
    $telefono3 = $_POST['telefono3'];
    $telefono3_act = $_POST['telefono3_act'];
    $pago_pactado = $_POST['pago_pactado'];
    $pago_pactado_act = $_POST['pago_pactado_act'];
    $direccion = $_POST['direccion'];
    $act_direccion = $_POST['act_direccion'];
    $grupo_sanguineo = $_POST['rh'];
    $grupo_sanguineo_act = $_POST['rh_act'];
    $genero = $_POST['genero'];
    $genero_act = $_POST['genero_act'];
    $estado_civil = $_POST['estado_civil'];
    $estado_civil_act = $_POST['estado_civil_act'];

    $certificados_laborales = $_FILES['certificados_laborales']['name'];
    $act_certificados_laborales = $_POST['act_certificados_laborales'];
    $certificados_estudios = $_FILES['certificados_estudios']['name'];
    $act_certificados_estudios = $_POST['act_certificados_estudios'];
    $certificados_cursos = $_FILES['certificados_cursos']['name'];
    $act_certificados_cursos = $_POST['act_certificados_cursos'];
    $libreta_militar = $_FILES['libreta_militar']['name'];
    $act_libreta_militar = $_POST['act_libreta_militar'];
    $examen_medico = $_FILES['examen_medico']['name'];
    $act_examen_medico = $_POST['act_examen_medico'];
    $fecha_expedicion_examen_medico = $_POST['fecha_expedicion_examen_medico'];
    $act_fecha_expedicion_examen_medico = $_POST['act_fecha_expedicion_examen_medico'];

    $planilla_ss = $_FILES['planilla_ss']['name'];
    $act_planilla_ss = $_POST['act_planilla_ss'];

    $fotografia_conductor = $_FILES['fotografia_conductor']['name'];
    $act_fotografia_conductor = $_POST['act_fotografia_conductor'];
    $hoja_vida = $_FILES['hoja_vida']['name'];
    $act_hoja_vida = $_POST['act_hoja_vida'];
    $estado = $_POST['estado'];
    $correo_electronico = $_POST['correo_electronico'];
    $correo_electronico_act = $_POST['correo_electronico_act'];



    if ($correo_electronico != $correo_electronico_act) {
    	$actualizarCorreo = $usuario->actualizarCorreoConductor($numero_documento_conductor, $correo_electronico);
    }

/* ----------------------------------------------------------------- */
/*-----------------------INICIO NUEVOS CAMPOS------------------------*/
/* ----------------------------------------------------------------- */

    $procuraduria = $_FILES['procuraduria']['name'];
    $act_procuraduria = $_POST['act_procuraduria'];
    $fecha_procuraduria = $_POST['fecha_procuraduria'];
    $act_fecha_procuraduria = $_POST['act_fecha_procuraduria'];

    if(($fecha_procuraduria == '') && ($act_fecha_procuraduria == '')){ 
    	$fecha_procuraduria = '0000-00-00'; 
    } else if(($fecha_procuraduria == '') && ($act_fecha_procuraduria != '')){
    	$fecha_procuraduria = $act_fecha_procuraduria;
    }

    $contraloria = $_FILES['contraloria']['name'];
    $act_contraloria = $_POST['act_contraloria'];
    $fecha_contraloria = $_POST['fecha_contraloria'];
    $act_fecha_contraloria = $_POST['act_fecha_contraloria'];

    if(($fecha_contraloria == '') && ($act_fecha_contraloria == '')){ 
    	$fecha_contraloria = '0000-00-00'; 
    } else if(($fecha_contraloria == '') && ($act_fecha_contraloria != '')){
    	$fecha_contraloria = $act_fecha_contraloria;
    }

    $personeria = $_FILES['personeria']['name'];
    $act_personeria = $_POST['act_personeria'];
    $fecha_personeria = $_POST['fecha_personeria'];
    $act_fecha_personeria = $_POST['act_fecha_personeria'];

    if(($fecha_personeria == '') && ($act_fecha_personeria == '')){ 
    	$fecha_personeria = '0000-00-00'; 
    } else if(($fecha_personeria == '') && ($act_fecha_personeria != '')){
    	$fecha_personeria = $act_fecha_personeria;
    }

    $simit = $_FILES['simit']['name'];
    $act_simit = $_POST['act_simit'];
    $fecha_simit = $_POST['fecha_simit'];
    $act_fecha_simit = $_POST['act_fecha_simit'];

    if(($fecha_simit == '') && ($act_fecha_simit == '')){ 
    	$fecha_simit = '0000-00-00'; 
    } else if(($fecha_simit == '') && ($act_fecha_simit != '')){
    	$fecha_simit = $act_fecha_simit;
    }

    $policia = $_FILES['policia']['name'];
    $act_policia = $_POST['act_policia'];
    $fecha_policia = $_POST['fecha_policia'];
    $act_fecha_policia = $_POST['act_fecha_policia'];

    if(($fecha_policia == '') && ($act_fecha_policia == '')){ 
    	$fecha_policia = '0000-00-00'; 
    } else if(($fecha_policia == '') && ($act_fecha_policia != '')){
    	$fecha_policia = $act_fecha_policia;
    }

    $rut = $_FILES['rut']['name'];
    $act_rut = $_POST['act_rut'];
    $vacunas = $_FILES['vacunas']['name'];
    $act_vacunas = $_POST['act_vacunas'];
    $contrato_trabajo = $_FILES['contrato_trabajo']['name'];
    $act_contrato_trabajo = $_POST['act_contrato_trabajo'];
    $fecha_contrato = $_POST['fecha_contrato'];
    $act_fecha_contrato = $_POST['act_fecha_contrato'];

    if(($fecha_contrato == '') && ($act_fecha_contrato == '')){ 
    	$fecha_contrato = '0000-00-00'; 
    } else if(($fecha_contrato == '') && ($act_fecha_contrato != '')){
    	$fecha_contrato = $act_fecha_contrato;
    }

/* ----------------------------------------------------------------- */
/* -----------------------CAMPOS REFERENCIAS-------------------------*/
/* ----------------------------------------------------------------- */

    $nombre_rc = $_POST['nombre_rc'];
    $nombre_rc_act = $_POST['nombre_rc_act'];
    $telefono_rc = $_POST['telefono_rc'];
    $telefono_rc_act = $_POST['telefono_rc_act'];
    $direccion_rc = $_POST['direccion_rc'];
    $direccion_rc_act = $_POST['direccion_rc_act'];

    $nombre_rl = $_POST['nombre_rl'];
    $nombre_rl_act = $_POST['nombre_rl_act'];
    $telefono_rl = $_POST['telefono_rl'];
    $telefono_rl_act = $_POST['telefono_rl_act'];
    $direccion_rl = $_POST['direccion_rl'];
    $direccion_rl_act = $_POST['direccion_rl_act'];

    $nombre_rf = $_POST['nombre_rf'];
    $nombre_rf_act = $_POST['nombre_rf_act'];
    $telefono_rf = $_POST['telefono_rf'];
    $telefono_rf_act = $_POST['telefono_rf_act'];
    $direccion_rf = $_POST['direccion_rf'];
    $direccion_rf_act = $_POST['direccion_rf_act'];

    $nombre_rp = $_POST['nombre_rp'];
    $nombre_rp_act = $_POST['nombre_rp_act'];
    $telefono_rp = $_POST['telefono_rp'];
    $telefono_rp_act = $_POST['telefono_rp_act'];
    $direccion_rp = $_POST['direccion_rp'];
    $direccion_rp_act = $_POST['direccion_rp_act'];


    /*COMERCIAL*/
        if (($nombre_rc_act != $nombre_rc && $nombre_rc != '' && $nombre_rc_act != '') || ($telefono_rc_act != $telefono_rc && $telefono_rc != '' && $telefono_rc_act != '') || ($direccion_rc_act != $direccion_rc && $direccion_rc != '' && $direccion_rc_act != '')) {

            $id_referencia = $_POST['id_referencia_rc'];
            $tipo_referencia = 'COMERCIAL';
            $nombre_referencia = $nombre_rc;
            $telefono_referencia = $telefono_rc;
            $direccion_referencia = $direccion_rc;
            $estado = $_POST['estado_rc'];

            $actualizarReferencias = $referenciasConductor->actualizar($id_referencia, $id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

        }else if (($nombre_rc_act == '' && $nombre_rc != '') && ($telefono_rc_act == '' && $telefono_rc != '') && ($direccion_rc_act == '' && $direccion_rc != '')) {

           /* echo "Ingrese";*/
            $tipo_referencia = 'COMERCIAL';
            $nombre_referencia = $nombre_rc;
            $telefono_referencia = $telefono_rc;
            $direccion_referencia = $direccion_rc;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

    /*LABORAL*/

        if (($nombre_rl_act != $nombre_rl && $nombre_rl != '' && $nombre_rl_act != '') || ($telefono_rl_act != $telefono_rl && $telefono_rl != '' && $telefono_rl_act != '') || ($direccion_rl_act != $direccion_rl && $direccion_rl != '' && $direccion_rl_act != '')) {

            $id_referencia = $_POST['id_referencia_rl'];
            $tipo_referencia = 'LABORAL';
            $nombre_referencia = $nombre_rl;
            $telefono_referencia = $telefono_rl;
            $direccion_referencia = $direccion_rl;
            $estado = $_POST['estado_rl'];

            $actualizarReferencias = $referenciasConductor->actualizar($id_referencia, $id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

        }else if(($nombre_rl_act == ''  && $nombre_rl != '') && ($telefono_rl_act == ''  && $telefono_rl != '') && ($direccion_rl_act == '' && $direccion_rl != '')){

            $tipo_referencia = 'LABORAL';
            $nombre_referencia = $nombre_rl;
            $telefono_referencia = $telefono_rl;
            $direccion_referencia = $direccion_rl;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

    /*PERSONAL*/

        if (($nombre_rp_act != $nombre_rp && $nombre_rp != '' && $nombre_rp_act != '') || ($telefono_rp_act != $telefono_rp && $telefono_rp != '' && $telefono_rp_act != '') || ($direccion_rp_act != $direccion_rp && $direccion_rp != '' && $direccion_rp_act != '')) {

            $id_referencia = $_POST['id_referencia_rc'];
            $tipo_referencia = 'PERSONAL';
            $nombre_referencia = $nombre_rp;
            $telefono_referencia = $telefono_rp;
            $direccion_referencia = $direccion_rp;
            $estado = $_POST['estado_rp'];

            $actualizarReferencias = $referenciasConductor->actualizar($id_referencia, $id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

        }else if(($nombre_rp_act == '' && $nombre_rp != '') && ($telefono_rp_act == '' && $telefono_rp != '') && ($direccion_rp_act == '' && $direccion_rp != '')){

            $tipo_referencia = 'PERSONAL';
            $nombre_referencia = $nombre_rp;
            $telefono_referencia = $telefono_rp;
            $direccion_referencia = $direccion_rp;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

    /*FAMILIAR*/
        if (($nombre_rf_act != $nombre_rf && $nombre_rf != '' && $nombre_rf_act != '') || ($telefono_rf_act != $telefono_rf && $telefono_rf != '' && $telefono_rf_act != '') || ($direccion_rf_act != $direccion_rf && $direccion_rf != '' && $direccion_rf_act != '')) {

            $id_referencia = $_POST['id_referencia_rf'];
            $tipo_referencia = 'FAMILIAR';
            $nombre_referencia = $nombre_rf;
            $telefono_referencia = $telefono_rf;
            $direccion_referencia = $direccion_rf;
            $estado = $_POST['estado_rf'];

            $actualizarReferencias = $referenciasConductor->actualizar($id_referencia, $id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

        }else if(($nombre_rf_act == '' && $nombre_rf != '') && ($telefono_rf_act == '' && $telefono_rf != '') && ($direccion_rf_act == '' && $direccion_rf != '')){

            $tipo_referencia = 'FAMILIAR';
            $nombre_referencia = $nombre_rf;
            $telefono_referencia = $telefono_rf;
            $direccion_referencia = $direccion_rf;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

/* ----------------------------------------------------------------- */
/* -------------------- FIN REFERENCIAS -----------------------------*/

/* ----------------------------------------------------------------- */

/* ----------------- VEHICULOS POR CONDUCTOR ------------------------*/
/* ----------------------------------------------------------------- */

$eliminarVCPorId = $vehiculoConductor->eliminarPorId($id_conductor);
$vehiculo = $_POST['id_vehiculo'];

if ($_POST['id_vehiculo'] != '') {
    for ($i=0; $i < count($_POST['id_vehiculo']) ; $i++) { 
        $id_vehiculo = $vehiculo[$i];
        $registrarVC = $vehiculoConductor->registrar($id_vehiculo, $id_conductor);
    } 
}

/* ----------------------------------------------------------------- */
/*------------------ FIN VEHICULOS POR CONDUCTOR --------------------*/
/* ----------------------------------------------------------------- */



/*SEGUIMIENTO DE ACTUALIZACIÓN DE DOCUMENTOS */

$fechaRegistro = date('YmdHis');
$carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;

/*FOTOCOPIA DE DOCUMENTO*/
    if (!empty($_FILES['fotocopia_documento']['name'])) {
        
        $id_modulo = 12;
        $columna = 'fotocopia_documento';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['fotocopia_documento']['name'];
        $ruta_temp = $_FILES['fotocopia_documento']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/*FIN FOTOCOPIA DE DOCUMENTO*/

/* -------------------------*/

/* FOTOGRAFIA */
    if (!empty($_FILES['fotografia_conductor']['name'])) {
        
        $id_modulo = 12;
        $columna = 'fotografia_conductor';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['fotografia_conductor']['name'];
        $ruta_temp = $_FILES['fotografia_conductor']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN FOTOGRAFIA */

/* -------------------------*/

/* LICENCIA DE CONDUCCION */
    if (!empty($_FILES['fotocopia_licencia']['name'])) {
        
        $id_modulo = 12;
        $columna = 'fotocopia_licencia | fecha_vencimiento_licencia';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['fotocopia_licencia']['name'];
        $ruta_temp = $_FILES['fotocopia_licencia']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_vencimiento_licencia, $id_conductor, $id_revision);
    }
/* FIN LICENCIA */

/* -------------------------*/

/* CERTIFICADOS DE ESTUDIOS */
    if (!empty($_FILES['certificados_estudios']['name'])) {
        
        $id_modulo = 12;
        $columna = 'certificados_estudios';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['certificados_estudios']['name'];
        $ruta_temp = $_FILES['certificados_estudios']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN CERTIFICADOS DE ESTUDIOS */

/* -------------------------*/

/* CERTIFICADOS DE CURSOS */
    if (!empty($_FILES['certificados_cursos']['name'])) {
        
        $id_modulo = 12;
        $columna = 'certificados_cursos';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['certificados_cursos']['name'];
        $ruta_temp = $_FILES['certificados_cursos']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN CERTIFICADOS DE CURSOS */

/* -------------------------*/

/* CERTIFICADOS LABORALES */
    if (!empty($_FILES['certificados_laborales']['name'])) {
        
        $id_modulo = 12;
        $columna = 'certificados_laborales';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['certificados_laborales']['name'];
        $ruta_temp = $_FILES['certificados_laborales']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN CERTIFICADOS LABORALES */

/* -------------------------*/

/* LIBRETA MILITAR */
    if (!empty($_FILES['libreta_militar']['name'])) {
        
        $id_modulo = 12;
        $columna = 'libreta_militar';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['libreta_militar']['name'];
        $ruta_temp = $_FILES['libreta_militar']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN LIBRETA MILITAR */

/* -------------------------*/

/* EXAMEN MEDICO */
    if (!empty($_FILES['examen_medico']['name'])) {
        
        $id_modulo = 12;
        $columna = 'examen_medico | fecha_expedicion_examen_medico';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['examen_medico']['name'];
        $ruta_temp = $_FILES['examen_medico']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_expedicion_examen_medico, $id_conductor, $id_revision);
    }
/* FIN EXAMEN MEDICO */

/* -------------------------*/

/* HOJA DE VIDA */
    if (!empty($_FILES['hoja_vida']['name'])) {
        
        $id_modulo = 12;
        $columna = 'hoja_vida';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['hoja_vida']['name'];
        $ruta_temp = $_FILES['hoja_vida']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN HOJA DE VIDA */

/* -------------------------*/

/* RUT */
    if (!empty($_FILES['rut']['name'])) {
        
        $id_modulo = 12;
        $columna = 'rut';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['rut']['name'];
        $ruta_temp = $_FILES['rut']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN RUT */

/* -------------------------*/

/* VACUNAS */
    if (!empty($_FILES['vacunas']['name'])) {
        
        $id_modulo = 12;
        $columna = 'vacunas';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['vacunas']['name'];
        $ruta_temp = $_FILES['vacunas']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
    }
/* FIN VACUNAS */

/* -------------------------*/

/* CONTRATO DE TRABAJO */
    if (!empty($_FILES['contrato_trabajo']['name'])) {
        
        $id_modulo = 12;
        $columna = 'contrato_trabajo | fecha_contrato';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['contrato_trabajo']['name'];
        $ruta_temp = $_FILES['contrato_trabajo']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_contrato, $id_conductor, $id_revision);
    }
/* FIN CONTRATO DE TRABAJO */

/* -------------------------*/

/* POLICIA */
    if (!empty($_FILES['policia']['name'])) {
        
        $id_modulo = 12;
        $columna = 'doc_policia | fecha_policia';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['policia']['name'];
        $ruta_temp = $_FILES['policia']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_policia, $id_conductor, $id_revision);
    }
/* FIN POLICIA */

/* -------------------------*/

/* PROCURADURIA */
    if (!empty($_FILES['procuraduria']['name'])) {
        
        $id_modulo = 12;
        $columna = 'doc_procuraduria | fecha_procuraduria';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['procuraduria']['name'];
        $ruta_temp = $_FILES['procuraduria']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_procuraduria, $id_conductor, $id_revision);
    }
/* FIN PROCURADURIA*/

/* -------------------------*/

/* CONTRALORIA */
    if (!empty($_FILES['contraloria']['name'])) {
        
        $id_modulo = 12;
        $columna = 'doc_contraloria | fecha_contraloria';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['contraloria']['name'];
        $ruta_temp = $_FILES['contraloria']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_contraloria, $id_conductor, $id_revision);
    }
/* FIN CONTRALORIA */

/* -------------------------*/

/* PERSONERIA */
    if (!empty($_FILES['personeria']['name'])) {
        
        $id_modulo = 12;
        $columna = 'doc_personeria | fecha_personeria';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['personeria']['name'];
        $ruta_temp = $_FILES['personeria']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_personeria, $id_conductor, $id_revision);
    }
/* FIN PERSONERIA */

/* -------------------------*/

/* SIMIT */
    if (!empty($_FILES['simit']['name'])) {
        
        $id_modulo = 12;
        $columna = 'doc_simit | fecha_simit';
        $estado = 'P';
        $documento = $fechaRegistro . '-' . $_FILES['simit']['name'];
        $ruta_temp = $_FILES['simit']['tmp_name'];
        $id_revision = 0;
        $ruta = $carpeta . '/' . $documento;
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0757, true);
        }
        move_uploaded_file($ruta_temp, $ruta);
                
        $seguimiento = new Seguimiento_Actualizacion();
        $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, $fecha_simit, $id_conductor, $id_revision);
    }
/* FIN SIMIT */

/* -------------------------*/

/* SEGURIDAD SOCIAL*/

    for($i = 1;$i <= 12; $i++){

        if (!empty($_FILES['planilla_'.$i]['name'])) {

            $id_modulo = 12;
            $estado = 'P';
            $documento = $fechaRegistro . '-' . $_FILES['planilla_'.$i]['name'];
            $ruta_temp = $_FILES['planilla_'.$i]['tmp_name'];
            $id_revision = 0;
            $ruta = $carpeta . '/' . $documento;
            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0757, true);
            }
            move_uploaded_file($ruta_temp, $ruta);
                    

            if($i == 1){ 
                $columna = 'enero_ss';
            } else if($i == 2){
                $columna = 'febrero_ss'; 
            } else if($i == 3){
                $columna = 'marzo_ss';
            } else if($i == 4){
                $columna = 'abril_ss'; 
            } else if($i == 5){
                $columna = 'mayo_ss'; 
            } else if($i == 6){
                $columna = 'junio_ss'; 
            } else if($i == 7){
                $columna = 'julio_ss'; 
            } else if($i == 8){
                $columna = 'agosto_ss'; 
            } else if($i == 9){
                $columna = 'septiembre_ss'; 
            } else if($i == 10){
                $columna = 'octubre_ss'; 
            } else if($i == 11){
                $columna = 'noviembre_ss'; 
            } else if($i == 12){
                $columna = 'diciembre_ss'; 
            }


            $registrarSeguimiento = $seguimiento->registrar($id_usuario, $id_modulo, $columna, $estado, $documento, "0000-00-00", $id_conductor, $id_revision);
            
        }

    }

/* ----------------------------------------------------------------- */
/* --------------------- FIN SEGURIDAD SOCIAL -----------------------*/
/* ----------------------------------------------------------------- */
/* ------------ SEGUIMIENTO DE ACTUALIZACIÓN DE DOCUMENTOS ----------*/
/* ----------------------------------------------------------------- */

$id_modulo = 12;
$id_registro = $id_conductor;
$tipo_actividad = 'ACTUALIZAR VEHICULOS DEL CONDUCTOR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');
$fecha = date('YmdHis');

$listarVehiculosPorConductor = $objVehiculo->listarVehiculosPorConductor($id_conductor);

$array_actual = array();

for($i=0;$i<count($listarVehiculosPorConductor);$i++){
     array_push($array_actual,$listarVehiculosPorConductor[$i]['id_vehiculo']);
}

for($i=0;$i<count($_POST['id_vehiculo']);$i++){
    
    if(!in_array($_POST['id_vehiculo'][$i],$array_actual)){
        $diferencia = true;
    }
}

$vehiculos_actuales = '';
$vehiculos_nuevos = '';

for ($i=0; $i < count($_POST['id_vehiculo']) ; $i++) { 
   $vehiculos_nuevos .= $_POST['id_vehiculo'][$i] . ' | '; 
}

for ($i=0; $i < count($array_actual) ; $i++) { 
   $vehiculos_actuales .= $array_actual[$i] . ' | '; 
}

if ($diferencia == true) {
    $columnas_modulo .= 'id_vehiculo |'; 
    $valores_antiguos .= $vehiculos_actuales;
    $valores_nuevos .=  $vehiculos_nuevos;
}

if ($columnas_modulo != '') {
    $bitacoraActualizacionVehiculoPorConductor = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
}


/* ------------------------------------------------ */

        
        $id_modulo = 12;
        $id_registro = $id_conductor;
        $tipo_actividad = 'ACTUALIZAR';
        $columnas_modulo = '';
        $valores_antiguos = '';
        $valores_nuevos = '';
        $id_usuario = $_SESSION['id_usuario'];
        $fecha_actividad = date('Y-m-d');
        $hora_actividad = date('H:i:s');

        

        if ($nombre_conductor != $nombre_conductor_act) {
            $columnas_modulo .= 'nombre_conductor | ';
            $valores_antiguos .= $nombre_conductor_act . ' | ';
            $valores_nuevos .= $nombre_conductor . ' | ';
        }

        if ($hoja_vida != $act_hoja_vida) {
            $columnas_modulo .= 'hoja_vida | ';
            $valores_antiguos .= $act_hoja_vida . ' | ';
            $valores_nuevos .= $hoja_vida . ' | ';
        }

        if ($fotocopia_documento != $act_fotocopia_documento) {
            $columnas_modulo .= 'fotocopia_documento | ';
            $valores_antiguos .= $act_fotocopia_documento . ' | ';
            $valores_nuevos .= $fotocopia_documento . ' | ';
        }

        if ($fecha_nacimiento_conductor != $fecha_nacimiento_conductor_act) {
            $columnas_modulo .= 'fecha_nacimiento_conductor | ';
            $valores_antiguos .= $fecha_nacimiento_conductor_act . ' | ';
            $valores_nuevos .= $fecha_nacimiento_conductor . ' | ';
        }

        if ($fotocopia_licencia != $fotocopia_licencia_act) {
            $columnas_modulo .= 'fotocopia_licencia | ';
            $valores_antiguos .= $fotocopia_licencia_act . ' | ';
            $valores_nuevos .= $fotocopia_licencia . ' | ';
        }

        if ($num_licencia != $num_licencia_act) {
            $columnas_modulo .= 'num_licencia | ';
            $valores_antiguos .= $num_licencia_act . ' | ';
            $valores_nuevos .= $num_licencia . ' | ';
        }

        if ($fecha_vencimiento_licencia != $fecha_vencimiento_licencia_act) {
            $columnas_modulo .= 'fecha_vencimiento_licencia | ';
            $valores_antiguos .= $fecha_vencimiento_licencia_act . ' | ';
            $valores_nuevos .= $fecha_vencimiento_licencia . ' | ';
        }

        if ($direccion != $act_direccion) {
            $columnas_modulo .= 'direccion | ';
            $valores_antiguos .= $act_direccion . ' | ';
            $valores_nuevos .= $direccion . ' | ';
        }

        if ($telefono1 != $telefono1_act) {
            $columnas_modulo .= 'telefono1 | ';
            $valores_antiguos .= $telefono1_act . ' | ';
            $valores_nuevos .= $telefono1 . ' | ';
        }

        if ($telefono2 != $telefono2_act) {
            $columnas_modulo .= 'telefono2 | ';
            $valores_antiguos .= $telefono2_act . ' | ';
            $valores_nuevos .= $telefono2 . ' | ';
        }

        if ($telefono3 != $telefono3_act) {
            $columnas_modulo .= 'telefono3 | ';
            $valores_antiguos .= $telefono3_act . ' | ';
            $valores_nuevos .= $telefono3 . ' | ';
        }

        if ($pago_pactado != $pago_pactado_act) {
            $columnas_modulo .= 'pago_pactado | ';
            $valores_antiguos .= $pago_pactado_act . ' | ';
            $valores_nuevos .= $pago_pactado . ' | ';
        }

        if ($certificados_laborales != $act_certificados_laborales) {
            $columnas_modulo .= 'certificados_laborales | ';
            $valores_antiguos .= $act_certificados_laborales . ' | ';
            $valores_nuevos .= $certificados_laborales . ' | ';
        }

        if ($certificados_estudios != $act_certificados_estudios) {
            $columnas_modulo .= 'certificados_estudios | ';
            $valores_antiguos .= $act_certificados_estudios . ' | ';
            $valores_nuevos .= $certificados_estudios . ' | ';
        }


        if ($libreta_militar != $act_libreta_militar) {
            $columnas_modulo .= 'libreta_militar | ';
            $valores_antiguos .= $act_libreta_militar . ' | ';
            $valores_nuevos .= $libreta_militar . ' | ';
        }

        if ($examen_medico != $act_examen_medico) {
            $columnas_modulo .= 'examen_medico | ';
            $valores_antiguos .= $act_examen_medico . ' | ';
            $valores_nuevos .= $examen_medico . ' | ';
        }

         if ($fecha_expedicion_examen_medico != $act_fecha_expedicion_examen_medico) {
            $columnas_modulo .= 'fecha_expedicion_examen_medico | ';
            $valores_antiguos .= $act_fecha_expedicion_examen_medico . ' | ';
            $valores_nuevos .= $fecha_expedicion_examen_medico . ' | ';
        }

        if ($planilla_ss != $act_planilla_ss) {
            $columnas_modulo .= 'planilla_ss | ';
            $valores_antiguos .= $act_planilla_ss . ' | ';
            $valores_nuevos .= $planilla_ss . ' | ';
        }


        if ($columnas_modulo != '') {
            $bitacoraActualizacionConductor = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
        }


        header("Location: ../Vista/inicioPropietarios.php");

?>