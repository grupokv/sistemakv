<?php  

require_once ("../Modelo/Programacion.php");
$programacion = new Programacion();

$id_programacion = $_POST['id_programacion'];

$listar_programacion_serviciosID = $programacion->listar_programacion_serviciosID($id_programacion);

$html = '';

if (count($listar_programacion_serviciosID) > 0) {
	$html .= '<div class="row d-flex justify-content-center  p-2">';
        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 p-2 mr-1 mt-1" style="border: 1px dashed #878787">';
            $html .= '<label style="font-size: .9rem;"><b>prueba 1</b></label>';
        $html .= '</div>';
    $html .= '</div>';
}

echo $html;

?>