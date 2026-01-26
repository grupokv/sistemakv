<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Vehiculo.php");
// require_once("../Modelo/Usuario.php");
// require_once("../Modelo/General.php");

$tipoVehiculo = new TipoVehiculo();
$vehiculo = new vehiculo();

$listarVehiculos = $vehiculo->listarBaseVehiculos();

$propietario = "'propietario'";
$tenedor = "'tenedor'";
$conductor = "'conductor'";

$html = '';

foreach($listarVehiculos as $lv){
    $id_vehiculo = $lv['id_vehiculo'];
    $listarTipoVehPorId = $tipoVehiculo->listarPorId($lv['id_tipo_vehiculo']);
    $listarTipoMovilID = $vehiculo->listarTipoMovilID($lv['id_tipo_movil']);

    $html .= '<tr class="text-center">';
        $html .= '<td>' . $lv['id_vehiculo'] . '</td>';
        $html .= '<td>' . $lv['placa'] . '</td>';
        $html .= '<td>' . $lv['numero_movil'] . '</td>';
        $html .= '<td>' . $listarTipoMovilID[0]['tipo_movil'] .'</td>';
        $html .= '<td>' . $listarTipoVehPorId[0]['nombre_tipo_vehiculo'] . '</td>';
        $html .= '<td>' . $lv['tipo_afiliacion'] .'</td>';
        $html .= '<td>' . $lv['aliado'] .'</td>';
        
        /* Estado - Documentos */
        $html .= '<td class="d-flex justify-content-center">';
            $html .= '<div id="contEstado" style="background: #96f909;" data-bs-toggle="tooltip" data-bs-placement="top" title="ACTIVO"></div>';
        $html .= '</td>';
        
        /* Propietarios */
        $html .= '<td>';
            $html .= '<div onclick="validarModalVehiculos(' . $propietario . ', ' . $lv['id_propietario'] . '); "><i id="buttonProp" data-toggle="modal" class="fa fa-user-circle infoVeh"></i></div>';
        $html .= '</td>';

        /* Tenedor */
        $html .= '<td>';
            $html .= '<div onclick="validarModalVehiculos(' . $tenedor . ', ' . $lv['id_propietario'] . '); "><i id="buttonTen" data-toggle="modal" class="fa fa-user-circle infoVeh"></i></div>';
        $html .='</td>';
        
        /* Conductor */
        $html .= '<td>';
            $html .= '<div onclick="validarModalVehiculos(' . $conductor . ', ' . $lv['id_propietario'] . '); "><i id="buttonCond" data-toggle="modal" class="fa fa-user-circle infoVeh"></i></div>';
        $html .= '</td>';
        
        /* Opciones */
        $html .= '<td>';
            $html .= '<a href="actualizarBaseServicio.php?id_servicio=' .$ls['id_servicio_base'] .'" class="btn btn-outline-info" style="margin: 2px; border-radius: 4px; padding: 0px 2px 0px 2px;"><i class="fa fa-edit"></i></a>';
        $html .='</td>';

        $html .= '<td>';
            $html .= '<i class="fa fa-exclamation-circle infoVeh"></i>';
        $html .='</td>';
        
    $html .= '</tr>';
}

echo $html;

?>
