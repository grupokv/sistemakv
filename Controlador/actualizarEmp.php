<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/General.php");

$id_empresa = $_POST['id_empresa'];
$nombre_empresa = mb_strtoupper($_POST['nombre_empresa']);
$nombre_empresa_act = mb_strtoupper($_POST['nombre_empresa_act']);
$nit_empresa = $_POST['nit_empresa'];
$nit_empresa_act = $_POST['nit_empresa_act'];
$direccion = mb_strtoupper($_POST['direccion']);
$direccion_act = mb_strtoupper($_POST['direccion_act']);
$telefono = $_POST['telefono'];
$telefono_act = $_POST['telefono_act'];
$id_pais = $_POST['id_pais'];
$id_pais_act = $_POST['id_pais_act'];
$id_departamento = $_POST['id_departamento'];
$id_departamento_act = $_POST['id_departamento_act'];
$id_ciudad = $_POST['id_ciudad'];
$id_ciudad_act = $_POST['id_ciudad_act'];
$representante_legal = mb_strtoupper($_POST['representante_legal']);
$representante_legal_act = mb_strtoupper($_POST['representante_legal_act']);
$numero_documento = $_POST['numero_documento'];
$numero_documento_act = $_POST['numero_documento_act'];
$fecha_expedicion = $_POST['fecha_expedicion'];
$fecha_expedicion_act = $_POST['fecha_expedicion_act'];
$lugar_expedicion = $_POST['lugar_expedicion'];
$lugar_expedicion_act = $_POST['lugar_expedicion_act'];
$ciudad_residencia = $_POST['ciudad_residencia'];
$ciudad_residencia_act = $_POST['ciudad_residencia_act'];

$estado = $_POST['estado'];


if ($_FILES['logo']['name'] != '') {

    $valido = validar_archivo($_FILES['logo']['name']);
    if($valido == 1){

    	$logo = quitar_simbolos($_FILES['logo']['name']);
    	$ruta = "../Resources/fpdf/img/". $_FILES['logo']['name'];
    	$ruta_temp = $_FILES['logo']['tmp_name'];
    	move_uploaded_file($ruta_temp, $ruta);

    } else {
    	echo "<script>
    	alert('El tipo de archivo en logo no es valido');
    	history.back();
    	</script>";
    	exit;
    }
} else {
	$logo = $_POST['act_logo'];
}

$empresa = new Empresa();

$actualizarEmp = $empresa->actualizar($id_empresa, $nombre_empresa, $nit_empresa, $direccion, $telefono, $id_pais, $id_departamento, $id_ciudad, $representante_legal, $numero_documento, $fecha_expedicion, $lugar_expedicion, $ciudad_residencia, $logo, $estado);

$id_modulo = 5;
$id_registro = $id_empresa;
$tipo_actividad = 'ACTUALIZAR';
$columnas_modulo = '';
$valores_antiguos = '';
$valores_nuevos = '';
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');



/*Nombre Empresa*/
	if ($nombre_empresa != $nombre_empresa_act) {
		$columnas_modulo .= 'nombre_empresa |';
		$valores_antiguos .= $nombre_empresa_act . ' | ';
		$valores_nuevos .= $nombre_empresa . ' | ';
	}

/*Nit Empresa*/
	if ($nit_empresa != $nit_empresa_act) {
		$columnas_modulo .= 'nit_empresa |';
		$valores_antiguos .= $nit_empresa_act . ' | ';
		$valores_nuevos .= $nit_empresa . ' | ';
	}

/*Direccion*/
	if ($direccion != $direccion_act) {
		$columnas_modulo .= 'direccion |';
		$valores_antiguos .= $direccion_act . ' | ';
		$valores_nuevos .= $direccion . ' | ';
	}

/*Telefono*/
	if ($telefono != $telefono_act) {
		$columnas_modulo .= 'telefono |';
		$valores_antiguos .= $telefono_act . ' | ';
		$valores_nuevos .= $telefono . ' | ';
	}

/*Pais*/
	if ($id_pais != $id_pais_act) {
		$columnas_modulo .= 'id_pais |';
		$valores_antiguos .= $id_pais_act . ' | ';
		$valores_nuevos .= $id_pais . ' | ';
	}

/*Departamento*/
	if ($id_departamento != $id_departamento_act) {
		$columnas_modulo .= 'id_departamento |';
		$valores_antiguos .= $id_departamento_act . ' | ';
		$valores_nuevos .= $id_departamento . ' | ';
	}

/*Ciudad*/
	if ($id_ciudad != $id_ciudad_act) {
		$columnas_modulo .= 'id_ciudad |';
		$valores_antiguos .= $id_ciudad_act . ' | ';
		$valores_nuevos .= $id_ciudad . ' | ';
	}

/*Representante Legal*/
	if ($representante_legal != $representante_legal_act) {
		$columnas_modulo .= 'representante_legal |';
		$valores_antiguos .= $representante_legal_act . ' | ';
		$valores_nuevos .= $representante_legal . ' | ';
	}

/*Numero Documento*/
	if ($numero_documento != $numero_documento_act) {
		$columnas_modulo .= 'numero_documento |';
		$valores_antiguos .= $numero_documento_act . ' | ';
		$valores_nuevos .= $numero_documento . ' | ';
	}

/*Fecha Expedicion*/
	if ($fecha_expedicion != $fecha_expedicion_act) {
		$columnas_modulo .= 'fecha_expedicion |';
		$valores_antiguos .= $fecha_expedicion_act . ' | ';
		$valores_nuevos .= $fecha_expedicion . ' | ';
	}

/*Lugar de Expedicion*/
	if ($lugar_expedicion != $lugar_expedicion_act) {
		$columnas_modulo .= 'lugar_expedicion |';
		$valores_antiguos .= $lugar_expedicion_act . ' | ';
		$valores_nuevos .= $lugar_expedicion . ' | ';
	}

/*Ciudad de Residencia*/
	if ($ciudad_residencia != $ciudad_residencia_act) {
		$columnas_modulo .= 'ciudad_residencia |';
		$valores_antiguos .= $ciudad_residencia_act . ' | ';
		$valores_nuevos .= $ciudad_residencia . ' | ';
	}

/*Logo*/
	if ($logo != $_POST['act_logo']) {
		$columnas_modulo .= 'logo |';
		$valores_antiguos .= $$_POST['act_logo'] . ' | ';
		$valores_nuevos .= $logo . ' | ';
	}


	if ($columnas_modulo != '') {
		$bitacoraRegistroEmpresa = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
	}

	header('Location: ../Vista/empresas.php');
 
?>

