<?php  
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Empleado.php");

date_default_timezone_set('America/Bogota');
$empleado = new Empleado();

$id = $_POST['id'];
$fecha = date('YmdHis');

$nombreDocSS = $_POST['nombre_doc_ss'];
$mesSS = $_POST['mes'];
$anioSS = $_POST['anio'];

if (!empty($_FILES['doc_ss']['name'])) {
    
    $carpeta = '../Documentos/Empleados/SeguridadSocial';
    $ruta = $carpeta . '/' . $fecha . '-' . $_FILES['doc_ss']['name'];
    $docSS = $fecha .'-'. $_FILES['doc_ss']['name'];

    if (!file_exists($carpeta)) {
        mkdir($carpeta, 0757, true);
    }

    $ruta_temp = $_FILES['doc_ss']['tmp_name'];
    move_uploaded_file($ruta_temp, $ruta);
        

} else {
    $docSS = $_POST['doc_ss_actual'];
}

$actualizarSeguridadSocialEmpleado = $empleado->actualizarSeguridadSocialEmpleado($id, $nombreDocSS, $docSS, $anioSS, $mesSS);

header('Location: ../Vista/seguridadSocialEmpleados.php');



?>