<?php 
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Vehiculo-Conductor.php");
require_once("../Modelo/General.php");
require_once("../Modelo/referenciasConductor.php");
require_once("../Modelo/Usuario.php");

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

/*INICIO NUEVOS CAMPOS*/
$procuraduria = $_FILES['procuraduria']['name'];
$act_procuraduria = $_POST['act_procuraduria'];
$fecha_procuraduria = $_POST['fecha_procuraduria'];
$act_fecha_procuraduria = $_POST['act_fecha_procuraduria'];
if(($fecha_procuraduria == '')and($act_fecha_procuraduria == '')){ 
	$fecha_procuraduria = '0000-00-00'; 
} else if(($fecha_procuraduria == '')and($act_fecha_procuraduria != '')){
	$fecha_procuraduria = $act_fecha_procuraduria;
}
$contraloria = $_FILES['contraloria']['name'];
$act_contraloria = $_POST['act_contraloria'];
$fecha_contraloria = $_POST['fecha_contraloria'];
$act_fecha_contraloria = $_POST['act_fecha_contraloria'];
if(($fecha_contraloria == '')and($act_fecha_contraloria == '')){ 
	$fecha_contraloria = '0000-00-00'; 
} else if(($fecha_contraloria == '')and($act_fecha_contraloria != '')){
	$fecha_contraloria = $act_fecha_contraloria;
}
$personeria = $_FILES['personeria']['name'];
$act_personeria = $_POST['act_personeria'];
$fecha_personeria = $_POST['fecha_personeria'];
$act_fecha_personeria = $_POST['act_fecha_personeria'];
if(($fecha_personeria == '')and($act_fecha_personeria == '')){ 
	$fecha_personeria = '0000-00-00'; 
} else if(($fecha_personeria == '')and($act_fecha_personeria != '')){
	$fecha_personeria = $act_fecha_personeria;
}
$simit = $_FILES['simit']['name'];
$act_simit = $_POST['act_simit'];
$fecha_simit = $_POST['fecha_simit'];
$act_fecha_simit = $_POST['act_fecha_simit'];
if(($fecha_simit == '')and($act_fecha_simit == '')){ 
	$fecha_simit = '0000-00-00'; 
} else if(($fecha_simit == '')and($act_fecha_simit != '')){
	$fecha_simit = $act_fecha_simit;
}
$policia = $_FILES['policia']['name'];
$act_policia = $_POST['act_policia'];
$fecha_policia = $_POST['fecha_policia'];
$act_fecha_policia = $_POST['act_fecha_policia'];
if(($fecha_policia == '')and($act_fecha_policia == '')){ 
	$fecha_policia = '0000-00-00'; 
} else if(($fecha_policia == '')and($act_fecha_policia != '')){
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
if(($fecha_contrato == '')and($act_fecha_contrato == '')){ 
	$fecha_contrato = '0000-00-00'; 
} else if(($fecha_contrato == '')and($act_fecha_contrato != '')){
	$fecha_contrato = $act_fecha_contrato;
}
/*FIN NUEVOS CAMPOS*/

/*INICIO PLANILLAS SEGURIDAD SOCIAL*/
$anno = $_POST['anno'];
$ene = $_FILES['planilla_1']['name'];
$act_ene = $_POST['act_ene'];
$feb = $_FILES['planilla_2']['name'];
$act_feb = $_POST['act_feb'];
$mar = $_FILES['planilla_3']['name'];
$act_mar = $_POST['act_mar'];
$abr = $_FILES['planilla_4']['name'];
$act_abr = $_POST['act_abr'];
$may = $_FILES['planilla_5']['name'];
$act_may = $_POST['act_may'];
$jun = $_FILES['planilla_6']['name'];
$act_jun = $_POST['act_jun'];
$jul = $_FILES['planilla_7']['name'];
$act_jul = $_POST['act_jul'];
$ago = $_FILES['planilla_8']['name'];
$act_ago = $_POST['act_ago'];
$sep = $_FILES['planilla_9']['name'];
$act_sep = $_POST['act_sep'];
$oct = $_FILES['planilla_10']['name'];
$act_oct = $_POST['act_oct'];
$nov = $_FILES['planilla_11']['name'];
$act_nov = $_POST['act_nov'];
$dic = $_FILES['planilla_12']['name'];
$act_dic = $_POST['act_dic'];
/*FIN PLANILLAS SEGURIDAD SOCIAL*/

$correo_electronico = $_POST['correo_electronico'];
$correo_electronico_act = $_POST['correo_electronico_act'];

/*REFERENCIAS*/

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


$usuario = new Usuario();
$actualizarCorreo = $usuario->actualizarCorreoConductor($numero_documento_conductor, $correo_electronico);


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

        $objVehiculo = new Vehiculo();
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

       

    if (isset($fotocopia_documento) || isset($fotocopia_licencia) || isset($certificados_estudios) || isset($certificados_cursos) || isset($certificados_laborales) || isset($libreta_militar) || isset($examen_medico) || isset($planilla_ss) || isset($fotografia_conductor)) {


        /*FOTOCOPIA DEL DOCUMENTO*/
            if (!empty($_FILES['fotocopia_documento']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotocopia_documento']['name'], $_FILES['fotocopia_documento']['size']);
                if($valido == 1){

                    $fotocopia_documento = quitar_simbolos($_FILES['fotocopia_documento']['name']);
                    $fotocopia_documento = $fecha . '-'. $fotocopia_documento;                    
                    $carpeta = "../Documentos/Conductores". '/'. $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $fotocopia_documento;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotocopia_documento']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotocopia de documento no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $fotocopia_documento = $_POST['act_fotocopia_documento'];
            }

        /*FOTOCOPIA DE LA LICENCIA*/
            if (!empty($_FILES['fotocopia_licencia']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotocopia_licencia']['name'], $_FILES['fotocopia_licencia']['size']);
                if($valido == 1){

                    $fotocopia_licencia = quitar_simbolos($_FILES['fotocopia_licencia']['name']);
                    $fotocopia_licencia = $fecha . '-'. $fotocopia_licencia;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $fotocopia_licencia;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotocopia_licencia']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotocopia de licencia no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $fotocopia_licencia = $_POST['fotocopia_licencia_act'];
            }

        /*CERTIFICADOS ESTUDIOS*/
            if (!empty($_FILES['certificados_estudios']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['certificados_estudios']['name'], $_FILES['certificados_estudios']['size']);
                if($valido == 1){

                    $certificados_estudios = quitar_simbolos($_FILES['certificados_estudios']['name']);
                    $certificados_estudios = $fecha . '-'. $certificados_estudios;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $certificados_estudios;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['certificados_estudios']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados de estudio no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $certificados_estudios = $act_certificados_estudios;
            }

        /*CERTIFICADOS CURSOS*/
            
            if (!empty($_FILES['certificados_cursos']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['certificados_cursos']['name'], $_FILES['certificados_cursos']['size']);
                if($valido == 1){

                    $certificados_cursos = quitar_simbolos($_FILES['certificados_cursos']['name']);
                    $certificados_cursos = $fecha . '-'. $certificados_cursos;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $certificados_cursos;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['certificados_cursos']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados de cursos no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $certificados_cursos = $act_certificados_cursos;
            }

        /*CERTIFICADOS LABORALES*/
            if (!empty($_FILES['certificados_laborales']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['certificados_laborales']['name'], $_FILES['certificados_laborales']['size']);
                if($valido == 1){

                    $certificados_laborales = quitar_simbolos($_FILES['certificados_laborales']['name']);
                    $certificados_laborales = $fecha . '-'. $certificados_laborales;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $certificados_laborales;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['certificados_laborales']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados laborales no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $certificados_laborales = $act_certificados_laborales;
            }

        /*LIBRETA MILITAR*/
            if (!empty($_FILES['libreta_militar']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['libreta_militar']['name'], $_FILES['libreta_militar']['size']);
                if($valido == 1){

                    $libreta_militar = quitar_simbolos($_FILES['libreta_militar']['name']);
                    $libreta_militar = $fecha . '-'. $libreta_militar;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $libreta_militar;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['libreta_militar']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados laborales no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $libreta_militar = $act_libreta_militar;
            }
        
        /*EXAMEN MEDICO*/
            if (!empty($_FILES['examen_medico']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['examen_medico']['name'], $_FILES['examen_medico']['size']);
                if($valido == 1){

                    $examen_medico = quitar_simbolos($_FILES['examen_medico']['name']);
                    $examen_medico = $fecha . '-'. $examen_medico;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $examen_medico;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['examen_medico']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados laborales no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $examen_medico = $act_examen_medico;
            }
        
        /*PLANILLA SEGURIDAD SOCIAL*/
            if (!empty($_FILES['planilla_ss']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['planilla_ss']['name'], $_FILES['planilla_ss']['size']);
                if($valido == 1){

                    $planilla_ss = quitar_simbolos($_FILES['planilla_ss']['name']);
                    $planilla_ss = $fecha . '-'. $planilla_ss;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $planilla_ss;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['planilla_ss']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en certificados laborales no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $planilla_ss = $act_planilla_ss;
            }

        /*FOTOGRAFIA CONDUCTOR*/
            if (!empty($_FILES['fotografia_conductor']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['fotografia_conductor']['name'], $_FILES['fotografia_conductor']['size']);
                if($valido == 1){

                    $fotografia_conductor = quitar_simbolos($_FILES['fotografia_conductor']['name']);
                    $fotografia_conductor = $fecha . '-'. $fotografia_conductor;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $fotografia_conductor;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['fotografia_conductor']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en fotografia del conductor no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $fotografia_conductor = $act_fotografia_conductor;
            }
			
			/*HOJA DE VIDA*/
            if (!empty($_FILES['hoja_vida']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['hoja_vida']['name'], $_FILES['hoja_vida']['size']);
                if($valido == 1){

                    $hoja_vida = quitar_simbolos($_FILES['hoja_vida']['name']);
                    $hoja_vida = $fecha . '-'. $hoja_vida;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $hoja_vida;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['hoja_vida']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en hoja de vida del conductor no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $hoja_vida = $act_hoja_vida;
            }
			
			/*RUT*/
            if (!empty($_FILES['rut']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['rut']['name'], $_FILES['rut']['size']);
                if($valido == 1){

                    $rut = quitar_simbolos($_FILES['rut']['name']);
                    $rut = $fecha . '-'. $rut;                    
                    $carpeta = "../Documentos/Conductores". '/'. $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $rut;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['rut']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en rut no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }  
            } else {
                $rut = $_POST['act_rut'];
            }
			
			/*VACUNAS*/
            if (!empty($_FILES['vacunas']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['vacunas']['name'], $_FILES['vacunas']['size']);
                if($valido == 1){

                    $vacunas = quitar_simbolos($_FILES['vacunas']['name']);
                    $vacunas = $fecha . '-'. $vacunas;                    
                    $carpeta = "../Documentos/Conductores". '/'. $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $vacunas;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['vacunas']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en carnet de vacunas no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }  
            } else {
                $vacunas = $_POST['act_vacunas'];
            }
			
			/*CONTRATO DE TRABAJO*/
            if (!empty($_FILES['contrato_trabajo']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['contrato_trabajo']['name'], $_FILES['contrato_trabajo']['size']);
                if($valido == 1){

                    $contrato_trabajo = quitar_simbolos($_FILES['contrato_trabajo']['name']);
                    $contrato_trabajo = $fecha . '-'. $contrato_trabajo;                    
                    $carpeta = "../Documentos/Conductores". '/'. $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $contrato_trabajo;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['contrato_trabajo']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en contrato de trabajo no es valido o el archivo excede el tamaño permitido');
                    history.back();
                    </script>";
                    exit();
                }  
            } else {
                $contrato_trabajo = $_POST['act_contrato_trabajo'];
            }
			
			for($i = 1;$i <= 12; $i++){
			
			if (!empty($_FILES['planilla_'.$i]['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['planilla_'.$i]['name'], $_FILES['planilla_'.$i]['size']);
                if($valido == 1){

                    $archivoSS = quitar_simbolos($_FILES['planilla_'.$i]['name']);
                    $archivoSS = $fecha . '-'. $archivoSS;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $archivoSS;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['planilla_'.$i]['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

					if($i == 1){ $ene = $archivoSS; } else if($i == 2){ $feb = $archivoSS; } else if($i == 3){ $mar = $archivoSS; } else if($i == 4){ $abr = $archivoSS; } else if($i == 5){ $may = $archivoSS; } else if($i == 6){ $jun = $archivoSS; } else if($i == 7){ $jul = $archivoSS; } else if($i == 8){ $ago = $archivoSS; } else if($i == 9){ $sep = $archivoSS; } else if($i == 10){ $oct = $archivoSS; } else if($i == 11){ $nov = $archivoSS; } else if($i == 12){ $dic = $archivoSS; }

                } else {
                    echo "<script>
                    alert('El tipo de archivo en planilla de seguridad social no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                if($i == 1){ $ene = $act_ene; } else if($i == 2){ $feb = $act_feb; } else if($i == 3){ $mar = $act_mar; } else if($i == 4){ $abr = $act_abr; } else if($i == 5){ $may = $act_may; } else if($i == 6){ $jun = $act_jun; } else if($i == 7){ $jul = $act_jul; } else if($i == 8){ $ago = $act_ago; } else if($i == 9){ $sep = $act_sep; } else if($i == 10){ $oct = $act_oct; } else if($i == 11){ $nov = $act_nov; } else if($i == 12){ $dic = $act_dic; }
            }
			}
			
			 /*POLICIA*/
            if (!empty($_FILES['policia']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['policia']['name'], $_FILES['policia']['size']);
                if($valido == 1){

                    $policia = quitar_simbolos($_FILES['policia']['name']);
                    $policia = $fecha . '-'. $policia;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $policia;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['policia']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en antecedentes policia no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $policia = $act_policia;
            }
			
			 /*PROCURADURIA*/
            if (!empty($_FILES['procuraduria']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['procuraduria']['name'], $_FILES['procuraduria']['size']);
                if($valido == 1){

                    $procuraduria = quitar_simbolos($_FILES['procuraduria']['name']);
                    $procuraduria = $fecha . '-'. $procuraduria;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $procuraduria;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['procuraduria']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en antecedentes procuraduria no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $procuraduria = $act_procuraduria;
            }
			
			 /*CONTRALORIA*/
            if (!empty($_FILES['contraloria']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['contraloria']['name'], $_FILES['contraloria']['size']);
                if($valido == 1){

                    $contraloria = quitar_simbolos($_FILES['contraloria']['name']);
                    $contraloria = $fecha . '-'. $contraloria;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $contraloria;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['contraloria']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en antecedentes contraloria no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $contraloria = $act_contraloria;
            }
			
			/*PERSONERIA*/
            if (!empty($_FILES['personeria']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['personeria']['name'], $_FILES['personeria']['size']);
                if($valido == 1){

                    $personeria = quitar_simbolos($_FILES['personeria']['name']);
                    $personeria = $fecha . '-'. $personeria;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $personeria;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['personeria']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en antecedentes personeria no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $personeria = $act_personeria;
            }
			
			/*SIMIT*/
            if (!empty($_FILES['simit']['name'])) {

                $valido = 0;
                $valido = validar_archivo($_FILES['simit']['name'], $_FILES['simit']['size']);
                if($valido == 1){

                    $simit = quitar_simbolos($_FILES['simit']['name']);
                    $simit = $fecha . '-'. $simit;                    
                    $carpeta = "../Documentos/Conductores". '/' . $numero_documento_conductor;
                    $ruta = $carpeta .'/'. $simit;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['simit']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en antecedentes simit no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $simit = $act_simit;
            }


        $conductor = new Conductor();
        $registrar = $conductor->actualizarConductor($id_conductor, $nombre_conductor, $numero_documento_conductor, $correo_electronico, $fecha_nacimiento_conductor, $fotocopia_documento, $fotocopia_licencia, $categoria_licencia, $num_licencia,  $fecha_vencimiento_licencia, $direccion, $genero , $grupo_sanguineo, $estado_civil, $telefono1, $telefono2, $telefono3, $pago_pactado, $certificados_laborales, $certificados_estudios, $certificados_cursos, $libreta_militar, $examen_medico, $fecha_expedicion_examen_medico, $planilla_ss, $fotografia_conductor, $hoja_vida, $procuraduria, $fecha_procuraduria, $contraloria, $fecha_contraloria, $personeria, $fecha_personeria, $simit, $fecha_simit, $policia, $fecha_policia, $rut, $vacunas, $contrato_trabajo, $fecha_contrato, $estado);

        $planillas = $conductor->buscarPlanillasPorConductor($id_conductor,$anno);
		if(count($planillas) == 0){
			$registrar_ss = $conductor->registrarSS($id_conductor,$anno,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
		} else {
			$registrar_ss = $conductor->actualizarSS($id_conductor,$anno,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
		}

        if ($columnas_modulo != '') {
            $bitacoraActualizacionVehiculoPorConductor = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, 
                                                                            $columnas_modulo, $valores_antiguos, $valores_nuevos, 
                                                                            $id_usuario, $fecha_actividad, $hora_actividad);
        }

              

        $vehiculoConductor = new Vehiculo_Conductor();
        

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
            $bitacoraActualizacionConductor = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, 
                                                                        $columnas_modulo, $valores_antiguos, $valores_nuevos,
                                                                        $id_usuario, $fecha_actividad, $hora_actividad);
        }




        $eliminarVCPorId = $vehiculoConductor->eliminarPorId($id_conductor);
        $vehiculo = $_POST['id_vehiculo'];
        
        if ($_POST['id_vehiculo'] != '') {
            for ($i=0; $i < count($_POST['id_vehiculo']) ; $i++) { 
                $id_vehiculo = $vehiculo[$i];
                $registrarVC = $vehiculoConductor->registrar($id_vehiculo, $id_conductor);
            } 
        }

        $referenciasConductor = new ReferenciasConductor();

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


        header("Location: ../Vista/conductores.php");



    }


 ?>