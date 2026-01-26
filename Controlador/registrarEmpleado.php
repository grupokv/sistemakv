<?php
date_default_timezone_set('America/Bogota');
include ("Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");
require_once("../Modelo/General.php");

$empleado = new Empleado();

$fecha = date('YmdHis');
$hoy = date('Y-m-d H:i:s');

$nombres = mb_strtoupper($_POST['nombres']);
$apellidos = mb_strtoupper($_POST['apellidos']);
$num_documento = $_POST['num_documento'];
$correo_electronico = $_POST['correo_electronico'];
$fecha_nac = $_POST['fecha_nacimiento'];
if($fecha_nac == ''){
	$fecha_nac = '0000-00-00';
}
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$celular = $_POST['celular'];
$empresa = $_POST['empresa'];
$cargo = $_POST['cargo'];
$eps = $_POST['eps'];
$arl = $_POST['arl'];
$pension = $_POST['pension'];
$cesantias = $_POST['cesantias'];
$caja_compensacion = $_POST['caja_compensacion'];

$tipo_contrato = $_POST['tipo_contrato'];
$fecha_contrato = $_POST['fecha_contrato'];
$fecha_final_contrato = $_POST['fecha_final_contrato'];
if($fecha_contrato == ''){
	$fecha_contrato = '0000-00-00';
}

if($tipo_contrato == 'Indefinido'){
	$fecha_final_contrato = '0000-00-00';
}
if($fecha_final_contrato == ''){
	$fecha_final_contrato = '0000-00-00';
}
$contrato = $_FILES['contrato']['name'];
$fotocopia_documento = $_FILES['fotocopia_documento']['name'];
$hoja_vida = $_FILES['hoja_vida']['name'];
$examen_medico = $_FILES['examen_medico']['name'];
$fecha_examen = $_POST['fecha_examen'];
if($fecha_examen == ''){
	$fecha_examen = '0000-00-00';
}
$actualizacion_datos = $_FILES['actualizacion_datos']['name'];
$fecha_actualizacion = $_POST['fecha_actualizacion'];
if($fecha_actualizacion == ''){
	$fecha_actualizacion = '0000-00-00';
}
$manual_funciones = $_FILES['manual_funciones']['name'];

$afiliacion_eps = $_FILES['afiliacion_eps']['name'];
$afiliacion_arl = $_FILES['afiliacion_arl']['name'];
$afiliacion_caja = $_FILES['afiliacion_caja']['name'];

$cant_otros = $_POST['cant_otros'];
$nombre_archivo = $_POST['nombre_archivo'];
$archivos = $_FILES['archivos'];

$procuraduria = $_FILES['procuraduria']['name'];
$contraloria = $_FILES['contraloria']['name'];
$personeria = $_FILES['personeria']['name'];
$simit = $_FILES['simit']['name'];
$policia = $_FILES['policia']['name'];

$cant_estudios = $_POST['cant_estudios'];
$titulo = $_POST['titulo'];
$universidad = $_POST['universidad'];
$nivel = $_POST['nivel'];
$fecha_grado = $_POST['fecha_grado'];
$diploma = $_FILES['diploma'];

$cant_experiencias = $_POST['cant_experiencias'];
$empresa_exp = $_POST['empresa_exp'];
$fecha_inicio = $_POST['fecha_inicio'];
$fecha_fin = $_POST['fecha_fin'];
$cargo_exp = $_POST['cargo_exp'];
$telefono_exp = $_POST['telefono_exp'];
$jefe_exp = $_POST['jefe_exp'];
$certificado_exp = $_FILES['certificado_exp'];

$cant_cursos = $_POST['cant_cursos'];
$nombre_curso = $_POST['nombre_curso'];
$intensidad = $_POST['intensidad'];
$institucion = $_POST['institucion'];
$fecha_curso = $_POST['fecha_curso'];
$certificado_cur = $_FILES['certificado_cur'];

if(($nombres != '')and($apellidos != '')and($num_documento != '')){

	$buscar = $empleado->buscarEmpleadoActivoPorCedula($num_documento);
	if(count($buscar) < 1){
		
		if (!empty($_FILES['contrato']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['contrato']['name'];
			$contrato = $fecha .'-'. $contrato;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['contrato']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$contrato = '';
		}
		
		if (!empty($_FILES['fotocopia_documento']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['fotocopia_documento']['name'];
			$fotocopia_documento = $fecha .'-'. $fotocopia_documento;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['fotocopia_documento']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$fotocopia_documento = '';
		}
		
		if (!empty($_FILES['hoja_vida']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['hoja_vida']['name'];
			$hoja_vida = $fecha .'-'. $hoja_vida;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['hoja_vida']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$hoja_vida = '';
		}
		
		if (!empty($_FILES['examen_medico']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['examen_medico']['name'];
			$examen_medico = $fecha .'-'. $examen_medico;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['examen_medico']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$examen_medico = '';
		}
		
		if (!empty($_FILES['actualizacion_datos']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['actualizacion_datos']['name'];
			$actualizacion_datos = $fecha .'-'. $actualizacion_datos;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['actualizacion_datos']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$actualizacion_datos = '';
		}
		
		if (!empty($_FILES['manual_funciones']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['manual_funciones']['name'];
			$manual_funciones = $fecha .'-'. $manual_funciones;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['manual_funciones']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$manual_funciones = '';
		}
		
		if (!empty($_FILES['afiliacion_eps']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['afiliacion_eps']['name'];
			$afiliacion_eps = $fecha .'-'. $afiliacion_eps;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['afiliacion_eps']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$afiliacion_eps = '';
		}
		
		if (!empty($_FILES['afiliacion_arl']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['afiliacion_arl']['name'];
			$afiliacion_arl = $fecha .'-'. $afiliacion_arl;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['afiliacion_arl']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$afiliacion_arl = '';
		}
		
		if (!empty($_FILES['afiliacion_caja']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['afiliacion_caja']['name'];
			$afiliacion_caja = $fecha .'-'. $afiliacion_caja;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['afiliacion_caja']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$afiliacion_caja = '';
		}
		
		if (!empty($_FILES['policia']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['policia']['name'];
			$policia = $fecha .'-'. $policia;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['policia']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$policia = '';
		}
		
		if (!empty($_FILES['procuraduria']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['procuraduria']['name'];
			$procuraduria = $fecha .'-'. $procuraduria;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['procuraduria']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$procuraduria = '';
		}
		
		if (!empty($_FILES['contraloria']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['contraloria']['name'];
			$contraloria = $fecha .'-'. $contraloria;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['contraloria']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$contraloria = '';
		}
		
		if (!empty($_FILES['personeria']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['personeria']['name'];
			$personeria = $fecha .'-'. $personeria;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['personeria']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$personeria = '';
		}
		
		if (!empty($_FILES['simit']['name'])) {                
			$carpeta = '../Documentos/Empleados/'. $num_documento;
			$ruta = $carpeta .'/'. $fecha.'-'.  $_FILES['simit']['name'];
			$simit = $fecha .'-'. $simit;
			if (!file_exists($carpeta)) {
				mkdir($carpeta, 0757, true);
			}
			$ruta_temp = $_FILES['simit']['tmp_name'];
			move_uploaded_file($ruta_temp, $ruta);
		} else {
			$simit = '';
		}
		$estado = 1;
		
		$registrar = $empleado->registrar($nombres, $apellidos, $num_documento, $hoja_vida, $correo_electronico, $fotocopia_documento, $contrato, $examen_medico, $empresa, $contraloria, $procuraduria, $policia, $simit, $personeria, $actualizacion_datos, $manual_funciones, $fecha_nac, $direccion, $telefono, $celular, $cargo, $fecha_contrato, $eps, $arl, $pension, $cesantias, $caja_compensacion, $afiliacion_eps, $afiliacion_arl, $afiliacion_caja, $fecha_examen, $fecha_actualizacion, $tipo_contrato, $fecha_final_contrato, $estado, $hoy);
		
		if($cant_estudios > 0){
			for($i=0;$i<$cant_estudios;$i++){
				if(($titulo[$i] != '')and($universidad[$i] != '')and($nivel[$i] != '')){
					if($fecha_grado[$i] != ''){
						$fec_grado = $fecha_grado[$i];
					} else {
						$fec_grado = '0000-00-00';
					}
					if (!empty($diploma['name'][$i])) {                
						$carpeta = '../Documentos/Empleados/'. $num_documento;
						$ruta = $carpeta .'/'. $fecha.'-'.  $diploma['name'][$i];
						$archivo = $fecha .'-'. $diploma['name'][$i];
						if (!file_exists($carpeta)) {
							mkdir($carpeta, 0757, true);
						}
						$ruta_temp = $diploma['tmp_name'][$i];
						move_uploaded_file($ruta_temp, $ruta);
					} else {
						$archivo = '';
					}
					$registrarEstudio = $empleado->registrarEstudio($titulo[$i], $universidad[$i], $nivel[$i], $fec_grado, $archivo, $registrar);
				}
			}
		}
		
		if($cant_experiencias > 0){
			for($i=0;$i<$cant_experiencias;$i++){
				if(($empresa_exp[$i] != '')and($cargo_exp[$i] != '')and($telefono_exp[$i] != '')){
					if($fecha_inicio[$i] != ''){
						$fechai = $fecha_inicio[$i];
					} else {
						$fechai = '0000-00-00';
					}
					if($fecha_fin[$i] != ''){
						$fechaf = $fecha_fin[$i];
					} else {
						$fechaf = '0000-00-00';
					}
					if (!empty($certificado_exp['name'][$i])) {                
						$carpeta = '../Documentos/Empleados/'. $num_documento;
						$ruta = $carpeta .'/'. $fecha.'-'.  $certificado_exp['name'][$i];
						$archivo = $fecha .'-'. $certificado_exp['name'][$i];
						if (!file_exists($carpeta)) {
							mkdir($carpeta, 0757, true);
						}
						$ruta_temp = $certificado_exp['tmp_name'][$i];
						move_uploaded_file($ruta_temp, $ruta);
					} else {
						$archivo = '';
					}
					$registrarExperiencia = $empleado->registrarExperiencia($empresa_exp[$i], $fechai, $fechaf, $cargo_exp[$i], $telefono_exp[$i], $jefe_exp[$i], $archivo, $registrar);
				}
			}
		}
		
		if($cant_cursos > 0){
			for($i=0;$i<$cant_cursos;$i++){
				if(($nombre_curso[$i] != '')and($institucion[$i] != '')){
					if($fecha_curso[$i] != ''){
						$fec_curso = $fecha_curso[$i];
					} else {
						$fec_curso = '0000-00-00';
					}
					if (!empty($certificado_cur['name'][$i])) {                
						$carpeta = '../Documentos/Empleados/'. $num_documento;
						$ruta = $carpeta .'/'. $fecha.'-'.  $certificado_cur['name'][$i];
						$archivo = $fecha .'-'. $certificado_cur['name'][$i];
						if (!file_exists($carpeta)) {
							mkdir($carpeta, 0757, true);
						}
						$ruta_temp = $certificado_cur['tmp_name'][$i];
						move_uploaded_file($ruta_temp, $ruta);
					} else {
						$archivo = '';
					}
					$registrarCurso = $empleado->registrarCurso($nombre_curso[$i], $intensidad[$i], $institucion[$i], $archivo, $fec_curso, $registrar);
				}
			}
		}
		
		if($cant_otros > 0){
			for($i=0;$i<$cant_otros;$i++){
				if($nombre_archivo[$i] != ''){
					if (!empty($archivos['name'][$i])) {                
						$carpeta = '../Documentos/Empleados/'. $num_documento;
						$ruta = $carpeta .'/'. $fecha.'-'.  $archivos['name'][$i];
						$archivo = $fecha .'-'. $archivos['name'][$i];
						if (!file_exists($carpeta)) {
							mkdir($carpeta, 0757, true);
						}
						$ruta_temp = $archivos['tmp_name'][$i];
						move_uploaded_file($ruta_temp, $ruta);
					} else {
						$archivo = '';
					}
					$registrarCurso = $empleado->registrarDocumento($nombre_archivo[$i], $archivo, $registrar);
				}
			}
		}
		
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('El empleado fue registrado correctamente');
		window.location.href='../Vista/empleados.php';
		</script>");
		
	} else {
		echo ("<script LANGUAGE='JavaScript'>
		window.alert('Error! Ya se encuentra un empleado activo registrado con el numero de cedula ingresado.');
		window.location.href='../Vista/empleados.php';
		</script>");
	}

} else {
	echo "<script>
		alert('Faltan campos obligatorios por diligenciar');
		history.back();
		</script>";
	exit();
}
?>