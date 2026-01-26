<?php
include 'Sesion/autenticar.php';
require_once("../Modelo/Salud.php");
require_once("../Modelo/General.php");

$salud = new Salud();

$hoy = date('Y-m-d');
$fecha = date('Y-m-d H:i:s');
$usuario = $_SESSION['id_usuario'];
$busqueda = $salud->buscarPorUsuarioVulnerabilidad($usuario,$hoy);
$cant = count($busqueda);

if($cant > 0){

    echo "<script>
    alert('Usted ya ingreso la informacion el dia de hoy');
    window.location.href = '../Vista/inicio.php';
    </script>";
    exit;

} else {
	
	$email = $_POST['email'];
	$celular = $_POST['celular'];
	$direccion = $_POST['direccion'];
	$empresa = $_POST['empresa'];
	$fechanac = $_POST['fechanac'];
	$eps = $_POST['eps'];
	$arl = $_POST['arl'];
	$cargo = $_POST['cargo'];
	$contrato = $_POST['contrato'];
	$transporte = $_POST['transporte'];
	$nombre_contacto = $_POST['nombre_contacto'];
	$tel_contacto = $_POST['tel_contacto'];
	$enfermedad = $_POST['enfermedad'];
	$hipertension = 'N';
	$epoc = 'N';
	$cancer = 'N';
	$diabetes = 'N';
	$vih = 'N';
	$cardiaca = 'N';
	$renal = 'N';
	$asma = 'N';
	$otra = 'N';
	$cual = '';
	$ninguna = 'N';
	for($i=0;$i<count($enfermedad);$i++){
		if($enfermedad[$i] == 'hipertension'){
			$hipertension = 'S';
		} else if($enfermedad[$i] == 'epoc'){
			$epoc = 'S';
		} else if($enfermedad[$i] == 'epoc'){
			$epoc = 'S';
		} else if($enfermedad[$i] == 'cancer'){
			$cancer = 'S';
		} else if($enfermedad[$i] == 'diabetes'){
			$diabetes = 'S';
		} else if($enfermedad[$i] == 'vih'){
			$vih = 'S';
		} else if($enfermedad[$i] == 'cardiaca'){
			$cardiaca = 'S';
		} else if($enfermedad[$i] == 'renal'){
			$renal = 'S';
		} else if($enfermedad[$i] == 'asma'){
			$asma = 'S';
		} else if($enfermedad[$i] == 'otra'){
			$otra = 'S';
			$cual = $_POST['otra_enfermedad'];
		} else if($enfermedad[$i] == 'ninguna'){
			$ninguna = 'S';
			$hipertension = 'N';
			$epoc = 'N';
			$cancer = 'N';
			$diabetes = 'N';
			$vih = 'N';
			$cardiaca = 'N';
			$renal = 'N';
			$asma = 'N';
			$otra = 'N';
			$cual = '';
		}		
	}
	$obesidad = $_POST['obesidad'];
	$obesidad = $obesidad[0];
	$embarazo = $_POST['embarazo'];
	$embarazo = $embarazo[0];
	$medicamentos = $_POST['medicamentos'];
	$medicamentos = $medicamentos[0];
	$edad = $_POST['edad'];
	$edad = $edad[0];
	$dolor_garganta = $_POST['dolor_garganta'];
	$dolor_garganta = $dolor_garganta[0];
	$malestar_general = $_POST['malestar_general'];
	$malestar_general = $malestar_general[0];
	$fiebre = $_POST['fiebre'];
	$fiebre = $fiebre[0];
	$tos = $_POST['tos'];
	$tos = $tos[0];
	$respirar = $_POST['respirar'];
	$respirar = $respirar[0];
	$olfato = $_POST['olfato'];
	$olfato = $olfato[0];
	$aislamiento_sin = $_POST['aislamiento_sin'];
	$aislamiento_sin = $aislamiento_sin[0];
	$aislamiento_con = $_POST['aislamiento_con'];
	$aislamiento_con = $aislamiento_con[0];
	$caso_confirmado = $_POST['caso_confirmado'];
	$caso_confirmado = $caso_confirmado[0];
	$contacto_estrecho = $_POST['contacto_estrecho'];
	$contacto_estrecho = $contacto_estrecho[0];
	$vulnerables = $_POST['vulnerables'];
	$vulnerables = $vulnerables[0];
	$temperatura = $_POST['temperatura'];
	$prueba_covid = $_POST['prueba_covid'];
	$prueba_covid = $prueba_covid[0];
	if($prueba_covid == 'N'){
		$fecha_prueba = '0000-00-00';
		$resultado = '';
		$fecha_resultado = '0000-00-00';
		
	} else {
		$fecha_prueba = $_POST['fecha_prueba'];
		$resultado = $_POST['resultado'];
		if($resultado == 'P'){
			$fecha_resultado = '0000-00-00';
		} else {
			$fecha_resultado = $_POST['fecha_resultado'];
		}
	}
	$terminos = $_POST['terminos'];
	$terminos = $terminos[0];
	
	$registrar = $salud->registrarVulnerabilidad($usuario, $email, $celular, $direccion, $empresa, $fechanac, $eps, $arl, $cargo, $contrato, $transporte, $nombre_contacto, $tel_contacto, $hipertension, $epoc, $cancer, $diabetes, $vih, $cardiaca, $renal, $asma, $otra, $cual, $ninguna,$embarazo, $obesidad, $medicamentos, $edad, $dolor_garganta, $malestar_general, $fiebre, $tos, $respirar, $olfato, $aislamiento_sin, $aislamiento_con, $caso_confirmado, $contacto_estrecho, $vulnerables, $temperatura, $prueba_covid, $fecha_prueba, $resultado, $fecha_resultado, $terminos, $fecha);
}
if($_SESSION['id_perfil'] == 3){
echo ("<script LANGUAGE='JavaScript'>
    window.alert('Respuestas guardadas correctamente, gracias por su participacion');
    window.location.href='../Vista/inicioConductores.php';
    </script>");
} else {
echo ("<script LANGUAGE='JavaScript'>
    window.alert('Respuestas guardadas correctamente, gracias por su participacion');
    window.location.href='../Vista/inicio.php';
    </script>");
}
?>