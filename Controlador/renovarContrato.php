<?php 
session_start();
require_once '../Modelo/Contrato.php';
require_once("../Modelo/General.php");

$contrato = new Contrato();

$id_contrato = $_POST['id_contrato'];
$doc_fotocopia_contrato = $_FILES['doc_fotocopia_contrato']['name'];
$act_doc_fotocopia_contrato = $_POST['act_doc_fotocopia_contrato'];
$fecha_inicial_contrato = $_POST['fecha_inicial_contrato'];
$act_fecha_inicial_contrato = $_POST['act_fecha_inicial_contrato'];
$fecha_final_contrato = $_POST['fecha_final_contrato'];
$act_fecha_final_contrato = $_POST['act_fecha_final_contrato'];

if (isset($doc_fotocopia_contrato)) {

    /*CERTIFICADOS ESTUDIOS*/

            if (!empty($doc_fotocopia_contrato)) {

                $valido = 0;
                $valido = validar_archivo($_FILES['doc_fotocopia_contrato']['name'], $_FILES['doc_fotocopia_contrato']['size']);
                if($valido == 1){

                    $doc_fotocopia_contrato = quitar_simbolos($_FILES['doc_fotocopia_contrato']['name']);
                    $doc_fotocopia_contrato = $fecha . '-'. $certificados_estudios;                    
                    $carpeta = "D:\sistemakv\Documentos\Contrato";
                    $ruta = $carpeta .'/'. $doc_fotocopia_contrato;                    

                    if (!file_exists($carpeta)) {
                        mkdir($carpeta, 0757, true);
                    }

                    $ruta_temp = $_FILES['doc_fotocopia_contrato']['tmp_name'];
                    move_uploaded_file($ruta_temp, $ruta);

                } else {
                    echo "<script>
                    alert('El tipo de archivo en Fotocopia del contrato no es valido o el archivo excede el tamaño permitido.');
                    history.back();
                    </script>";
                    exit();
                }
                
            }else{
                $doc_fotocopia_contrato = $act_doc_fotocopia_contrato;
            }
}

$renovarContrato = $contrato->renovarContrato($id_contrato, $doc_fotocopia_contrato, $fecha_inicial_contrato, $fecha_final_contrato);

 $id_modulo = 20;
 $id_registro = $id_contrato;
 $tipo_actividad = 'RENOVACION CONTRATO';
 $columnas_modulo = '';
 $valores_antiguos = '';
 $valores_nuevos = '';
 $id_usuario = $_SESSION['id_usuario'];
 $fecha_actividad = date('Y-m-d');
 $hora_actividad = date('H:i:s');
 
 if ($doc_fotocopia_contrato != $act_doc_fotocopia_contrato) {
	$columnas_modulo .= 'doc_fotocopia_contrato | ';
    $valores_antiguos .= $act_doc_fotocopia_contrato . ' | ';
    $valores_nuevos .= $doc_fotocopia_contrato . ' | ';
 }

 if ($fecha_inicial_contrato != $act_fecha_inicial_contrato) {
	$columnas_modulo .= 'fecha_inicial_contrato | ';
    $valores_antiguos .= $act_fecha_inicial_contrato . ' | ';
    $valores_nuevos .= $fecha_inicial_contrato . ' | ';
 }

 if ($fecha_final_contrato != $act_fecha_final_contrato) {
	$columnas_modulo .= 'fecha_final_contrato | ';
    $valores_antiguos .= $act_fecha_final_contrato . ' | ';
    $valores_nuevos .= $fecha_final_contrato . ' | ';
 }

if($columnas_modulo != ''){
    $bitacoraActualizacionArea = registrarBitacoraActividades($id_modulo, $id_registro, $tipo_actividad, $columnas_modulo, $valores_antiguos, $valores_nuevos, $id_usuario, $fecha_actividad, $hora_actividad);
}
/*
header('Location: ../Vista/consultarContratos.php');*/


?>