<?php

include ("Sesion/autenticar.php");

require_once '../Modelo/ReferenciasPropietarioVehiculo.php';
require_once '../Modelo/FotografiaVehiculo.php';
require_once '../Modelo/Vehiculo-Contrato.php';
require_once '../Modelo/Cliente-Convenio.php';
require_once '../Modelo/Vehiculo.php';
require_once '../Modelo/Usuario.php';
require_once '../Modelo/General.php';

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

$vehiculo = new Vehiculo();
$usuario = new Usuario();

/* ------------------------------------ */

/* VALIDACIÓN EXISTENCIA VEHICULO*/

    $placa = strtoupper($_POST['placa']);
    $existeV = $vehiculo->listarPorPlaca($placa);
    $cant = count($existeV);

    if($cant > 0){

        echo "<script>
        alert('La placa ya se encuentra ingresada en el sistema');
        window.location.href = '../Vista/vehiculos.php';
        </script>";
        exit;

    }

/* FIN VALIDACIÓN EXISTENCIA VEHICULO */

/* ------------------------------------ */

/* REGISTRO Y VALIDACIÓN PROPIETARIO */
    
    if ($_POST['opcionProp'] == 'BA') {
        $registrarPropietario = $_POST['id_propietario'];
    } else if($_POST['opcionProp'] == 'RN') {

       $user = $_POST['cedula'];
        $clave = base64_encode($_POST['cedula']);

        $existe = $usuario->buscarUsuarioPorCedula($user);

        if(count($existe)<1){

            $correo_electronico = mb_strtoupper($_POST['correo_electronico']);
            $nombre = mb_strtoupper($_POST['nombre']);
            $fecha_ultimo_ingreso = date('Y-m-d H:i:s');
            $id_perfil = 2;
            
            $registrarPropietario = $usuario->registrarPropietario($user, $clave, $id_perfil, $correo_electronico, $nombre, $fecha_ultimo_ingreso);
        } else {
            $registrarPropietario = $existe[0]['id_usuario'];
        }

    } else {
        $registrarPropietario = $existe[0]['id_usuario'];
    }

/* FIN REGISTRO PROPIETARIO */

/* ------------------------------------ */

/* VARIABLES */
            
    $marca = mb_strtoupper($_POST['marca']);
    $modelo = $_POST['modelo'];
    $cant_pasajeros = $_POST['cant_pasajeros'];
    $numero_movil = $_POST['movil'];
    
    if($numero_movil == ''){
        $numero_movil = 0;
    }
    
    $numero_motor = mb_strtoupper($_POST['numero_motor']);
    $numero_chasis = mb_strtoupper($_POST['numero_chasis']);
    $id_propietario = $registrarPropietario;
    $telefono_propietario = $_POST['telefono_propietario'];
    $fotocopia_cedula_propietario = $_FILES['fotocopia_cedula_propietario']['name'];
    $direccion_propietario = $_POST['direccion_propietario'];
    $ciudad_propietario = $_POST['ciudad_propietario'];
    $id_tipo_servicio = $_POST['id_tipo_servicio'];
    $id_tipo_vehiculo = $_POST['id_tipo_vehiculo'];
    $tipo_afiliacion = $_POST['tipo_afiliacion'];
    if($tipo_afiliacion == 'AFILIADO'){
        $empresa_afiliada = $_POST['empresa_afiliada'];
        $nit_empresa_afiliada = $_POST['nit_empresa_afiliada'];
    } else {
        $empresa_afiliada = $_POST['otra_empresa_afiliada'];
        $nit_empresa_afiliada = $_POST['nit_otra_empresa_afiliada'];
    }

    $tarjeta_operacion = $_FILES['tarjeta_operacion']['name'];
    $num_tarjeta_operacion = $_POST['num_tarjeta_operacion'];
    $fecha_vencimiento_to = $_POST['fecha_vencimiento_to'];
    
    if($fecha_vencimiento_to == ''){
        $fecha_vencimiento_to = '0000-00-00';
    }
    
    $licencia_transito = $_FILES['licencia_transito']['name'];
    $num_licencia_transito = $_POST['num_licencia_transito'];
    $fecha_vencimiento_lt = $_POST['fecha_vencimiento_lt'];
    
    if($fecha_vencimiento_lt == ''){
        $fecha_vencimiento_lt = '0000-00-00';
    }
    
    $soat = $_FILES['soat']['name'];
    $num_soat = $_POST['num_soat'];
    $fecha_vencimiento_soat = $_POST['fecha_vencimiento_soat'];
    
    if($fecha_vencimiento_soat == ''){
        $fecha_vencimiento_soat = '0000-00-00';
    }
    
    $revision_tecnomecanica = $_FILES['revision_tecnomecanica']['name'];
    $num_revision_tecnomecanica = $_POST['num_revision_tecnomecanica'];
    $fecha_vencimiento_rt = $_POST['fecha_vencimiento_rt'];
    
    if($fecha_vencimiento_rt == ''){
        $fecha_vencimiento_rt = '0000-00-00';
    }
    
    $revision_preventiva = $_FILES['revision_preventiva']['name'];
    $fecha_vencimiento_rp = $_POST['fecha_vencimiento_rp'];
    
    if($fecha_vencimiento_rp == ''){
        $fecha_vencimiento_rp = '0000-00-00';
    }
    
    $poliza_contra = $_FILES['poliza_contra']['name'];
    $num_poliza_contra = $_POST['num_poliza_contra'];
    $fecha_vencimiento_contra = $_POST['fecha_vencimiento_contra'];
    
    if($fecha_vencimiento_contra == ''){
        $fecha_vencimiento_contra = '0000-00-00';
    }
    
    $poliza_extra = $_FILES['poliza_extra']['name'];
    $num_poliza_extra = $_POST['num_poliza_extra'];
    $fecha_vencimiento_extra = $_POST['fecha_vencimiento_extra'];
    
    if($fecha_vencimiento_extra == ''){
        $fecha_vencimiento_extra = '0000-00-00';
    }

    $disp_velocidad = $_FILES['disp_velocidad']['name'];
    $fecha_exp_disp_velocidad = $_POST['fecha_exp_disp_velocidad'];
    
    if($fecha_exp_disp_velocidad == ''){
        $fecha_exp_disp_velocidad = '0000-00-00';
    }

    $tipo_propietario = $_POST['tipo_propietario'];
    $propiedad = $_POST['propiedad'];
    $camara_comercio = $_FILES['camara_comercio']['name'];
    $contrato_banco = $_FILES['contrato_banco']['name'];

    $contrato_vinculacion = '';

    if (isset($_FILES['contrato_vinculacion']['name'])) {
        $contrato_vinculacion = $_FILES['contrato_vinculacion']['name'];
    }
    $fecha_exp_contrato_vinculacion = $_POST['fecha_exp_contrato_vinculacion'];
    
    if($fecha_exp_contrato_vinculacion == ''){
        $fecha_exp_contrato_vinculacion = '0000-00-00';
    }

    $ficha_tecnica_homologacion = $_FILES['ficha_tecnica_homologacion']['name'];
    $seguro_todo_riesgo = $_FILES['seguro_todo_riesgo']['name'];
    $num_seguro_todo_riesgo = $_POST['num_seguro_todo_riesgo'];
    $fecha_vencimiento_seguro_todo_riesgo = $_POST['fecha_vencimiento_seguro_todo_riesgo'];

    if($fecha_vencimiento_seguro_todo_riesgo == ''){
        $fecha_vencimiento_seguro_todo_riesgo = '0000-00-00';
    }

    $hoja_vida = $_FILES['hoja_vida']['name'];
    $rut = $_FILES['rut']['name'];
    $poder_apoderado = $_FILES['poder_apoderado']['name'];

    $fecha_registro = $_POST['fecha_registro'];

    if ($fecha_registro == '') {
        $fecha_registro = '0000-00-00';
    }

    $ciudad_registro = $_POST['ciudad_registro'];
    $num_puertas = $_POST['num_puertas'];

    if ($num_puertas == '') {
        $num_puertas = 0;
    }

    $cilindraje = $_POST['cilindraje'];

    if ($cilindraje == '') {
        $cilindraje = 0;
    }

    $tipo_carroceria = $_POST['tipo_carroceria'];
    $tipo_combustible = $_POST['tipo_combustible'];

    /*REFERENCIAS*/

        /*PERSONALES*/
            $nombre_rp = $_POST['nombre_rp'];
            $telefono_rp = $_POST['telefono_rp'];
            $direccion_rp = $_POST['direccion_rp'];
        /*LABORALES*/
            $nombre_rl = $_POST['nombre_rl'];
            $telefono_rl = $_POST['telefono_rl'];
            $direccion_rl = $_POST['direccion_rl'];
        /*COMERCIALES*/
            $nombre_rc = $_POST['nombre_rc'];
            $telefono_rc = $_POST['telefono_rc'];
            $direccion_rc = $_POST['direccion_rc'];
        /*FAMILIARES*/
            $nombre_rf = $_POST['nombre_rf'];
            $telefono_rf = $_POST['telefono_rf'];
            $direccion_rf = $_POST['direccion_rf'];


    /*FOTOGRAFIAS*/

        $fotografia_frontal = $_FILES['fotografia_frontal']['name'];
        $fotografia_trasera = $_FILES['fotografia_trasera']['name'];
        $fotografia_lateral_izq = $_FILES['fotografia_lateral_izq']['name'];
        $fotografia_lateral_der = $_FILES['fotografia_lateral_der']['name'];
    
    /* FLOTA PROPIA*/

        $flota_propia = $_POST['flota_propia'];
        if($flota_propia == 'S'){
            $id_empresa = $_POST['id_empresa'];
        } else {
            $id_empresa = 0;
        }

/* ----------- FIN VARIABLES -----------*/

/* ------------------------------------ */

/* ------------ DOCUMENTOS ------------ */

    if (isset($tarjeta_operacion) || isset($licencia_transito) || isset($soat) || isset($revision_tecnomecanica) || isset($revision_preventiva) || isset($poliza_contra) || isset($poliza_extra) || isset($fotocopia_cedula_propietario) || isset($camara_comercio) || isset($contrato_banco) || isset($contrato_vinculacion) || isset($fotografia_frontal) || isset($fotografia_trasera) || isset($fotografia_lateral_der) || isset($fotografia_lateral_izq) ) {

        //tarjeta de operacion
            if (!empty($_FILES['tarjeta_operacion']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_tarjeta_operacion .'-'. $_FILES['tarjeta_operacion']['name'];
                $tarjeta_operacion = $num_tarjeta_operacion .'-'. $tarjeta_operacion;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['tarjeta_operacion']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        //Licencia de transito
            if (!empty($_FILES['licencia_transito']['name'])) {

               $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_licencia_transito .'-'. $_FILES['licencia_transito']['name'];
                $licencia_transito = $num_licencia_transito .'-'. $licencia_transito;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['licencia_transito']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);

            }

        //soat
            if (!empty($_FILES['soat']['name'])) {

               $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_soat .'-'. $_FILES['soat']['name'];
                $soat = $num_soat .'-'. $soat;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['soat']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
            }

        //Revision tecnomecanica
            if (!empty($_FILES['revision_tecnomecanica']['name'])) {

                
                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_revision_tecnomecanica .'-'.  $_FILES['revision_tecnomecanica']['name'];
                $revision_tecnomecanica = $num_revision_tecnomecanica .'-'. $revision_tecnomecanica;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['revision_tecnomecanica']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        //Revision preventiva
            if (!empty($_FILES['revision_preventiva']['name'])) {

               $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['revision_preventiva']['name'];
                $revision_preventiva = $fecha.'-'.$revision_preventiva;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['revision_preventiva']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
            }

        //Polizas Contractual
            if (!empty($_FILES['poliza_contra']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_poliza_contra .'-'.  $_FILES['poliza_contra']['name'];
                $poliza_contra = $num_poliza_contra .'-'. $poliza_contra;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['poliza_contra']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //Polizas Extra Contractual
            if (!empty($_FILES['poliza_extra']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_poliza_extra .'-'.  $_FILES['poliza_extra']['name'];
                $poliza_extra = $num_poliza_extra .'-'. $poliza_extra;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['poliza_extra']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //FOTOCOPIA CEDULA DEL PROPIETARIO
            if (!empty($_FILES['fotocopia_cedula_propietario']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotocopia_cedula_propietario']['name'];
                $fotocopia_cedula_propietario = $fecha.'-'.$fotocopia_cedula_propietario;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotocopia_cedula_propietario']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //DISPOSITIVO DE VELOCIDAD
            if (!empty($_FILES['disp_velocidad']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['disp_velocidad']['name'];
                $disp_velocidad = $fecha.'-'.$disp_velocidad;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['disp_velocidad']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

         //INSPECCION VEHICULAR
            if (!empty($_FILES['ins_vehicular']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['ins_vehicular']['name'];
                $ins_vehicular = $fecha.'-'.$ins_vehicular;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['ins_vehicular']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //CAMARA DE COMERCIO
            if (!empty($_FILES['camara_comercio']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['camara_comercio']['name'];
                $camara_comercio = $fecha.'-'.$camara_comercio;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['camara_comercio']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //CONTRATO LEASING O FIDUCIA

            if (!empty($_FILES['contrato_banco']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['contrato_banco']['name'];
                $contrato_banco = $fecha.'-'.$contrato_banco;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['contrato_banco']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //CONTRATO VINCULACION
            if (!empty($_FILES['contrato_vinculacion']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['contrato_vinculacion']['name'];
                $contrato_vinculacion = $fecha.'-'.$contrato_vinculacion;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['contrato_vinculacion']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
        
        //FICHA TECNICA DE HOMOLOGACIÓN
            if (!empty($_FILES['ficha_tecnica_homologacion']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['ficha_tecnica_homologacion']['name'];
                $ficha_tecnica_homologacion = $fecha .'-'. $ficha_tecnica_homologacion;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['ficha_tecnica_homologacion']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
            
        //SEGURO TODO RIESGO
            if (!empty($_FILES['seguro_todo_riesgo']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $num_seguro_todo_riesgo .'-'. $_FILES['seguro_todo_riesgo']['name'];
                $seguro_todo_riesgo = $num_seguro_todo_riesgo .'-'. $seguro_todo_riesgo;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['seguro_todo_riesgo']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
            
        // HOJA DE VIDA
            if (!empty($_FILES['hoja_vida']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['hoja_vida']['name'];
                $hoja_vida = $fecha.'-'.$hoja_vida;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['hoja_vida']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
            
        // RUT
            if (!empty($_FILES['rut']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['rut']['name'];
                $rut = $fecha .'-'. $rut;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['rut']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
            
        // PODER APODERADO
            if (!empty($_FILES['poder_apoderado']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['poder_apoderado']['name'];
                $poder_apoderado = $fecha .'-'. $poder_apoderado;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['poder_apoderado']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }    

        //FOTOGRAFIA FRONTAL
            if (!empty($_FILES['fotografia_frontal']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotografia_frontal']['name'];
                $fotografia_frontal = $fecha.'-'.$fotografia_frontal;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotografia_frontal']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //FOTOGRAFIA TRASERA
            if (!empty($_FILES['fotografia_trasera']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotografia_trasera']['name'];
                $fotografia_trasera = $fecha.'-'.$fotografia_trasera;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotografia_trasera']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //FOTOGRAFIA LATERAL IZQUIERDA
            if (!empty($_FILES['fotografia_lateral_izq']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotografia_lateral_izq']['name'];
                $fotografia_lateral_izq = $fecha.'-'.$fotografia_lateral_izq;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotografia_lateral_izq']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }

        //FOTOGRAFIA LATERAL DERECHA
            if (!empty($_FILES['fotografia_lateral_der']['name'])) {

                $carpeta = '../Documentos/Vehiculos'. '/'. $placa;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotografia_lateral_der']['name'];
                $fotografia_lateral_der = $fecha.'-'.$fotografia_lateral_der;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotografia_lateral_der']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);        
            }
    }

/* ----------- FIN DOCUMENTOS ----------- */

/* -------------------------------------- */

/* -------- REGISTRO DE VEHICULOS ------- */
        
        $registrarV = $vehiculo->registrarVehiculo($placa, $marca, $modelo, $cant_pasajeros, $id_tipo_servicio, $id_tipo_vehiculo, $tipo_afiliacion, $empresa_afiliada, $nit_empresa_afiliada, $numero_movil, $numero_motor, $numero_chasis, $id_propietario, $telefono_propietario, $fotocopia_cedula_propietario, $direccion_propietario, $ciudad_propietario, $tarjeta_operacion, $num_tarjeta_operacion, $fecha_vencimiento_to, $licencia_transito, $num_licencia_transito, $fecha_vencimiento_lt, $soat, $num_soat, $fecha_vencimiento_soat, $revision_tecnomecanica, $num_revision_tecnomecanica, $fecha_vencimiento_rt, $revision_preventiva, $fecha_vencimiento_rp, $poliza_contra, $num_poliza_contra, $fecha_vencimiento_contra, $poliza_extra, $num_poliza_extra, $fecha_vencimiento_extra, $disp_velocidad, $fecha_exp_disp_velocidad, $tipo_propietario, $propiedad, $camara_comercio, $contrato_banco, $contrato_vinculacion, $fecha_exp_contrato_vinculacion, $ficha_tecnica_homologacion, $seguro_todo_riesgo, $num_seguro_todo_riesgo, $fecha_vencimiento_seguro_todo_riesgo, $hoja_vida, $rut, $poder_apoderado, $flota_propia, $id_empresa, $fecha_registro, $ciudad_registro, $num_puertas, $cilindraje, $tipo_carroceria, $tipo_combustible);
        
        $id_vehiculo = $registrarV;

        $id_modulo = 11;
        $id_registro = $id_vehiculo;
        $tipo_actividad = 'REGISTRAR';
        $columnas_modulo = ' id_vehiculo | placa | modelo | marca | cant_pasajeros | id_tipo_servicio | id_tipo_vehiculo | tipo_afiliacion | empresa_afiliada | nit_empresa_afiliada | numero_movil | numero_motor | numero_chasis | id_propietario | telefono_propietario | fotocopia_cedula_propietario | direccion_propietario | ciudad_propietario | tarjeta_operacion | num_tarjeta_operacion | fecha_vencimiento_to | licencia_transito | num_licencia_transito | fecha_vencimiento_lt | soat | num_soat | fecha_vencimiento_soat | revision_tecnomecanica | num_revision_tecnomecanica | fecha_vencimiento_rt | revision_preventiva | fecha_vencimiento_rp | poliza_contra | num_poliza_contra | fecha_vencimiento_contra | poliza_extra | num_poliza_extra | fecha_vencimiento_extra | disp_velocidad | fecha_exp_disp_velocidad | tipo_propietario | propiedad | camara_comercio | contrato_banco | contrato_vinculacion | fecha_exp_contrato_vinculacion | ficha_tecnica_homologacion | seguro_todo_riesgo | num_seguro_todo_riesgo | fecha_vencimiento_seguro_todo_riesgo | hoja_vida | rut | poder_apoderado | flota_propia | id_empresa | fecha_registro | ciudad_registro | num_puertas | cilindraje | tipo_carroceria | tipo_combustible | estado';

        $valores_antiguos =  '';
        $valores_nuevos =  $id_vehiculo . ' | ' . $placa . ' | ' . $modelo . ' | ' .  $marca . ' | ' . $cant_pasajeros . ' | ' . $id_tipo_servicio . ' | ' . $id_tipo_vehiculo . ' | ' . $tipo_afiliacion . ' | ' . $empresa_afiliada . ' | ' . $nit_empresa_afiliada . ' | ' . $numero_movil . ' | ' . $numero_motor . ' | ' . $numero_chasis . ' | ' . $id_propietario . ' | ' . $telefono_propietario . ' | ' . $hoja_vida_propietario . ' | ' . $fotocopia_cedula_propietario . ' | ' . $tarjeta_operacion . ' | ' .  $num_tarjeta_operacion . ' | ' .  $fecha_vencimiento_to . ' | ' . $licencia_transito . ' | ' . $num_licencia_transito . ' | ' .  $fecha_vencimiento_lt . ' | ' . $soat . ' | ' . $num_soat . ' | ' . $fecha_vencimiento_soat . ' | ' . $revision_tecnomecanica . ' | ' . $num_revision_tecnomecanica . ' | ' . $fecha_vencimiento_rt . ' | ' . $revision_preventiva . ' | ' . $fecha_vencimiento_rp . ' | ' . $poliza_contra . ' | ' . $num_poliza_contra . ' | ' . $fecha_vencimiento_contra . ' | ' . $poliza_extra . ' | ' . $num_poliza_extra . ' | ' . $fecha_vencimiento_extra . ' | ' . $disp_velocidad . ' | ' . $fecha_exp_disp_velocidad . ' | ' .  $tipo_propietario . ' | ' . $propiedad . ' | ' . $camara_comercio . ' | ' . $contrato_banco . ' | ' . $contrato_vinculacion . ' | ' . $fecha_exp_contrato_vinculacion  . ' | ' .  $ficha_tecnica_homologacion  . ' | ' .  $seguro_todo_riesgo  . ' | ' . $num_seguro_todo_riesgo  . ' | ' .  $fecha_vencimiento_seguro_todo_riesgo  . ' | ' .  $hoja_vida  . ' | ' .  $rut  . ' | ' .  $poder_apoderado  . ' | ' .  $flota_propia . ' | ' . $id_empresa . ' | ' . $fecha_registro . ' | ' . $ciudad_registro . ' | ' . $num_puertas . ' | ' . $cilindraje . ' | ' . $tipo_carroceria . ' | ' . $tipo_combustible . ' | ' . 1; 
        $id_usuario = $_SESSION['id_usuario'];
        $fecha_actividad = date('Y-m-d');
        $hora_actividad = date('H:i:s');

        $bitacoraRegistroVehiculos = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

        /*CONTRATOS VEHICULOS*/

        $vehiculoContrato = new Vehiculo_Contrato();

        $id_contratoB = $_POST['id_contratoB'];
        $id_contratoA = $_POST['id_contratoA'];

        if (count($id_contratoB) > 0) {
            $tipo_contrato = 'BASE';
            $registrarVC = $vehiculoContrato->registrar($id_vehiculo, $id_contratoB, $tipo_contrato);
        }
        
        if (count($id_contratoA) > 0) {
            for ($i=0; $i < count($id_contratoA); $i++) {   
                $contratos = $id_contratoA[$i];
                $tipo_contrato = 'APOYO';
                $registrarVC = $vehiculoContrato->registrar($id_vehiculo, $contratos, $tipo_contrato);
            }
        }

        /* --------------------------- */

        $referenciasPropietario = new ReferenciasPropietario();
        
        if ($nombre_rc != '' || $telefono_rc != '' || $direccion_rc != '') {
            
            $tipo_referencia = 'COMERCIAL';
            $nombre_referencia = $nombre_rc;
            $telefono_referencia = $telefono_rc;
            $direccion_referencia = $direccion_rc;

            $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }
        
        if($nombre_rl != '' || $telefono_rl != '' || $direccion_rl != ''){

            $tipo_referencia = 'LABORAL';
            $nombre_referencia = $nombre_rl;
            $telefono_referencia = $telefono_rl;
            $direccion_referencia = $direccion_rl;

            $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

        if($nombre_rf != '' || $telefono_rf !='' || $direccion_rf != ''){

            $tipo_referencia = 'FAMILIAR';
            $nombre_referencia = $nombre_rf;
            $telefono_referencia = $telefono_rf;
            $direccion_referencia = $direccion_rf;

            $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

        if($nombre_rp != '' || $telefono_rp != '' || $direccion_rp != ''){

            $tipo_referencia = 'PERSONAL';
            $nombre_referencia = $nombre_rp;
            $telefono_referencia = $telefono_rp;
            $direccion_referencia = $direccion_rp;

            $registrarReferencias = $referenciasPropietario->registrar($id_vehiculo, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }

        $id_registro;

        $fotografiaVehiculo = new FotografiaVehiculo();
        $registrarFotografias = $fotografiaVehiculo->registrar($id_vehiculo, $fotografia_frontal, $fotografia_trasera, $fotografia_lateral_izq, $fotografia_lateral_der);

        /* EMPRESA CONVENIO */
       
            $empresaConvenio = new Cliente_Convenio();

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

            $registrarClienteConvenioVehiculo = $empresaConvenio->registrarClienteConvenioVehiculo($id_vehiculo, $id_empresa_convenio);


            header('Location: ../Vista/vehiculos.php');

?>