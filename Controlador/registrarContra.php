<?php 
include 'Sesion/autenticar.php';
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Vehiculo-Contrato.php");
require_once("../Modelo/General.php");

date_default_timezone_set('America/Bogota');

$numero_contrato = $_POST['numero_contrato'];
$id_tipo_contrato = $_POST['id_tipo_contrato'];
$id_empresa = $_POST['id_empresa'];
$id_cliente = $_POST['id_cliente'];
$objeto_contrato = mb_strtoupper($_POST['objeto_contrato']);
$fecha_inicial_contrato = $_POST['fecha_inicial_contrato'];
$fecha_final_contrato = $_POST['fecha_final_contrato'];
$fecha_creacion_contrato = date('Y-m-d');
$hora_creacion_contrato = date('H:i:s');
$id_ciudad = $_POST['id_ciudad'];
$id_responsable = $_POST['id_responsable'];
$doc_fotocopia_contrato = $_FILES['doc_fotocopia_contrato']['name'];

$nombre_responsable = $_POST['nombre_responsable'];
$numero_documento_responsable = $_POST['numero_documento_responsable'];
$direccion_responsable = $_POST['direccion_responsable'];
$telefono_responsable = $_POST['telefono_responsable'];

$fecha = date('YmdHis');

if (isset($_FILES['doc_fotocopia_contrato']['name'])) {

    //DOC FOTOCOPIA CONTRATO
        if (!empty($_FILES['doc_fotocopia_contrato']['name'])) {

            $carpeta = '../Documentos/Contratos';
            $ruta = $carpeta .'/'. $fecha .'-'. $_FILES['doc_fotocopia_contrato']['name'];
            $doc_fotocopia_contrato = $fecha .'-'. $doc_fotocopia_contrato;

            $ruta_temp = $_FILES['doc_fotocopia_contrato']['tmp_name'];
            move_uploaded_file($ruta_temp, $ruta);
                
       	}
}   

    /*REGISTRAR CONTRATO*/
    
   $contrato = new Contrato();
    
    $registrarC = $contrato->registrar($numero_contrato, $id_tipo_contrato, $id_empresa, $id_cliente, $objeto_contrato, $fecha_inicial_contrato, $fecha_final_contrato, $fecha_creacion_contrato, $hora_creacion_contrato, $id_ciudad, $id_responsable, $doc_fotocopia_contrato, $nombre_responsable, $numero_documento_responsable, $direccion_responsable, $telefono_responsable);

$id_modulo = 24;
$id_registro = $registrarC;
$tipo_actividad = 'REGISTRAR';
$columnas_modulo = 'id_contrato | id_empresa | id_cliente |objeto_contrato | fecha_inicial_contrato | fecha_final_contrato | fecha_creacion_contrato | hora_creacion_contrato | id_ciudad | id_responsable';
$valores_antiguos =  '';
$valores_nuevos = $registrarC . ' | '. $id_empresa . ' | '  . $id_cliente . ' | '  . $objeto_contrato . ' | '. 
				  $fecha_inicial_contrato . ' | ' .  $fecha_final_contrato . ' | ' . $fecha_creacion_contrato . ' | ' . 
				  $hora_creacion_contrato . ' | ' . $id_ciudad . ' | '. $id_responsable;
$id_usuario = $_SESSION['id_usuario'];
$fecha_actividad = date('Y-m-d');
$hora_actividad = date('H:i:s');

$bitacoraRegistroContatosFijos = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);

header('Location: ../Vista/contratos.php');

 ?>