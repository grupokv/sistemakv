<?php 
    
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");

$vehiculo = new vehiculo();
$usuario = new Usuario();

$id_propietario = $_POST['id_propietario'];
$typeInfo = $_POST['typeInfo'];

$listarUsuarioPorId = $usuario->listarUsuarioPorId($id_propietario);

$html = '';

foreach ($listarUsuarioPorId as $lupi) {
    if($typeInfo == 'propietario'){
        
        $html .= '<div class="col-12 mt-2 mb-3" style="font-size: 1.1rem; color: #1b2d3b;">';
            $html .= '<b><i style="font-size: 1.2rem;" class="fa fa-user-circle mr-2"></i>PROPIETARIO(S)</b>';    
        $html .= '</div>';

        $html .= '<section class="row ml-2 mb-1 mr-2 p-2" style="border-top: 1px dashed #1b2d3b;">';
            $html .= '<div class="col-12 mt-2" style="color: #1b2d3b;">';
                $html .= '<p >' . $listarUsuarioPorId[0]['nombre'] . ' - ' . $listarUsuarioPorId[0]['usuario'] .'</p>';
            $html .= '</div>';
        $html .= '</section>';   
    }else if($typeInfo == 'tenedor'){
        $html .= '<section class="row">';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">';
                $html .= '<label for=""><b>Tenedor (s) : </b></label>';
            $html .= '</div>';
            $html .= '<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">';
                $html .= '<p>' . $listarUsuarioPorId[0]['nombre'] .'</p>';
            $html .= '</div>';
        $html .= '</section>'; 
    }

}

echo $html;

?>