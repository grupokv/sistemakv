<?php
include ("Sesion/autenticar.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Vehiculo-Conductor.php");
require_once("../Modelo/General.php");
require_once '../Modelo/referenciasConductor.php';


$conductor = new Conductor();

/*CONDUCTOR*/

$nombre_conductor = mb_strtoupper($_POST['nombre_conductor']);
$numero_documento_conductor = $_POST['numero_documento_conductor'];
$correo_electronico = $_POST['correo_electronico'];
$fecha_nacimiento_conductor = $_POST['fecha_nacimiento_conductor'];
if($fecha_nacimiento_conductor == ''){
	$fecha_nacimiento_conductor = '0000-00-00';
}
$fotocopia_documento = $_FILES['fotocopia_documento']['name'];
$fotocopia_licencia = $_FILES['fotocopia_licencia']['name'];
$categoria_licencia = $_POST['categoria_licencia'];
$num_licencia = $_POST['num_licencia'];
$fecha_vencimiento_licencia = $_POST['fecha_vencimiento_licencia'];
if($fecha_vencimiento_licencia == ''){
	$fecha_vencimiento_licencia = '0000-00-00';
}
$direccion = $_POST['direccion'];
$genero = $_POST['genero'];
$grupo_sanguineo = $_POST['grupo_sanguineo'];
$estado_civil = $_POST['estado_civil'];
$telefono1 = $_POST['telefono1'];
$telefono2 = $_POST['telefono2'];
$telefono3 = $_POST['telefono3'];
$pago_pactado = $_POST['pago_pactado'];
$certificados_laborales = $_FILES['certificados_laborales']['name'];
$certificados_estudios = $_FILES['certificados_estudios']['name'];
$certificados_cursos = $_FILES['certificados_cursos']['name'];
$libreta_militar = $_FILES['libreta_militar']['name'];
$examen_medico = $_FILES['examen_medico']['name'];
$fecha_expedicion_examen_medico = $_POST['fecha_expedicion_examen_medico'];
if($fecha_expedicion_examen_medico == ''){
	$fecha_expedicion_examen_medico = '0000-00-00';
}
$planilla_ss = '';
$hoja_vida = $_FILES['hoja_vida']['name'];
$fotografia_conductor = $_FILES['fotografia_conductor']['name'];

/*INICIO NUEVOS CAMPOS*/
$procuraduria = $_FILES['procuraduria']['name'];
$fecha_procuraduria = $_POST['fecha_procuraduria'];
if($fecha_procuraduria == ''){ $fecha_procuraduria = '0000-00-00'; }
$contraloria = $_FILES['contraloria']['name'];
$fecha_contraloria = $_POST['fecha_contraloria'];
if($fecha_contraloria == ''){ $fecha_contraloria = '0000-00-00'; }
$personeria = $_FILES['personeria']['name'];
$fecha_personeria = $_POST['fecha_personeria'];
if($fecha_personeria == ''){ $fecha_personeria = '0000-00-00'; }
$simit = $_FILES['simit']['name'];
$fecha_simit = $_POST['fecha_simit'];
if($fecha_simit == ''){ $fecha_simit = '0000-00-00'; }
$policia = $_FILES['policia']['name'];
$fecha_policia = $_POST['fecha_policia'];
if($fecha_policia == ''){ $fecha_policia = '0000-00-00'; }
$rut = $_FILES['rut']['name'];
$vacunas = $_FILES['vacunas']['name'];
$contrato_trabajo = $_FILES['contrato_trabajo']['name'];
$fecha_contrato = $_POST['fecha_contrato'];
if($fecha_contrato == ''){ $fecha_contrato = '0000-00-00'; }
/*------ FIN NUEVOS CAMPOS --------*/
/* --------------------------------*/
/*INICIO PLANILLAS SEGURIDAD SOCIAL*/

$anno = $_POST['anno'];
$ene = $_FILES['planilla_1']['name'];
$feb = $_FILES['planilla_2']['name'];
$mar = $_FILES['planilla_3']['name'];
$abr = $_FILES['planilla_4']['name'];
$may = $_FILES['planilla_5']['name'];
$jun = $_FILES['planilla_6']['name'];
$jul = $_FILES['planilla_7']['name'];
$ago = $_FILES['planilla_8']['name'];
$sep = $_FILES['planilla_9']['name'];
$oct = $_FILES['planilla_10']['name'];
$nov = $_FILES['planilla_11']['name'];
$dic = $_FILES['planilla_12']['name'];

/*FIN PLANILLAS SEGURIDAD SOCIAL*/

/*USUARIO*/
$usuario = $_POST['numero_documento_conductor'];
$clave = base64_encode($_POST['numero_documento_conductor']);
$correo_electronico = mb_strtoupper($_POST['correo_electronico']);
$nombre = mb_strtoupper($_POST['nombre_conductor']);
$fecha_ultimo_ingreso = date('Y-m-d H:i:s');

date_default_timezone_set('America/Bogota');
$fecha = date('YmdHis');

if (isset($fotocopia_documento) || isset($fotocopia_licencia) || isset($certificados_laborales) || isset($certificados_estudios) || isset($certificados_cursos) || isset($libreta_militar)  || isset($examen_medico) || isset($planilla_ss) || isset($fotografia_conductor)) {


        /*FOTOCOPIA DEL DOCUMENTO*/
            if (!empty($_FILES['fotocopia_documento']['name'])) {

                $carpeta = $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'. $_FILES['fotocopia_documento']['name'];
                $fotocopia_documento = $fecha.'-'.$fotocopia_documento;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotocopia_documento']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
            }

        /*FOTOCOPIA DE LA LICENCIA*/
            if (!empty($_FILES['fotocopia_licencia']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotocopia_licencia']['name'];
                $fotocopia_licencia = $fecha.'-'.$fotocopia_licencia;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotocopia_licencia']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        /*CERTIFICADOS LABORALES*/
            if (!empty($_FILES['certificados_laborales']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['certificados_laborales']['name'];
                $certificados_laborales = $fecha.'-'.$certificados_laborales;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['certificados_laborales']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }


        /*CERTIFICADOS ESTUDIOS*/
            if (!empty($_FILES['certificados_estudios']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['certificados_estudios']['name'];
                $certificados_estudios = $fecha.'-'.$certificados_estudios;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['certificados_estudios']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        /*CERTIFICADOS CURSOS*/
            if (!empty($_FILES['certificados_cursos']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['certificados_cursos']['name'];
                $certificados_cursos = $fecha.'-'.$certificados_cursos;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['certificados_cursos']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        /*LIBRETA MILITAR*/
            if (!empty($_FILES['libreta_militar']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['libreta_militar']['name'];
                $libreta_militar = $fecha.'-'.$libreta_militar;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['libreta_militar']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        /*EXAMEN MEDICO*/
            if (!empty($_FILES['examen_medico']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['examen_medico']['name'];
                $examen_medico = $fecha.'-'.$examen_medico;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['examen_medico']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        $planilla_ss = '';

        /*FOTOGRAFIA CONDUCTOR*/
            if (!empty($_FILES['fotografia_conductor']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotografia_conductor']['name'];
                $fotografia_conductor = $fecha.'-'.$fotografia_conductor;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['fotografia_conductor']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }
			
		/*HOJA DE VIDA*/
            if (!empty($_FILES['hoja_vida']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['hoja_vida']['name'];
                $hoja_vida = $fecha.'-'.$hoja_vida;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['hoja_vida']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }

        /*RUT*/
            if (!empty($_FILES['rut']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['rut']['name'];
                $rut = $fecha.'-'.$rut;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['rut']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
                
            }
			
		/*VACUNAS*/
            if (!empty($_FILES['vacunas']['name'])) {

                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['vacunas']['name'];
                $vacunas = $fecha .'-'. $vacunas;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['vacunas']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
            }
			
		/*CONTRATO DE TRABAJO*/
            if (!empty($_FILES['contrato_trabajo']['name'])) {

                
                $carpeta = '../Documentos/Conductores'. '/'. $numero_documento_conductor;
                $ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['vacunas']['name'];
                $vacunas = $fecha .'-'. $vacunas;

                if (!file_exists($carpeta)) {
                    mkdir($carpeta, 0757, true);
                }

                $ruta_temp = $_FILES['vacunas']['tmp_name'];
                move_uploaded_file($ruta_temp, $ruta);
			
            }
            
        /*SEGURIDAD SOCIAL*/
            
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

					if($i == 1){ 
					    $ene = $archivoSS;
					} else if($i == 2){ 
					    $feb = $archivoSS; 
					} else if($i == 3){ 
					    $mar = $archivoSS; 
					} else if($i == 4){ 
					    $abr = $archivoSS; 
					} else if($i == 5){ 
					    $may = $archivoSS; 
					} else if($i == 6){ 
					    $jun = $archivoSS; 
					} else if($i == 7){ 
					    $jul = $archivoSS; 
					} else if($i == 8){ 
					    $ago = $archivoSS; 
					} else if($i == 9){ 
					    $sep = $archivoSS; 
					} else if($i == 10){ 
					    $oct = $archivoSS; 
					} else if($i == 11){ 
					    $nov = $archivoSS; 
					} else if($i == 12){ 
					    $dic = $archivoSS; 
					}

                } else {
                    echo "<script>
                    alert('El tipo de archivo en planilla de seguridad social no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
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
                $policia = "";
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
                $procuraduria = "";
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
                $contraloria = "";
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
                $personeria = "";
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
                $simit = "";
            }
			
            /*Registrar al conductor como usuario*/
            $objU = new Usuario();

            $existe = $objU->buscarUsuarioPorCedula($usuario);
            if(count($existe) < 1){
                $id_perfil = 3;
                $registrarUsuCon = $objU->registrarConductor($usuario, $clave, $id_perfil, $correo_electronico, $nombre, $fecha_ultimo_ingreso);
            } else {
                if($existe[0]['id_perfil'] == 2){
                    $id_perfil = 8;
                    $objU->actualizarPerfil($existe[0]['id_usuario'],$id_perfil);
                }
            }

            

        $existeConductor = $conductor->buscarConductorPorDocumento($numero_documento_conductor);

        if (count($existeConductor) < 1) {
            /*Registrar al conductor*/
            $registrar = $conductor->registrar($nombre_conductor, $numero_documento_conductor, $correo_electronico, $fecha_nacimiento_conductor, $fotocopia_documento, $fotocopia_licencia, $categoria_licencia, $num_licencia, $fecha_vencimiento_licencia, $direccion, $genero, $grupo_sanguineo, $estado_civil, $telefono1, $telefono2, $telefono3, $pago_pactado, $certificados_laborales, $certificados_estudios, $certificados_cursos, $libreta_militar, $examen_medico, $fecha_expedicion_examen_medico, $planilla_ss, $fotografia_conductor, $hoja_vida, $procuraduria, $fecha_procuraduria, $contraloria, $fecha_contraloria, $personeria, $fecha_personeria, $simit, $fecha_simit, $policia, $fecha_policia, $rut, $vacunas, $contrato_trabajo, $fecha_contrato);
            
        }else{
            echo "<script>
                alert('El conductor ya ha sido registrado anteriormente.');
                history.back();
                </script>";
            exit();
        }
        
        $planillas = $conductor->buscarPlanillasPorConductor($registrar,$anno);
        
		if(count($planillas) == 0){
			$registrar_ss = $conductor->registrarSS($registrar,$anno,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
		} else {
			$registrar_ss = $conductor->actualizarSS($registrar,$anno,$ene,$feb,$mar,$abr,$may,$jun,$jul,$ago,$sep,$oct,$nov,$dic);
		}

        /*BITACORA*/

        $vehiculo = $_POST['id_vehiculo'];
        $id_conductor = $registrar;

        $id_modulo = 12;
        $id_registro = $id_conductor;
        $tipo_actividad = 'REGISTRAR';
        $columnas_modulo = 'id_conductor | nombre_conductor | numero_documento_conductor | fecha_nacimiento_conductor | fotocopia_documento | fotocopia_licencia | categoria_licencia | num_licencia | fecha_vencimiento_licencia | direccion | genero | grupo_sanguineo | estado_civil | telefono1 | telefono2 | telefono3 | pago_pactado | certificados_laborales | certificados_estudios | certificados_cursos | libreta_militar | examen_medico | planilla_ss | fotografia_conductor | estado';
        $valores_antiguos = ''; 
        $valores_nuevos = $id_conductor . ' | ' . $nombre_conductor . ' | ' . $numero_documento_conductor . ' | ' . $fecha_nacimiento_conductor  . ' | ' . $fotocopia_documento . ' | ' . $fotocopia_licencia . ' | ' . $categoria_licencia . ' | '. $num_licencia . ' | ' . $fecha_vencimiento_licencia . ' | ' . $direccion . '' . $genero . ' | ' . $grupo_sanguineo . ' | ' . $estado_civil . ' | ' . $telefono1 . ' | ' . $telefono2 . ' | ' . $telefono3 . ' | ' .  $pago_pactado . ' | ' . $certificados_laborales . ' | ' . $certificados_estudios . ' | ' .  $certificados_cursos . ' | ' .  $libreta_militar . ' | ' .  $examen_medico . ' | ' .  $planilla_ss . ' | ' . $fotografia_conductor . ' | ' . 1;

        $id_usuario = $_SESSION['id_usuario'];
        $fecha_actividad = date('Y-m-d');
        $hora_actividad = date('H:i:s');

        $bitacoraRegistroUsuario = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
                                                              $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
                                                              $hora_actividad);


        $vehiculoConductor = new Vehiculo_Conductor();
        /*Conductores - has - vehiculos*/
        
        for ($i=0; $i < count($_POST['id_vehiculo']) ; $i++) { 
            $id_vehiculo = $vehiculo[$i];
            $registrarVC = $vehiculoConductor->registrar($id_vehiculo, $id_conductor);
        }

        

         $referenciasConductor = new ReferenciasConductor();


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
        

        if ($nombre_rc != '' || $telefono_rc != '' || $direccion_rc != '') {
            
            $tipo_referencia = 'COMERCIAL';
            $nombre_referencia = $nombre_rc;
            $telefono_referencia = $telefono_rc;
            $direccion_referencia = $direccion_rc;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);

        }


        if($nombre_rl != '' || $telefono_rl != '' || $direccion_rl != ''){

            $tipo_referencia = 'LABORAL';
            $nombre_referencia = $nombre_rl;
            $telefono_referencia = $telefono_rl;
            $direccion_referencia = $direccion_rl;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);

        }

        if($nombre_rf != '' || $telefono_rf !='' || $direccion_rf != ''){

            $tipo_referencia = 'FAMILIAR';
            $nombre_referencia = $nombre_rf;
            $telefono_referencia = $telefono_rf;
            $direccion_referencia = $direccion_rf;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);

        }

        if($nombre_rp != '' || $telefono_rp != '' || $direccion_rp != ''){

            $tipo_referencia = 'PERSONAL';
            $nombre_referencia = $nombre_rp;
            $telefono_referencia = $telefono_rp;
            $direccion_referencia = $direccion_rp;

            $registrarReferencias = $referenciasConductor->registrar($id_conductor, $tipo_referencia, $nombre_referencia, $telefono_referencia, $direccion_referencia);
        }
        
        header('Location: ../Vista/conductores.php');

        } 
?>