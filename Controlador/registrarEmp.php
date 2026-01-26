<?php 

include 'Sesion/autenticar.php';
require_once("../Modelo/EmpresaEnt.php");
require_once("../Modelo/General.php");


/*empresa*/
$nombre_empresa = mb_strtoupper($_POST['nombre_empresa']);
$nit_empresa = $_POST['nit_empresa'];
$direccion = mb_strtoupper($_POST['direccion']);
$telefono = $_POST['telefono'];
$logo = $_FILES['logo']['name'];
$id_pais = $_POST['id_pais'];
$id_ciudad = $_POST['id_ciudad'];
$id_departamento = $_POST['id_departamento'];

/*representante legal*/
$representante_legal = mb_strtoupper($_POST['representante_legal']);
$numero_documento = $_POST['numero_documento'];
$fecha_expedicion = $_POST['fecha_expedicion'];
$lugar_expedicion = $_POST['lugar_expedicion'];
$ciudad_residencia = $_POST['ciudad_residencia'];
$num_registro_mercantil = $_POST['num_resolucion_ministerio'];
$num_resolucion_ministerio = $_POST['representante_legal'];

if (isset($logo)) {

        if (!empty($_FILES['logo']['name'])) {

            $ruta = "../Resources/fpdf/img/". $_FILES['logo']['name'];

            $ruta_temp = $_FILES['logo']['tmp_name'];
            move_uploaded_file($ruta_temp, $ruta);   
        }
}

$empresa = new Empresa();
$registrar = $empresa->registrar($nombre_empresa, $nit_empresa, $direccion, $telefono, $id_pais, $id_departamento, $id_ciudad, $representante_legal, $numero_documento, $fecha_expedicion, $lugar_expedicion, $ciudad_residencia, $logo, $num_registro_mercantil, $num_resolucion_ministerio);

$id_modulo = 5;
$id_registro = $registrar;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_empresa | nombre_empresa | nit_empresa | direccion | telefono | id_pais | id_departamento | id_ciudad 
					| representante_legal | numero_documento | fecha_expedicion | lugar_expedicion | ciudad_residencia | logo 
					| estado  ';
$valores_antiguos = '';
$valores_nuevos = 	$registrar . ' | ' . $nombre_empresa . ' | ' . $nit_empresa . ' | ' . $direccion . ' | ' . $telefono . ' | ' . 
					$id_pais . ' | ' . $id_departamento . ' | ' . $id_ciudad . ' | ' . $representante_legal . ' | ' . 
					$numero_documento . ' | ' . $fecha_expedicion . ' | ' . $lugar_expedicion . ' | ' . $ciudad_residencia . ' | ' .
					$logo . ' | ' . 1;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroEmpresa = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, 
													  $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, 
													  $hora_actividad);

header('Location: ../Vista/empresas.php');

 ?>