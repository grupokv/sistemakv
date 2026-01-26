<?php
require_once "../Modelo/Cartera.php";
require_once "../Modelo/Usuario.php";

$id_vehiculo = $_POST['id_vehiculo'];

$cartera = new Cartera();
$usuario = new Usuario();
$listado = $cartera->listarComprobantePorVehiculo($id_vehiculo);
$cant = count($listado);

$html = '<table class="table table-hover table-sm display" style="width:100%">';
    if($cant > 0){
        
        $html .= '<tr>';
        $html .= '<td><strong>TIPO</strong></td>';
        $html .= '<td><strong>FECHA</strong></td>';
        $html .= '<td><strong>DETALLE</strong></td>';
        $html .= '<td><strong>USUARIO</strong></td>';
        $html .= '</tr>';
        
        foreach($listado as $ls){
        
        $html .= '<tr>';
        $det_estado = $cartera->listarPorIdTipoGestion($ls['tipo']);
        $html .= '<td>'.$det_estado[0]['detalle'].'</td>';
        $html .= '<td>'.$ls['fecha'].'</td>';
        $html .= '<td>'.$ls['detalle'].'</td>';
        $det_usuario = $usuario->listarUsuarioPorId($ls['id_usuario']);
        $html .= '<td>'.$det_usuario[0]['nombre'].'</td>';
        $html .= '</tr>';
        
        }
        
        
    }else{
            $html .= '<tr><td><p class="text-center"><strong>SIN GESTION</strong></p></td></tr>';
    } 

$html .= '</table>';

echo $html;

?>