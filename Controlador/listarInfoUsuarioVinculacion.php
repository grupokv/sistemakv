<?php
require_once("../Modelo/Vinculacion.php");

$vinculacion = new Vinculacion();

$id_solicitud_vinculacion = $_POST['id_solicitud'];

$listarSolicitudesId = $vinculacion->listarSolicitudesId($id_solicitud_vinculacion);

$html = "";

if(count($listarSolicitudesId) > 0){
    $html .= "<div class='col-10'>";
        $html .= "<p><strong> NOMBRE USUARIO: </strong> ". $listarSolicitudesId[0]['nombres_apellidos'] ."</p>";
        $html .= "<p><strong> NUMERO DOCUMENTO: </strong> ". $listarSolicitudesId[0]['num_documento'] ."</p>";
        $html .= "<p><strong> TELEFONO: </strong> ". $listarSolicitudesId[0]['telefono'] ."</p>";
        $html .= "<p><strong> CORREO ELECTRONICO: </strong> ". $listarSolicitudesId[0]['correo_electronico'] ."</p>";
        $html .= "<p><strong> CIUDAD RESIDENCIA: </strong> ". $listarSolicitudesId[0]['ciudad_residencia'] ."</p>";
    $html .= "</div>";
}

echo $html;

?>