<?php
include ("Sesion/autenticar.php");

require_once("../Modelo/ReferenciasPropietarioVehiculo.php");
require_once("../Modelo/FotografiaVehiculo.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/Cliente-Convenio.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

/*FECHA LOCAL*/
date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');


/*VARIABLES*/

    $id_vehiculo = $_POST['id_vehiculo'];
    $placa = mb_strtoupper($_POST['placa']);
    $marca = mb_strtoupper($_POST['marca']);
    $marca_act = mb_strtoupper($_POST['marca_act']);
    $modelo = $_POST['modelo'];
    $modelo_act = $_POST['modelo_act'];
    $cant_pasajeros = $_POST['cant_pasajeros'];
    $cant_pasajeros_act = $_POST['cant_pasajeros_act'];
    $numero_movil = $_POST['movil'];
    if($numero_movil == ''){
        $numero_movil = 0;
    }
    $numero_movil_act = $_POST['movil_act'];
    $numero_motor = mb_strtoupper($_POST['numero_motor']);
    $numero_motor_act = mb_strtoupper($_POST['numero_motor_act']);
    $numero_chasis = mb_strtoupper($_POST['numero_chasis']);
    $numero_chasis_act = mb_strtoupper($_POST['numero_chasis_act']);

    $id_tipo_servicio = $_POST['id_tipo_servicio'];
    $id_tipo_servicio_act = $_POST['id_tipo_servicio_act'];
    $id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
    $id_tipo_vehiculo_act = $_POST['id_tipo_vehiculo_act'];
    
    $tipo_afiliacion = $_POST['tipo_afiliacion'];
    $tipo_afiliacion_act = $_POST['tipo_afiliacion_act'];
    $empresa_afiliada_act = $_POST['empresa_afiliada_act'];
    $nit_empresa_afiliada_act = $_POST['nit_empresa_afiliada_act'];
    
    if($tipo_afiliacion == 'AFILIADO'){
        $empresa_afiliada = $_POST['empresa_afiliada'];
        $nit_empresa_afiliada = $_POST['nit_empresa_afiliada'];
    } else {
        $empresa_afiliada = $_POST['otra_empresa_afiliada'];
        $nit_empresa_afiliada = $_POST['nit_otra_empresa_afiliada'];
    }
    
    $fecha_registro = $_POST['fecha_registro'];
    $fecha_registro_act = $_POST['fecha_registro_act'];
    $ciudad_registro = $_POST['ciudad_registro'];
    $ciudad_registro_act = $_POST['ciudad_registro_act'];
    $num_puertas = $_POST['num_puertas'];
    $num_puertas_act = $_POST['num_puertas_act'];
    $cilindraje = $_POST['cilindraje'];
    $cilindraje_act = $_POST['cilindraje_act'];
    $tipo_carroceria = $_POST['tipo_carroceria'];
    $tipo_carroceria_act = $_POST['tipo_carroceria_act'];
    $tipo_combustible = $_POST['tipo_combustible'];
    $tipo_combustible_act = $_POST['tipo_combustible_act'];

    /*Propietario nuevo */
    $tipo_propietario_nuevo = $_POST['tipo_propietario_nuevo'];
    $propiedad_nuevo = $_POST['propiedad_nuevo'];
    $telefono_propietario_nuevo = $_POST['telefono_propietario_nuevo'];
    $fecha_nac_propietario_nuevo = $_POST['fecha_nac_propietario_nuevo'];
    if($fecha_nac_propietario_nuevo == ''){
        $fecha_nac_propietario_nuevo = '0000-00-00';
    } 
    $ciudad_propietario_nuevo = $_POST['ciudad_propietario_nuevo'];
    $direccion_propietario_nuevo = $_POST['direccion_propietario_nuevo'];
  
    /*Actualizacion propietario*/
    $id_propietario = $_POST['id_propietario'];
    $tipo_propietario = $_POST['tipo_propietario'];
    $tipo_propietario_act = $_POST['tipo_propietario_act'];
    $propiedad = $_POST['propiedad'];
    $propiedad_act = $_POST['propiedad_act'];
    $telefono_propietario = $_POST['telefono_propietario'];
    $telefono_propietario_act = $_POST['telefono_propietario_act'];
    $fecha_nac_propietario = $_POST['fecha_nac_propietario'];
    if($fecha_nac_propietario == ''){
        $fecha_nac_propietario = '0000-00-00';
    }
    $fecha_nac_propietario_act = $_POST['fecha_nac_propietario_act'];
    $ciudad_propietario = $_POST['ciudad_propietario'];
    $ciudad_propietario_act = $_POST['ciudad_propietario_act'];
    $direccion_propietario = $_POST['direccion_propietario'];
    $direccion_propietario_act = $_POST['direccion_propietario_act'];

    /*DOC PROPIETARIO*/
    $fotocopia_cedula_propietario = $_FILES['fotocopia_cedula_propietario']['name'];
    $act_fotocopia_cedula_propietario = $_POST['act_fotocopia_cedula_propietario'];
    $camara_comercio = $_FILES['camara_comercio']['name'];
    $act_camara_comercio = $_POST['act_camara_comercio'];
    $contrato_banco = $_FILES['contrato_banco']['name'];
    $act_contrato_banco = $_POST['act_contrato_banco'];
    $hoja_vida = $_FILES['hoja_vida']['name'];
    $act_hoja_vida = $_POST['act_hoja_vida'];
    $rut = $_FILES['rut']['name'];
    $act_rut = $_POST['rut'];
    $poder_apoderado = $_FILES['poder_apoderado']['name'];
    $act_poder_apoderado = $_POST['act_poder_apoderado'];
 

    /* -----------------------**********----------------------- */
    /* --------------------- DOC VEHICULO --------------------- */
    /* -----------------------**********----------------------- */

    /* --------------------- TO --------------------- */

    $tarjeta_operacion = $_FILES['tarjeta_operacion']['name'];
    $act_tarjeta_operacion = $_POST['act_tarjeta_operacion'];
    $num_tarjeta_operacion = $_POST['num_tarjeta_operacion'];
    $num_tarjeta_operacion_act = $_POST['num_tarjeta_operacion_act'];
    $fecha_vencimiento_to = $_POST['fecha_vencimiento_to'];
    $fecha_vencimiento_to_act = $_POST['fecha_vencimiento_to_act'];

    if($fecha_vencimiento_to == ''){
        $fecha_vencimiento_to = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- LT --------------------- */

    $licencia_transito = $_FILES['licencia_transito']['name'];
    $act_licencia_transito = $_POST['act_licencia_transito'];
    $num_licencia_transito = $_POST['num_licencia_transito'];
    $num_licencia_transito_act = $_POST['num_licencia_transito_act'];
    $fecha_vencimiento_lt = $_POST['fecha_vencimiento_lt'];
    $fecha_vencimiento_lt_act = $_POST['fecha_vencimiento_lt_act'];
    
    if($fecha_vencimiento_lt == ''){
        $fecha_vencimiento_lt = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- SOAT -------------------- */

    $soat = $_FILES['soat']['name'];
    $act_soat = $_POST['act_soat'];
    $num_soat = $_POST['num_soat'];
    $num_soat_act = $_POST['num_soat_act'];
    $fecha_vencimiento_soat = $_POST['fecha_vencimiento_soat'];
    $fecha_vencimiento_soat_act = $_POST['fecha_vencimiento_soat_act'];

    if($fecha_vencimiento_soat == ''){
        $fecha_vencimiento_soat = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- RT -------------------- */
    
    $revision_tecnomecanica = $_FILES['revision_tecnomecanica']['name'];
    $act_revision_tecnomecanica = $_POST['act_revision_tecnomecanica'];
    $num_revision_tecnomecanica = $_POST['num_revision_tecnomecanica'];
    $num_revision_tecnomecanica_act = $_POST['num_revision_tecnomecanica_act'];
    $fecha_vencimiento_rt = $_POST['fecha_vencimiento_rt'];
    $fecha_vencimiento_rt_act = $_POST['fecha_vencimiento_rt_act'];

    if($fecha_vencimiento_rt == ''){
        $fecha_vencimiento_rt = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- RP -------------------- */

    $revision_preventiva = $_FILES['revision_preventiva']['name'];
    $act_revision_preventiva = $_POST['act_revision_preventiva'];
    $fecha_vencimiento_rp = $_POST['fecha_vencimiento_rp'];
    $fecha_vencimiento_rp_act = $_POST['fecha_vencimiento_rp_act'];

    if($fecha_vencimiento_rp == ''){
        $fecha_vencimiento_rp = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- RCC -------------------- */

    $poliza_contra = $_FILES['poliza_contra']['name'];
    $act_poliza_contra = $_POST['act_poliza_contra'];
    $num_poliza_contra = $_POST['num_poliza_contra'];
    $num_poliza_contra_act = $_POST['num_poliza_contra_act'];
    $fecha_vencimiento_contra = $_POST['fecha_vencimiento_contra'];
    $fecha_vencimiento_contra_act = $_POST['fecha_vencimiento_contra_act'];

    if($fecha_vencimiento_contra == ''){
        $fecha_vencimiento_contra = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- RCE -------------------- */

    $poliza_extra = $_FILES['poliza_extra']['name'];
    $act_poliza_extra = $_POST['act_poliza_extra'];
    $num_poliza_extra = $_POST['num_poliza_extra'];
    $num_poliza_extra_act = $_POST['num_poliza_extra_act'];
    $fecha_vencimiento_extra = $_POST['fecha_vencimiento_extra'];
    $fecha_vencimiento_extra_act = $_POST['fecha_vencimiento_extra_act'];

    if($fecha_vencimiento_extra == ''){
        $fecha_vencimiento_extra = '0000-00-00';
    }

    /* --------------------------------------------- */
    /* --------------------- DV -------------------- */

    $disp_velocidad = $_FILES['disp_velocidad']['name'];
    $act_disp_velocidad = $_POST['act_disp_velocidad'];
    $fecha_exp_disp_velocidad = $_POST['fecha_exp_disp_velocidad'];
    $act_fecha_exp_disp_velocidad = $_POST['act_fecha_exp_disp_velocidad'];

    if($fecha_exp_disp_velocidad == ''){
        $fecha_exp_disp_velocidad = '0000-00-00';
    }

    /* ---------------------------------------------- */
    /* --------------------- STR -------------------- */

    $seguro_todo_riesgo = $_FILES['seguro_todo_riesgo']['name'];
    $act_seguro_todo_riesgo = $_POST['act_seguro_todo_riesgo'];
    $num_seguro_todo_riesgo = $_POST['num_seguro_todo_riesgo'];
    $num_seguro_todo_riesgo_act = $_POST['num_seguro_todo_riesgo_act'];
    $fecha_vencimiento_seguro_todo_riesgo = $_POST['fecha_vencimiento_seguro_todo_riesgo']; 
    $act_fecha_vencimiento_seguro_todo_riesgo = $_POST['act_fecha_vencimiento_seguro_todo_riesgo']; 
    
    if($fecha_vencimiento_seguro_todo_riesgo == ''){
        $fecha_vencimiento_seguro_todo_riesgo = '0000-00-00';
    }

    /* ---------------------------------------------- */
    /* --------------------- FTH -------------------- */

    $ficha_tecnica_homologacion = $_FILES['ficha_tecnica_homologacion']['name'];
    $act_ficha_tecnica_homologacion = $_POST['act_ficha_tecnica_homologacion'];

    /* ---------------------------------------------- */
    /* --------------------- FTH -------------------- */

    $contrato_vinculacion = $_FILES['contrato_vinculacion']['name'];
    $act_contrato_vinculacion = $_POST['act_contrato_vinculacion'];
    $fecha_exp_contrato_vinculacion = $_POST['fecha_exp_contrato_vinculacion'];
    $act_fecha_exp_contrato_vinculacion = $_POST['act_fecha_exp_contrato_vinculacion'];

    if($fecha_exp_contrato_vinculacion == ''){
        $fecha_exp_contrato_vinculacion = '0000-00-00';
    }
    


    /* -----------------------*********----------------------- */
    /* --------------------- REFERENCIAS --------------------- */
    /* -----------------------*********----------------------- */

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


    $flota_propia = $_POST['flota_propia'];
    $flota_propia_act = $_POST['flota_propia_act'];

    $id_fotografia = $_POST['id_fotografia'];
    $fotografia_frontal = $_FILES['fotografia_frontal']['name'];
    $act_fotografia_frontal = $_POST['act_fotografia_frontal'];
    $fotografia_trasera = $_FILES['fotografia_trasera']['name'];
    $act_fotografia_trasera = $_POST['act_fotografia_trasera'];
    $fotografia_lateral_izq = $_FILES['fotografia_lateral_izq']['name'];
    $act_fotografia_lateral_izq = $_POST['act_fotografia_lateral_izq'];
    $fotografia_lateral_der = $_FILES['fotografia_lateral_der']['name'];
    $act_fotografia_lateral_der = $_POST['act_fotografia_lateral_der'];


    if($flota_propia == 'S'){
        $id_empresa = $_POST['id_empresa'];
    } else {
        $id_empresa = 0;
    }
    
    $id_empresa_act = $_POST['id_empresa_act'];
    $estado = $_POST['estado'];

    if (isset($tarjeta_operacion) || isset($licencia_transito) || isset($soat) || isset($revision_tecnomecanica) || isset($revision_preventiva) || isset($polizas) || isset($fotocopia_cedula_propietario) || isset($disp_velocidad) || isset($camara_comercio) || isset($contrato_banco) || isset($contrato_vinculacion)) {

        /*TARJETA DE OPERAICIÓN*/
            if (!empty($_FILES['tarjeta_operacion']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['tarjeta_operacion']['name'], $_FILES['tarjeta_operacion']['size']);
                if($valido == 1){

                    $tarjeta_operacion = quitar_simbolos($_FILES['tarjeta_operacion']['name']);
                    $tarjeta_operacion = $num_tarjeta_operacion . '-'. $tarjeta_operacion;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $tarjeta_operacion;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['tarjeta_operacion']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en tarjeta de operacion no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            } else {
                $tarjeta_operacion = $_POST['act_tarjeta_operacion'];
            }

        /*LICENCIA DE TRANSITO*/
            if (!empty($_FILES['licencia_transito']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['licencia_transito']['name'], $_FILES['licencia_transito']['size']);
                if($valido == 1){

                    $licencia_transito = quitar_simbolos($_FILES['licencia_transito']['name']);
                    $licencia_transito = $num_licencia_transito . '-'. $licencia_transito;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $licencia_transito;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['licencia_transito']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en tarjeta de transito no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else { 
                $licencia_transito = $_POST['act_licencia_transito'];
            }

        /*SOAT*/
            if (!empty($_FILES['soat']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['soat']['name'], $_FILES['soat']['size']);
                if($valido == 1){

                    $soat = quitar_simbolos($_FILES['soat']['name']);
                    $soat = $num_soat . '-'. $soat;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $soat;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['soat']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en soat no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $soat = $_POST['act_soat'];
            }

        /*REVISIÓN TECNOMECANICA*/

            if (!empty($_FILES['revision_tecnomecanica']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['revision_tecnomecanica']['name'], $_FILES['revision_tecnomecanica']['size']);
                if($valido == 1){

                    $revision_tecnomecanica = quitar_simbolos($_FILES['revision_tecnomecanica']['name']);
                    $revision_tecnomecanica = $num_tarjeta_operacion . '-'. $revision_tecnomecanica;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $revision_tecnomecanica;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['revision_tecnomecanica']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en revision tecnomecanica no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }
      
            }else {
                $revision_tecnomecanica = $_POST['act_revision_tecnomecanica'];
            }

        /*REVISIÓN REVENTIVA*/

            if (!empty($_FILES['revision_preventiva']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['revision_preventiva']['name'], $_FILES['revision_preventiva']['size']);
                if($valido == 1){

                    $revision_preventiva = quitar_simbolos($_FILES['revision_preventiva']['name']);
                    $revision_preventiva = $fecha . '-'. $revision_preventiva;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $revision_preventiva;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['revision_preventiva']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en revision preventiva no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $revision_preventiva = $_POST['act_revision_preventiva'];
            }

        /*POLIZAS CONTRA*/

            if (!empty($_FILES['poliza_contra']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['poliza_contra']['name'], $_FILES['poliza_contra']['size']);
                if($valido == 1){

                    $poliza_contra = quitar_simbolos($_FILES['poliza_contra']['name']);
                    $poliza_contra = $num_poliza_contra . '-'. $poliza_contra;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $poliza_contra;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['poliza_contra']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en poliza contractual no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $poliza_contra = $_POST['act_poliza_contra'];
            }

        /*POLIZAS EXTRA*/

            if (!empty($_FILES['poliza_extra']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['poliza_extra']['name'], $_FILES['poliza_extra']['size']);
                if($valido == 1){

                    $poliza_extra = quitar_simbolos($_FILES['poliza_extra']['name']);
                    $poliza_extra = $num_poliza_extra . '-'. $poliza_extra;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $poliza_extra;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['poliza_extra']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en poliza extra no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $poliza_extra = $_POST['act_poliza_extra'];
            }

        /*DISPOSITIVO DE VELOCIDAD*/
            if (!empty($_FILES['disp_velocidad']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['disp_velocidad']['name'], $_FILES['disp_velocidad']['size']);
                if($valido == 1){

                    $disp_velocidad = quitar_simbolos($_FILES['disp_velocidad']['name']);
                    $disp_velocidad = $fecha . '-'. $disp_velocidad;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $disp_velocidad;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['disp_velocidad']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en dispositivo de velocidad no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $disp_velocidad = $act_disp_velocidad;
            }
            
        /*CONTRATO DE VINCULACIÓN*/

            if (!empty($_FILES['contrato_vinculacion']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['contrato_vinculacion']['name'], $_FILES['contrato_vinculacion']['size']);
                if($valido == 1){

                    $contrato_vinculacion = quitar_simbolos($_FILES['contrato_vinculacion']['name']);
                    $contrato_vinculacion = $fecha . '-'. $contrato_vinculacion;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $contrato_vinculacion;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['contrato_vinculacion']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en inspeccion vehicular no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $contrato_vinculacion = $act_contrato_vinculacion;
            }
            
        /*SEGURO TODO RIESGO*/

            if (!empty($_FILES['seguro_todo_riesgo']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['seguro_todo_riesgo']['name'], $_FILES['seguro_todo_riesgo']['size']);
                if($valido == 1){

                    $seguro_todo_riesgo = quitar_simbolos($_FILES['seguro_todo_riesgo']['name']);
                    $seguro_todo_riesgo = $num_seguro_todo_riesgo . '-'. $seguro_todo_riesgo;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $seguro_todo_riesgo;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['seguro_todo_riesgo']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en Seguro todo riesgo no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $seguro_todo_riesgo = $act_seguro_todo_riesgo;
            }
            
        /*FICHA TECNICA DE HOMOLOGACIÓN*/

            if (!empty($_FILES['ficha_tecnica_homologacion']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['ficha_tecnica_homologacion']['name'], $_FILES['ficha_tecnica_homologacion']['size']);
                if($valido == 1){

                    $ficha_tecnica_homologacion = quitar_simbolos($_FILES['ficha_tecnica_homologacion']['name']);
                    $ficha_tecnica_homologacion = $fecha . '-'. $ficha_tecnica_homologacion;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $ficha_tecnica_homologacion;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['ficha_tecnica_homologacion']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en Seguro todo riesgo no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $ficha_tecnica_homologacion = $act_ficha_tecnica_homologacion;
            }
       
        /*FOTOCOPIA DE CEDULA*/


            if (!empty($fotocopia_cedula_propietario)) {

                $valido = 0;
                $nombre_doc_cedula_propietario = $_FILES['fotocopia_cedula_propietario']['name'];
                $tamaño_doc_cedula_propietario = $_FILES['fotocopia_cedula_propietario']['size'];

                $valido = validar_archivo($nombre_doc_cedula_propietario, $tamaño_doc_cedula_propietario);

                echo $valido;


                if($valido == 1){

                    $fotocopia_cedula_propietario = quitar_simbolos($nombre_doc_cedula_propietario);
                    $fotocopia_cedula_propietario = $fecha . '-'. $fotocopia_cedula_propietario;                    
                    $carpeta = "../Documentos/Vehiculos". '/'. $placa;
                    $ruta = $carpeta .'/'. $fotocopia_cedula_propietario;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotocopia_cedula_propietario']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotocopia de cedula del propietario no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $fotocopia_cedula_propietario = $_POST['act_fotocopia_cedula_propietario'];
            }

        /*CAMARA DE COMERCIO*/
            if (!empty($_FILES['camara_comercio']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['camara_comercio']['name'], $_FILES['camara_comercio']['size']);
                if($valido == 1){

                    $camara_comercio = quitar_simbolos($_FILES['camara_comercio']['name']);
                    $camara_comercio = $fecha . '-'. $camara_comercio;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $camara_comercio;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['camara_comercio']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en inspeccion vehicular no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $camara_comercio = $act_camara_comercio;
            }

        /*CONTRATO BANCO*/
            if (!empty($_FILES['contrato_banco']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['contrato_banco']['name'], $_FILES['contrato_banco']['size']);
                if($valido == 1){

                    $contrato_banco = quitar_simbolos($_FILES['contrato_banco']['name']);
                    $contrato_banco = $fecha . '-'. $contrato_banco;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $contrato_banco;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['contrato_banco']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en inspeccion vehicular no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $contrato_banco = $act_contrato_banco;
            }
            
        /*HOJA DE VIDA*/
            if (!empty($_FILES['hoja_vida']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['hoja_vida']['name'], $_FILES['hoja_vida']['size']);
                if($valido == 1){

                    $hoja_vida = quitar_simbolos($_FILES['hoja_vida']['name']);
                    $hoja_vida = $fecha . '-'. $hoja_vida;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $hoja_vida;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['hoja_vida']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en Hoja de Vida no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $hoja_vida = $act_hoja_vida;
            }
         
        /*RUT*/
            if (!empty($_FILES['rut']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['rut']['name'], $_FILES['rut']['size']);
                if($valido == 1){

                    $rut = quitar_simbolos($_FILES['rut']['name']);
                    $rut = $fecha . '-'. $rut;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $rut;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['rut']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en Registro Único Tributario (RUT) no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $rut = $act_rut;
            }
        
        /*PODER APODERADO*/
            if (!empty($_FILES['poder_apoderado']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['poder_apoderado']['name'], $_FILES['poder_apoderado']['size']);
                if($valido == 1){

                    $poder_apoderado = quitar_simbolos($_FILES['poder_apoderado']['name']);
                    $poder_apoderado = $fecha . '-'. $poder_apoderado;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $poder_apoderado;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['poder_apoderado']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en poder apoderado no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            }else {
                $poder_apoderado = $act_poder_apoderado;
            }

        /*FOTOGRAFIA FRONTAL*/
            if (!empty($_FILES['fotografia_frontal']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotografia_frontal']['name'], $_FILES['fotografia_frontal']['size']);
                if($valido == 1){

                    $fotografia_frontal = quitar_simbolos($_FILES['fotografia_frontal']['name']);
                    $fotografia_frontal = $fecha . '-'. $fotografia_frontal;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $fotografia_frontal;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotografia_frontal']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotografia frontal no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            } else {
                $fotografia_frontal = $_POST['act_fotografia_frontal'];
            }

        /*FOTOGRAFIA TRASERA*/
            if (!empty($_FILES['fotografia_trasera']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotografia_trasera']['name'], $_FILES['fotografia_trasera']['size']);
                if($valido == 1){

                    $fotografia_trasera = quitar_simbolos($_FILES['fotografia_trasera']['name']);
                    $fotografia_trasera = $fecha . '-'. $fotografia_trasera;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $fotografia_trasera;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotografia_trasera']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotografia trasera no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            } else {
                $fotografia_trasera = $_POST['act_fotografia_trasera'];
            }
        
        /*FOTOGRAFIA LATERAL DERECHA*/
            if (!empty($_FILES['fotografia_lateral_der']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotografia_lateral_der']['name'], $_FILES['fotografia_lateral_der']['size']);
                if($valido == 1){

                    $fotografia_lateral_der = quitar_simbolos($_FILES['fotografia_lateral_der']['name']);
                    $fotografia_lateral_der = $fecha . '-'. $fotografia_lateral_der;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $fotografia_lateral_der;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotografia_lateral_der']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotografia lateral derecha no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            } else {
                $fotografia_lateral_der = $_POST['act_fotografia_lateral_der'];
            }

        /*FOTOGRAFIA LATERAL IZQUIERDA*/
            if (!empty($_FILES['fotografia_lateral_izq']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotografia_lateral_izq']['name'], $_FILES['fotografia_lateral_izq']['size']);
                if($valido == 1){

                    $fotografia_lateral_izq = quitar_simbolos($_FILES['fotografia_lateral_izq']['name']);
                    $fotografia_lateral_izq = $fecha . '-'. $fotografia_lateral_izq;                    
                    $carpeta = "../Documentos/Vehiculos/". $placa;
                    $ruta = $carpeta .'/'. $fotografia_lateral_izq;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotografia_lateral_izq']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotografia lateral izquierda no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }

            } else {
                $fotografia_lateral_izq = $_POST['act_fotografia_lateral_izq'];
            }

    }

    
        $propietario_cambio = $_POST['propietario_cambio'];
        $usuario = new Usuario();
    
        if ($propietario_cambio == 1) {

            $usuario_nue = $_POST['numero_documento_nue'];
            $clave = base64_encode($_POST['numero_documento_nue']);

            $existe = $usuario->buscarUsuarioPorCedula($usuario_nue);
        

            if(count($existe)<1){
                
                $correo_electronico = mb_strtoupper($_POST['correo_electronico_nue']);
                $nombre = mb_strtoupper($_POST['nombre']);
                $fecha_ultimo_ingreso = date('Y-m-d H:i:s');
                $id_perfil = 2;

                $registrarPropietario = $usuario->registrarPropietario($usuario_nue, $clave, $id_perfil, $correo_electronico, $nombre, $fecha_ultimo_ingreso);

            } else {

                    if($existe[0]['id_perfil'] == 3){
                        $id_perfil = 8;
                        $usuario->actualizarPerfil($existe[0]['id_usuario'],$id_perfil);
                    }else{
                        $registrarPropietario = $existe[0]['id_usuario'];
                    }

            }
            
            //REGISTRO DE BITACORAS
            $id_modulo = 4;
            $id_registro = $registrarPropietario;
            $tipo_actividad = 'REGISTRAR';
            $columnas_modulo = 'id_usuario | usuario | clave | id_perfil | correo_electronico | estado | nombre
                                | id_cargo | cant_ingresos | fecha_ultimo_ingreso';
            $valores_antiguos = '';
            $valores_nuevos = $registrarPropietario . ' | ' . $usuario_nue . ' | ' .  $clave . ' | ' .  2 . ' | ' .
                                $correo_electronico . ' | ' . 1 . ' | ' . $nombre . ' | ' . 0 . ' | ' .
                                0 . ' | ' .  $fecha_ultimo_ingreso;
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_actividad = date('Y-m-d');
            $hora_actividad = date('H:i:s');


            if ($columnas_modulo != '') {
                $bitacoraActualizacionPropietario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
            }

        }else if ($propietario_cambio == 2) {

            $id_u = $_POST['id_propietario'];
            $registrarPropietario = $id_u;
            $usuario1 = mb_strtoupper($_POST['usuario_act']);
            $clave = base64_encode($_POST['clave_act']);
            $id_perfil = $_POST['id_perfil_act'];
            $correo_electronico = mb_strtoupper($_POST['correo_electronico']);
            $correo_electronico_act = mb_strtoupper($_POST['correo_electronico_act']);
            $estado = $_POST['estado_propietario_act'];
            $nombre = mb_strtoupper($_POST['nombre_propietario']);
            $nombre_propietario_act = mb_strtoupper($_POST['nombre_propietario_act']);
            $id_cargo = $_POST['id_cargo_act'];
            $cant_ingresos = $_POST['cant_ingresos_act'];
            $fecha_ultimo_ingreso = $_POST['fecha_ultimo_ingreso_act'];

            $actualizarPropietario = $usuario->actualizarPropietario($id_u, $usuario1, $clave, $id_perfil, $correo_electronico, $estado, $nombre, $id_cargo, $cant_ingresos, $fecha_ultimo_ingreso);
            
            $id_modulo = 4;
            $id_registro = $id_u;
            $tipo_actividad = 'ACTUALIZAR';
            $columnas_modulo = '';
            $valores_antiguos = '';
            $valores_nuevos = '';
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_actividad = date('Y-m-d');
            $hora_actividad = date('H:i:s');

            if ($correo_electronico != $correo_electronico_act) {
                $columnas_modulo .= 'correo_electronico  | ';
                $valores_antiguos .= $correo_electronico_act . ' | ';
                $valores_nuevos .= $correo_electronico . ' | ';
            }

            if ($nombre != $nombre_act) {
                $columnas_modulo .= 'nombre  | ';
                $valores_antiguos .= $nombre_act . ' | ';
                $valores_nuevos .= $nombre . ' | ';
            }


            if ($columnas_modulo != '') {
                $bitacoraActualizacionPropietario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
            }

        } else {
            $id_u = $_POST['id_propietario'];
            $registrarPropietario = $id_u;         
        }


        
        $vehiculo = new Vehiculo();
        $vehiculoContrato = new Vehiculo_Contrato();
        $contrato = new Contrato();

        $id_contratoB = $_POST['id_contratoB'];
        $id_contratoA = $_POST['id_contratoA'];

        $eliminarContratosBasePorVehiculo = $vehiculoContrato->eliminarContratosBasePorVehiculo($id_vehiculo);

        if ($id_contratoB != 0) {
            $tipo_contrato = 'BASE';
            $registrarVC = $vehiculoContrato->registrar($id_vehiculo, $id_contratoB, $tipo_contrato);
        }
        
        $eliminarContratosApoyoPorVehiculo = $vehiculoContrato->eliminarContratosApoyoPorVehiculo($id_vehiculo);

        if ($id_contratoA != 0) {
            for ($i=0; $i < count($id_contratoA) ; $i++) { 
                $contratos = $id_contratoA[$i];
                $tipo_contrato = 'APOYO';
                $registrarVC = $vehiculoContrato->registrar($id_vehiculo, $contratos, $tipo_contrato);
            }  
        }
        


        /*REGISTRO DE VEHICULOS*/    

        if ($propietario_cambio == 1) {
            /*CAMBIO DE PROPIETARIO*/
            $actualizarV = $vehiculo->actualizarVehiculo($id_vehiculo, $placa, $marca, $modelo, $cant_pasajeros, $id_tipo_servicio, $id_tipo_vehiculo, $tipo_afiliacion, $empresa_afiliada, $nit_empresa_afiliada, $numero_movil, $numero_motor, $numero_chasis, $registrarPropietario, $telefono_propietario_nuevo, $fotocopia_cedula_propietario, $direccion_propietario_nuevo, $ciudad_propietario_nuevo, $tarjeta_operacion, $num_tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $num_licencia_transito, $fecha_vencimiento_lt, $soat, $num_soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $num_revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp, $poliza_contra, $num_poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $num_poliza_extra, $fecha_vencimiento_extra, $disp_velocidad, $fecha_exp_disp_velocidad, $tipo_propietario_nuevo, $propiedad_nuevo, $camara_comercio, $contrato_banco, $contrato_vinculacion, $fecha_exp_contrato_vinculacion, $ficha_tecnica_homologacion, $seguro_todo_riesgo, $num_seguro_todo_riesgo, $fecha_vencimiento_seguro_todo_riesgo, $hoja_vida, $rut, $poder_apoderado, $flota_propia, $id_empresa, $fecha_registro, $ciudad_registro, $num_puertas, $cilindraje, $tipo_carroceria, $tipo_combustible, $estado);
        }else{   
            /*ACTUALIZACIÓN DE PROPIETARIO*/
            $actualizarV = $vehiculo->actualizarVehiculo($id_vehiculo, $placa, $marca, $modelo, $cant_pasajeros, $id_tipo_servicio, $id_tipo_vehiculo, $tipo_afiliacion, $empresa_afiliada, $nit_empresa_afiliada, $numero_movil, $numero_motor, $numero_chasis, $id_propietario, $telefono_propietario, $fotocopia_cedula_propietario, $direccion_propietario, $ciudad_propietario, $tarjeta_operacion, $num_tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $num_licencia_transito, $fecha_vencimiento_lt, $soat, $num_soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $num_revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp, $poliza_contra, $num_poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $num_poliza_extra, $fecha_vencimiento_extra, $disp_velocidad, $fecha_exp_disp_velocidad, $tipo_propietario, $propiedad, $camara_comercio, $contrato_banco, $contrato_vinculacion, $fecha_exp_contrato_vinculacion, $ficha_tecnica_homologacion, $seguro_todo_riesgo, $num_seguro_todo_riesgo, $fecha_vencimiento_seguro_todo_riesgo, $hoja_vida, $rut, $poder_apoderado, $flota_propia, $id_empresa, $fecha_registro, $ciudad_registro, $num_puertas, $cilindraje, $tipo_carroceria, $tipo_combustible, $estado);
        }
        /*REGISTRAR BITACORAS DEL VEHICULO*/

            $id_modulo = 11;
            $id_registro = $id_vehiculo;
            $tipo_actividad = 'ACTUALIZAR';
            $columnas_modulo = '';
            $valores_antiguos = '';
            $valores_nuevos = '';
            $id_usuario = $_SESSION['id_usuario'];
            $fecha_actividad = date('Y-m-d');
            $hora_actividad = date('H:i:s');

            if ($marca != $marca_act) {
                $columnas_modulo .= 'marca | ';
                $valores_antiguos .= $marca_act . ' | ';
                $valores_nuevos .= $marca . ' | ';
            }

            if ($modelo != $modelo_act) {
                $columnas_modulo .= 'modelo | ';
                $valores_antiguos .= $modelo_act . ' | ';
                $valores_nuevos .= $modelo . ' | ';
            }

            if ($cant_pasajeros != $cant_pasajeros_act) {
                $columnas_modulo .= 'cant_pasajeros | ';
                $valores_antiguos .= $cant_pasajeros_act . ' | ';
                $valores_nuevos .= $cant_pasajeros . ' | ';
            }

            if ($numero_movil != $numero_movil_act) {
                $columnas_modulo .= 'numero_movil | ';
                $valores_antiguos .= $numero_movil_act . ' | ';
                $valores_nuevos .= $numero_movil . ' | ';
            }

            if ($numero_motor != $numero_motor_act) {
                $columnas_modulo .= 'numero_motor | ';
                $valores_antiguos .= $numero_motor_act . ' | ';
                $valores_nuevos .= $numero_motor . ' | ';
            }

            if ($numero_chasis != $numero_chasis_act) {
                $columnas_modulo .= 'numero_chasis | ';
                $valores_antiguos .= $numero_chasis_act . ' | ';
                $valores_nuevos .= $numero_chasis . ' | ';
            }

            if ($telefono_propietario != $telefono_propietario_act) {
                $columnas_modulo .= 'telefono_propietario | ';
                $valores_antiguos .= $telefono_propietario_act . ' | ';
                $valores_nuevos .= $telefono_propietario . ' | ';
            }

            if ($id_propietario != $registrarPropietario) {
                $columnas_modulo .= 'id_propietario | ';
                $valores_antiguos .= $id_propietario . ' | ';
                $valores_nuevos .= $registrarPropietario . ' | ';
            }

            if ($fotocopia_cedula_propietario != $act_fotocopia_cedula_propietario) {
                $columnas_modulo .= 'fotocopia_cedula_propietario | ';
                $valores_antiguos .= $act_fotocopia_cedula_propietario . ' | ';
                $valores_nuevos .= $fotocopia_cedula_propietario . ' | ';
            }

            if ($id_tipo_servicio != $id_tipo_servicio_act) {
                $columnas_modulo .= 'id_tipo_servicio | ';
                $valores_antiguos .= $id_tipo_servicio_act . ' | ';
                $valores_nuevos .= $id_tipo_servicio . ' | ';
            }

            if ($id_tipo_vehiculo != $id_tipo_vehiculo_act) {
                $columnas_modulo .= 'id_tipo_vehiculo | ';
                $valores_antiguos .= $id_tipo_vehiculo_act . ' | ';
                $valores_nuevos .= $id_tipo_vehiculo . ' | ';
            }

            if ($tarjeta_operacion != $act_tarjeta_operacion) {
                $columnas_modulo .= 'tarjeta_operacion | ';
                $valores_antiguos .= $act_tarjeta_operacion . ' | ';
                $valores_nuevos .= $tarjeta_operacion . ' | ';
            }

            if ($num_tarjeta_operacion != $num_tarjeta_operacion_act) {
                $columnas_modulo .= 'num_tarjeta_operacion | ';
                $valores_antiguos .= $num_tarjeta_operacion_act . ' | ';
                $valores_nuevos .= $num_tarjeta_operacion . ' | ';
            }

            if ($fecha_vencimiento_to != $fecha_vencimiento_to_act) {
                $columnas_modulo .= 'fecha_vencimiento_to | ';
                $valores_antiguos .= $id_tipo_vehiculo_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_to . ' | ';
            }

            if ($licencia_transito != $act_licencia_transito) {
                $columnas_modulo .= 'licencia_transito | ';
                $valores_antiguos .= $act_licencia_transito . ' | ';
                $valores_nuevos .= $licencia_transito . ' | ';
            }


            if ($fecha_vencimiento_lt != $fecha_vencimiento_lt_act) {
                $columnas_modulo .= 'fecha_vencimiento_lt | ';
                $valores_antiguos .= $fecha_vencimiento_lt_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_lt . ' | ';
            }

            if ($soat != $act_soat) {
                $columnas_modulo .= 'soat | ';
                $valores_antiguos .= $act_soat . ' | ';
                $valores_nuevos .= $soat . ' | ';
            }

            if ($fecha_vencimiento_soat != $fecha_vencimiento_soat_act) {
                $columnas_modulo .= 'fecha_vencimiento_soat | ';
                $valores_antiguos .= $fecha_vencimiento_soat_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_soat . ' | ';
            }

            if ($revision_tecnomecanica != $act_revision_tecnomecanica) {
                $columnas_modulo .= 'revision_tecnomecanica | ';
                $valores_antiguos .= $act_revision_tecnomecanica . ' | ';
                $valores_nuevos .= $revision_tecnomecanica . ' | ';
            }

            if ($fecha_vencimiento_rt != $fecha_vencimiento_rt_act) {
                $columnas_modulo .= 'fecha_vencimiento_rt | ';
                $valores_antiguos .= $fecha_vencimiento_rt_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_rt . ' | ';
            }

            if ($revision_preventiva != $act_revision_preventiva) {
                $columnas_modulo .= 'revision_preventiva | ';
                $valores_antiguos .= $act_revision_preventiva . ' | ';
                $valores_nuevos .= $revision_preventiva . ' | ';
            }

            if ($fecha_vencimiento_rp != $fecha_vencimiento_rp_act) {
                $columnas_modulo .= 'fecha_vencimiento_rp | ';
                $valores_antiguos .= $fecha_vencimiento_rp_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_rp . ' | ';
            }

            if ($poliza_contra != $act_poliza_contra) {
                $columnas_modulo .= 'poliza_contra | ';
                $valores_antiguos .= $act_poliza_contra . ' | ';
                $valores_nuevos .= $poliza_contra . ' | ';
            }


            if ($fecha_vencimiento_contra != $fecha_vencimiento_contra_act) {
                $columnas_modulo .= 'fecha_vencimiento_contra | ';
                $valores_antiguos .= $fecha_vencimiento_contra_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_contra . ' | ';
            }

            if ($poliza_extra != $act_poliza_extra) {
                $columnas_modulo .= 'poliza_extra | ';
                $valores_antiguos .= $act_poliza_extra . ' | ';
                $valores_nuevos .= $poliza_extra . ' | ';
            }

            if ($fecha_vencimiento_extra != $fecha_vencimiento_extra_act) {
                $columnas_modulo .= 'fecha_vencimiento_extra | ';
                $valores_antiguos .= $fecha_vencimiento_extra_act . ' | ';
                $valores_nuevos .= $fecha_vencimiento_extra . ' | ';
            }

            if ($disp_velocidad != $act_disp_velocidad) {
                $columnas_modulo .= 'disp_velocidad | ';
                $valores_antiguos .= $act_disp_velocidad . ' | ';
                $valores_nuevos .= $disp_velocidad . ' | ';
            }
            
            if ($fecha_exp_disp_velocidad != $act_fecha_exp_disp_velocidad) {
                $columnas_modulo .= 'fecha_exp_disp_velocidad | ';
                $valores_antiguos .= $act_fecha_exp_disp_velocidad . ' | ';
                $valores_nuevos .= $fecha_exp_disp_velocidad . ' | ';
            }

            if ($contrato_vinculacion != $act_contrato_vinculacion) {
                $columnas_modulo .= 'contrato_vinculacion | ';
                $valores_antiguos .= $act_contrato_vinculacion . ' | ';
                $valores_nuevos .= $contrato_vinculacion . ' | ';
            }

            if ($fecha_exp_contrato_vinculacion != $act_fecha_exp_contrato_vinculacion) {
                $columnas_modulo .= 'fecha_exp_contrato_vinculacion | ';
                $valores_antiguos .= $act_fecha_exp_contrato_vinculacion . ' | ';
                $valores_nuevos .= $fecha_exp_contrato_vinculacion . ' | ';
            }
            
            
            if ($ficha_tecnica_homologacion != $act_ficha_tecnica_homologacion) {
                $columnas_modulo .= 'ficha_tecnica_homologacion | ';
                $valores_antiguos .= $act_ficha_tecnica_homologacion . ' | ';
                $valores_nuevos .= $ficha_tecnica_homologacion . ' | ';
            }
            
        
            if ($seguro_todo_riesgo != $act_seguro_todo_riesgo) {
                $columnas_modulo .= 'seguro_todo_riesgo | ';
                $valores_antiguos .= $act_seguro_todo_riesgo . ' | ';
                $valores_nuevos .= $seguro_todo_riesgo . ' | ';
            }
            
        
            if ($fecha_vencimiento_seguro_todo_riesgo != $act_fecha_vencimiento_seguro_todo_riesgo) {
                $columnas_modulo .= 'fecha_vencimiento_seguro_todo_riesgo | ';
                $valores_antiguos .= $act_fecha_vencimiento_seguro_todo_riesgo . ' | ';
                $valores_nuevos .= $fecha_vencimiento_seguro_todo_riesgo . ' | ';
            }

            
            if ($hoja_vida != $act_hoja_vida) {
                $columnas_modulo .= 'hoja_vida | ';
                $valores_antiguos .= $act_hoja_vida . ' | ';
                $valores_nuevos .= $hoja_vida . ' | ';
            }
            
            
            if ($rut != $act_rut) {
                $columnas_modulo .= 'rut | ';
                $valores_antiguos .= $act_rut . ' | ';
                $valores_nuevos .= $rut . ' | ';
            }
            
            
            if ($poder_apoderado != $act_poder_apoderado) {
                $columnas_modulo .= 'poder_apoderado | ';
                $valores_antiguos .= $act_poder_apoderado . ' | ';
                $valores_nuevos .= $poder_apoderado . ' | ';
            }
            

            if ($flota_propia != $flota_propia_act) {
                $columnas_modulo .= 'flota_propia | ';
                $valores_antiguos .= $flota_propia_act . ' | ';
                $valores_nuevos .= $flota_propia . ' | ';
            }

            if ($id_empresa != $id_empresa_act) {
                $columnas_modulo .= 'id_empresa | ';
                $valores_antiguos .= $id_empresa_act . ' | ';
                $valores_nuevos .= $id_empresa . ' | ';
            }
            
            if ($fecha_registro != $fecha_registro_act) {
                $columnas_modulo .= 'fecha_registro | ';
                $valores_antiguos .= $fecha_registro_act . ' | ';
                $valores_nuevos .= $fecha_registro . ' | ';
            }
            
            if ($ciudad_registro != $ciudad_registro_act) {
                $columnas_modulo .= 'ciudad_registro | ';
                $valores_antiguos .= $ciudad_registro_act . ' | ';
                $valores_nuevos .= $ciudad_registro . ' | ';
            }
            
            if ($num_puertas != $num_puertas_act) {
                $columnas_modulo .= 'num_puertas | ';
                $valores_antiguos .= $num_puertas_act . ' | ';
                $valores_nuevos .= $num_puertas . ' | ';
            }
            
            if ($cilindraje != $cilindraje_act) {
                $columnas_modulo .= 'cilindraje | ';
                $valores_antiguos .= $cilindraje_act . ' | ';
                $valores_nuevos .= $cilindraje . ' | ';
            }
            
            if ($tipo_carroceria != $tipo_carroceria_act) {
                $columnas_modulo .= 'tipo_carroceria | ';
                $valores_antiguos .= $tipo_carroceria_act . ' | ';
                $valores_nuevos .= $tipo_carroceria . ' | ';
            }
            
            if ($tipo_combustible != $tipo_combustible_act) {
                $columnas_modulo .= 'tipo_combustible | ';
                $valores_antiguos .= $tipo_combustible_act . ' | ';
                $valores_nuevos .= $tipo_combustible . ' | ';
            }

            if ($columnas_modulo != '') {
                $bitacoraActualizacionVehiculos = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
            }


        //REFERENCIAS DEL PROPIETARIO 

        $referenciasPropietario = new ReferenciasPropietario();

        /*COMERCIAL*/
            if (($nombre_rc_act != $nombre_rc && $nombre_rc != '' && $nombre_rc_act != '') || ($telefono_rc_act != $telefono_rc && $telefono_rc != '' && $telefono_rc_act != '') || ($direccion_rc_act != $direccion_rc && $direccion_rc != '' && $direccion_rc_act != '')) {

                $id_referencia = $_POST['id_referencia_rc'];
                $tipo_referencia = 'COMERCIAL';
                $nombre_referencia = $nombre_rc;
                $telefono_referencia = $telefono_rc;
                $direccion_referencia = $direccion_rc;
                $estado = $_POST['estado_rc'];

                $actualizarReferencias = $referenciasPropietario->actualizar($id_referencia, $id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

            }else if (($nombre_rc_act == '' && $nombre_rc != '') && ($telefono_rc_act == '' && $telefono_rc != '') && ($direccion_rc_act == '' && $direccion_rc != '')) {

               /* echo "Ingrese";*/
                $tipo_referencia = 'COMERCIAL';
                $nombre_referencia = $nombre_rc;
                $telefono_referencia = $telefono_rc;
                $direccion_referencia = $direccion_rc;

                $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
            }

        /*LABORAL*/

            if (($nombre_rl_act != $nombre_rl && $nombre_rl != '' && $nombre_rl_act != '') || ($telefono_rl_act != $telefono_rl && $telefono_rl != '' && $telefono_rl_act != '') || ($direccion_rl_act != $direccion_rl && $direccion_rl != '' && $direccion_rl_act != '')) {

                $id_referencia = $_POST['id_referencia_rl'];
                $tipo_referencia = 'LABORAL';
                $nombre_referencia = $nombre_rl;
                $telefono_referencia = $telefono_rl;
                $direccion_referencia = $direccion_rl;
                $estado = $_POST['estado_rl'];

                $actualizarReferencias = $referenciasPropietario->actualizar($id_referencia, $id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

            }else if(($nombre_rl_act == ''  && $nombre_rl != '') && ($telefono_rl_act == ''  && $telefono_rl != '') && ($direccion_rl_act == '' && $direccion_rl != '')){

                $tipo_referencia = 'LABORAL';
                $nombre_referencia = $nombre_rl;
                $telefono_referencia = $telefono_rl;
                $direccion_referencia = $direccion_rl;

                $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
            }

        /*PERSONAL*/

            if (($nombre_rp_act != $nombre_rp && $nombre_rp != '' && $nombre_rp_act != '') || ($telefono_rp_act != $telefono_rp && $telefono_rp != '' && $telefono_rp_act != '') || ($direccion_rp_act != $direccion_rp && $direccion_rp != '' && $direccion_rp_act != '')) {

                $id_referencia = $_POST['id_referencia_rc'];
                $tipo_referencia = 'PERSONAL';
                $nombre_referencia = $nombre_rp;
                $telefono_referencia = $telefono_rp;
                $direccion_referencia = $direccion_rp;
                $estado = $_POST['estado_rp'];

                $actualizarReferencias = $referenciasPropietario->actualizar($id_referencia, $id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

            }else if(($nombre_rp_act == '' && $nombre_rp != '') && ($telefono_rp_act == '' && $telefono_rp != '') && ($direccion_rp_act == '' && $direccion_rp != '')){

                $tipo_referencia = 'PERSONAL';
                $nombre_referencia = $nombre_rp;
                $telefono_referencia = $telefono_rp;
                $direccion_referencia = $direccion_rp;

                $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
            }

        /*FAMILIAR*/
            if (($nombre_rf_act != $nombre_rf && $nombre_rf != '' && $nombre_rf_act == '') || ($telefono_rf_act != $telefono_rf && $telefono_rf != '' && $telefono_rf_act == '') || ($direccion_rf_act != $direccion_rf && $direccion_rf != '' && $direccion_rf_act == '')) {

                $id_referencia = $_POST['id_referencia_rf'];
                $tipo_referencia = 'FAMILIAR';
                $nombre_referencia = $nombre_rf;
                $telefono_referencia = $telefono_rf;
                $direccion_referencia = $direccion_rf;
                $estado = $_POST['estado_rf'];

                $actualizarReferencias = $referenciasPropietario->actualizar($id_referencia, $id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia, $estado);

            }else if(($nombre_rf_act == '' && $nombre_rf != '') && ($telefono_rf_act == '' && $telefono_rf != '') && ($direccion_rf_act == '' && $direccion_rf != '')){

                $tipo_referencia = 'FAMILIAR';
                $nombre_referencia = $nombre_rf;
                $telefono_referencia = $telefono_rf;
                $direccion_referencia = $direccion_rf;

                $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
            }

        
        $fotografiasVehiculo = new FotografiaVehiculo();

        if (($fotografia_frontal != $act_fotografia_frontal && $act_fotografia_frontal != '' && $fotografia_frontal != $act_fotografia_frontal) || ($fotografia_trasera != $act_fotografia_trasera && $act_fotografia_trasera != '' && $fotografia_trasera != $act_fotografia_trasera) || ($fotografia_lateral_izq != $act_fotografia_lateral_izq && $act_fotografia_lateral_izq != '' && $fotografia_lateral_izq != $act_fotografia_lateral_izq) || ($fotografia_lateral_der != $act_fotografia_lateral_der && $act_fotografia_lateral_der != '' && $fotografia_lateral_der != $act_fotografia_lateral_der)) {

            $actualziarFotografiasVehiculo = $fotografiasVehiculo->actualizar($id_fotografia, $id_vehiculo, $fotografia_frontal, $fotografia_trasera, $fotografia_lateral_izq, $fotografia_lateral_der);

        }elseif (($act_fotografia_frontal == '' && $fotografia_frontal != '') ||  ($act_fotografia_trasera == '' && $fotografia_trasera != '') || ($act_fotografia_lateral_izq == '' && $fotografia_lateral_izq != '') || ($act_fotografia_lateral_der == '' && $fotografia_lateral_der != '')) {

            $registrarFotografiasVehiculo = $fotografiasVehiculo->registrar($id_vehiculo, $fotografia_frontal, $fotografia_trasera, $fotografia_lateral_izq, $fotografia_lateral_der);
        }


        if($_POST['tipo_registroEmpConv'] != ''){
            $empresaConvenio = new Cliente_Convenio();
            $listarEmpresaConvenioPorVehiculo = $empresaConvenio->listarEmpresaConvenioPorVehiculo($id_vehiculo);

            $cantEmpVeh = count($listarEmpresaConvenioPorVehiculo);

            if($_POST['tipo_registroEmpConv'] == 'NR'){

                $razon_social = mb_strtoupper($_POST['razon_social']);
                $nit_cliente = $_POST['nit_cliente'];
                $direccion = mb_strtoupper($_POST['direccion']);
                $telefono = $_POST['telefono'];
                $nombre_rl = mb_strtoupper($_POST['nombre_rl']);
                $id_ciudad_rl = 0;
                $fecha_doc_rl = '0000-00-00';
                $id_ciudad = 0;
                $id_departamento = 0;
                $id_pais = 0;
                $doc_rl = $_POST['doc_rl'];
                $id_ciudad_exp = $_POST['id_ciudad_exp'];
         
                $registrarC = $empresaConvenio->registrar($razon_social, $nit_cliente, $direccion, $telefono, $nombre_rl, $id_ciudad_rl, $doc_rl, $fecha_doc_rl, $id_ciudad_exp, $id_ciudad, $id_departamento, $id_pais);

                $id_empresa_convenio = $registrarC;

            }else if($_POST['tipo_registroEmpConv'] == 'BA'){
                $id_empresa_convenio = $_POST['id_empresa_convenio'];
            }

            if ($cantEmpVeh == 0) {

                /* Registrar Actual*/
                $registrarClienteConvenioVehiculo = $empresaConvenio->registrarClienteConvenioVehiculo($id_vehiculo, $id_empresa_convenio);

            }else{

                /*Eliminar Existente*/
                $eliminarEmpresa = $empresaConvenio->eliminarClienteConvenioVehiculoExistente($id_vehiculo);

                /* Registrar Actual*/
                $registrarClienteConvenioVehiculo = $empresaConvenio->registrarClienteConvenioVehiculo($id_vehiculo, $id_empresa_convenio);

            }
        }

        

        echo "<script>alert('El vehiculo fue editado correctamente.'); window.location.href='../Vista/vehiculos.php';</script>";

?>
