<?php 
 
include("../Controlador/Sesion/autenticar.php");

require_once("../Modelo/TipoVehiculo.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/General.php");

setlocale(LC_ALL,"es_ES");

$usuario = new Usuario();
$operativo = new Operativo();
$vehiculo = new Vehiculo();
$tipoVehiculo = new TipoVehiculo();

$listarVehiculoFlotaPropia = $vehiculo->listarVehiculoFlotaPropia();

/*----- FECHA INICIAL -----*/
    if($_POST['fecha_inicial'] != ''){
        $fecha_inicial = $_POST['fecha_inicial'];
    }else{
        $fecha_inicial = date('Y-m-d');
    }

/*----- FECHA FINAL -----*/
    if($_POST['fecha_final'] != ''){
        $fecha_final = $_POST['fecha_final'];
    }else{
        $fecha_final = date('Y-m-d');
        //$fecha_final = '2022-06-30';
    }

/*----- FECHA FINAL -----*/
    if($_POST['tipo_filtro'] != ''){
        $tipo_filtro = $_POST['tipo_filtro'];
    }else{
        $tipo_filtro = 'TODOS';
    }

$html = '';

$html .= '<div class="row ml-1 mb-2" id="dataFilter" style="width: 100%; height: auto; padding: 5px; background-color: #fafafa; border-radius: 10px;">';
    
$fecha1 = explode("-", $fecha_inicial);
$fecha2 = explode("-", $fecha_final);
                     
    $html .= '<div id="filterActive" class="text-center m-1">Fecha Inicial: ' . $fecha1[2].' de '. ucfirst(mes($fecha1[1])) .' del '. $fecha1[0] . '</div>';
    $html .= '<div id="filterActive" class="text-center m-1">Fecha Final: ' . $fecha2[2].' de '. ucfirst(mes($fecha2[1])) .' del '. $fecha2[0] . '</div>';
    $html .= '<div id="filterActive" class="text-center m-1">Tipo Filtro: ' . $tipo_filtro .'</div>';
$html .= '</div>';

if($fecha_inicial == $fecha_final){

    if($tipo_filtro == 'TODOS'){
        
        /* ----------- VEHICULOS GRADES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculoSinFecha($lvfp['id_vehiculo']);

                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                    if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                    }else{
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) { 
                                            $serv = "'servicio'";
                                            if(($listarServiciosPorVehiculo[$i]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '12:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else if(($listarServiciosPorVehiculo[$i]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '22:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else{
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                    $html .= '<p></p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }
                                        }
                                        
                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if($diff->days <= 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }else if($diff->days > 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }


                                    }
                                    
                                $html .= '</div>';

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculoSinFecha($lvfp['id_vehiculo']);

                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px; ">';
                                    
                                    if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                        $html .= '</div>';
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                    }else{
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height:auto; width:auto; font-size: .7rem;">';
                                            $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                        $html .= '</div>';
                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) { 
                                            $serv = "'servicio'";
                                            if(($listarServiciosPorVehiculo[$i]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '12:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else if(($listarServiciosPorVehiculo[$i]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '22:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else{
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                    $html .= '<p></p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }
                                        }
                                        
                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if($diff->days <= 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }else if($diff->days > 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }


                                    }
                                    
                                $html .= '</div>';

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'DISP_DIA'){

        /* ----------- VEHICULOS GRADES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculoSinFecha($lvfp['id_vehiculo']);

                                    
                                if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){

                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                    $html .= '</div>';

                                }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS  MEDIANOS - PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculoSinFecha($lvfp['id_vehiculo']);

                                    
                                if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                    
                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                    $html .= '</div>';

                                }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'DISP_PARCIAL'){

        /* ----------- VEHICULOS GRADES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);

                                    
                                    if(count($listarServiciosPorVehiculo) != 0){
                                        
                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) { 
                                            $serv = "'servicio'";

                                            if(($listarServiciosPorVehiculo[$i]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '12:00:00') ){
                                                
                                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                        
                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                        $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                    $html .= '</div>';

                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                        $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                    $html .= '</div>';
                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                
                                                $html .= '</div>';

                                            }else if(($listarServiciosPorVehiculo[$i]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '22:00:00') ){
                                                
                                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                        
                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                        $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                    $html .= '</div>';

                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                        $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                    $html .= '</div>';
                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                
                                                $html .= '</div>';

                                            }

                                        }

                                        $html .= '</div>';
                                        
                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS - PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 
                        
                                
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);

                                    
                                    if(count($listarServiciosPorVehiculo) != 0){
                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                    
                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                            $html .= '</div>';

                                            for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) { 
                                                $serv = "'servicio'";
                                    
                                                    if(($listarServiciosPorVehiculo[$i]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '12:00:00') ){
                                                        
                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                            $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                        
                                                    }else if(($listarServiciosPorVehiculo[$i]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '22:00:00') ){
                                                        
                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                            $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                        $html .= '</div>';
                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                        
                                                    }


                                            }

                                        $html .= '</div>';
                                        
                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'MTTO_MENOR'){

        /* ----------- VEHICULOS GRADES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                /* -------------------------------------------------------------- */

                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], $fecha_inicial);

                                if(count($listarControlMantenimientosporVehiculo) != 0){
                                    
                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if((($diff->days + 1) <= 3) && ($listarControlMantenimientosporVehiculo[$i]['estado'] == 1)){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }

                                    $html .= '</div>';

                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                /* -------------------------------------------------------------- */

                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], $fecha_inicial);

                                if(count($listarControlMantenimientosporVehiculo) != 0){
                                    
                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 
                                            echo $diff->days;

                                            if((($diff->days + 1) <= 3) && ($listarControlMantenimientosporVehiculo[$i]['estado'] == 1)){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }

                                    $html .= '</div>';

                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'MTTO_MAYOR'){

        /* ----------- VEHICULOS GRADES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                        
                                /* -------------------------------------------------------------- */

                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], $fecha_inicial);
                                
                                if(count($listarControlMantenimientosporVehiculo) != 0){
                                    
                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if((($diff->days + 1) > 3) && ($listarControlMantenimientosporVehiculo[$i]['estado'] == 1)){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }

                                    $html .= '</div>';

                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
            
                            if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 
                        
                                /* -------------------------------------------------------------- */

                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], $fecha_inicial);

                                if(count($listarControlMantenimientosporVehiculo) != 0){
                                    
                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if((($diff->days + 1) > 3) && ($listarControlMantenimientosporVehiculo[$i]['estado'] == 1)){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }

                                    $html .= '</div>';

                                    }
                                    

                                /* -------------------------------------------------------------- */

                            }
                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'PLACA'){
        $id_vehiculo = $_POST['id_vehiculo'];
        $listarVehiculoPorId = $vehiculo->listarPorId($id_vehiculo);

        /* ----------- POR VEHICULO ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Por Placa - '. $listarVehiculoPorId[0]['placa'] .' <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="row d-flex justify-content-center">';

                    foreach ($listarVehiculoPorId as $lvpi) { 
                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvpi['id_tipo_vehiculo']); 
            
                                /* -------------------------------------------------------------- */

                                $id_vehiculo = " = '" . $lvpi['id_vehiculo'] . "'";
                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculoSinFecha($lvpi['id_vehiculo']);

                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-2 col-lg-2 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                    
                                    if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvpi['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                    }else{
                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                            $html .= '<b><p>' . $lvpi['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                        $html .= '</div>';

                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) { 
                                            $serv = "'servicio'";
                                            if(($listarServiciosPorVehiculo[$i]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '12:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else if(($listarServiciosPorVehiculo[$i]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$i]['hora_final'] <= '22:00:00') ){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                    $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }else{
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                    $html .= '<p></p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$i]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                            }
                                        }
                                        
                                        for ($i=0; $i < count($listarControlMantenimientosporVehiculo); $i++) { 
                                            $mtto = "'mtto'";
                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$i]['fecha_mtto']);
                                            $fecha2 = new DateTime(date('Y-m-d'));

                                            $diff = $fecha1->diff($fecha2); 

                                            if($diff->days <= 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                $html .= '</div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }else if($diff->days > 3){
                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$i]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                            }
                                        }


                                    }
                                    
                                $html .= '</div>';

                                /* -------------------------------------------------------------- */

                    }
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';
  
    }else if($tipo_filtro == 'FACTURACION'){
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="mt-2 table-responsive d-flex justify-content-center">';
                    
                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"><i class="fa fa-car"></i></th>';
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                                            $html .= '<th style="vertical-align: top; padding-left:5px; border: 2px solid #fff;" width="250px;">' .  $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</th>';
                                        }
                                    }
                                $html .= '</tr>';
                                
                            $html .= '</thead>';

                            $html .= '<tbody>';
                                $html .= '<tr>';
                                    $html .= '<td style="vertical-align: center; padding-left:5px; border: 2px solid #fff;"></td>';
                                    
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<td>'; 
                                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                    
                                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; width:auto; font-size: .7rem;">';
                                                        $html .= '<b>Servicios: ' . count($listarServiciosPorVehiculo) . '</b>';
                                                    $html .= '</div>';
                
                                                $html .= '</div>';
                                            $html .= '</td>';
                                        }
                                    }

                                $html .= '</tr>';
                                
                                $html .= '<tr>';
                                    $html .= '<td style="vertical-align: middle; padding-left:5px; border: 2px solid #fff;"><b>TOTAL ($): </b></td>';
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                        $valorMovil = 0;
                                        $valorCliente = 0;

                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) {
                                            $valorVehCli = json_decode($listarServiciosPorVehiculo[$i]['valor_cliente']);
                                            $valorVehMov = json_decode($listarServiciosPorVehiculo[$i]['valor_movil']);

                                            $valorM = $valorVehCli->{'entrada'} + $valorVehCli->{'salida'};
                                            $valorMovil = $valorMovil + $valorM;
                                            $valorC = $valorVehMov->{'entrada'} + $valorVehMov->{'salida'};
                                            $valorCliente = $valorCliente + $valorC;
                                        }

                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 
                                            $html .= '<td>';
                                                $html .= '<div class="row d-flex justify-content-center">';
                                                    $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Movil : $ ' . number_format($valorMovil). '</div>';
                                                    $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Cliente : $ ' . number_format($valorCliente). '</div>';
                                                $html .= '</div>';
                                            $html .= '</td>';
                                        }
                                    }
                                $html .= '</tr>';

                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="mt-2 table-responsive d-flex justify-content-center">';
                    
                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"><i class="fa fa-car"></i></th>';
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 
                                            $html .= '<th style="vertical-align: top; padding-left:5px; border: 2px solid #fff;" width="250px;">' .  $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</th>';
                                        }
                                    }
                                $html .= '</tr>';
                                
                            $html .= '</thead>';

                            $html .= '<tbody>';
                                $html .= '<tr>';
                                    $html .= '<td style="vertical-align: center; padding-left:5px; border: 2px solid #fff;"></td>';
                                    
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){  

                                            $html .= '<td>'; 
                                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                    
                                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; width:auto; font-size: .7rem;">';
                                                        $html .= '<b>Servicios: ' . count($listarServiciosPorVehiculo) . '</b>';
                                                    $html .= '</div>';
                
                                                $html .= '</div>';
                                            $html .= '</td>';
                                        }
                                    }

                                $html .= '</tr>';
                                
                                $html .= '<tr>';
                                    $html .= '<td style="vertical-align: middle; padding-left:5px; border: 2px solid #fff;"><b>TOTAL ($): </b></td>';
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 
                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo($fecha_inicial, $fecha_final, $id_vehiculo);
                                        $valorMovil = 0;
                                        $valorCliente = 0;

                                        for ($i=0; $i < count($listarServiciosPorVehiculo); $i++) {
                                            $valorVehCli = json_decode($listarServiciosPorVehiculo[$i]['valor_cliente']);
                                            $valorVehMov = json_decode($listarServiciosPorVehiculo[$i]['valor_movil']);

                                            $valorM = $valorVehCli->{'entrada'} + $valorVehCli->{'salida'};
                                            $valorMovil = $valorMovil + $valorM;
                                            $valorC = $valorVehMov->{'entrada'} + $valorVehMov->{'salida'};
                                            $valorCliente = $valorCliente + $valorC;
                                        }

                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){  
                                            $html .= '<td>';
                                                $html .= '<div class="row d-flex justify-content-center">';
                                                    $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Movil : $ ' . number_format($valorMovil). '</div>';
                                                    $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Cliente : $ ' . number_format($valorCliente). '</div>';
                                                $html .= '</div>';
                                            $html .= '</td>';
                                        }
                                    }
                                $html .= '</tr>';

                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }

}else{

    if($tipo_filtro == 'TODOS'){

        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                            if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; width:auto; font-size: .7rem;">';
                                                                    $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                                                $html .= '</div>';
                        
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                                            }else{
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: auto; font-size: .7rem;">';
                                                                    $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                                                $html .= '</div>';
                        
                                                                for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) { 
                                                                    $serv = "'servicio'";
                                                                    if(($listarServiciosPorVehiculo[$j]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '12:00:00') ){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                            $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }else if(($listarServiciosPorVehiculo[$j]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '22:00:00') ){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                            $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }else{
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                                            $html .= '<p></p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }
                                                                }
                                                                
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);

                                                                    if($listarControlMantenimientosporVehiculo[$j]['fecha_finalizacion'] != ''){
                                                                        $fecha2 = new DateTime(strftime("%Y-%m-%d", $i));
                                                                    }else{
                                                                        $fecha2 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_finalizacion']);
                                                                    }

                        
                                                                    $diff = $fecha1->diff($fecha2); 
                        
                                                                    if($diff->days <= 2){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                            $html .= '<p class="mr-3" style="font-size: .7rem;">' . ($diff->days + 1) .' DÍAS</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                    }else if($diff->days > 2){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                    }
                                                                }
                        
                        
                                                            }
                                                            
                                                        $html .= '</div>';

                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS - PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                            if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: auto; font-size: .7rem;">';
                                                                    $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                                                $html .= '</div>';
                        
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                                            }else{
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: auto; font-size: .7rem;">';
                                                                    $html .= '<b>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</b>';
                                                                $html .= '</div>';
                        
                                                                for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) { 
                                                                    $serv = "'servicio'";
                                                                    if(($listarServiciosPorVehiculo[$j]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '12:00:00') ){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                            $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }else if(($listarServiciosPorVehiculo[$j]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '22:00:00') ){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                            $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }else{
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                                            $html .= '<p></p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                    }
                                                                }
                                                                
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);
                                                                    $fecha2 = new DateTime(strftime("%Y-%m-%d", $i));
                        
                                                                    $diff = $fecha1->diff($fecha2); 
                        
                                                                    if($diff->days <= 2){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                            $html .= '<p class="mr-3" style="font-size: .7rem;"><= 3 DÍAS</p>';
                                                                        $html .= '</div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                    }else if($diff->days > 2){
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                                        $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                    }
                                                                }
                        
                        
                                                            }
                                                            
                                                        $html .= '</div>';

                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        
    }else if($tipo_filtro == 'DISP_DIA'){ 
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                        if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                                            $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                    $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                $html .= '</div>';
                        
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                                        
                                                            $html .= '</div>';
                                                        }
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        
        /* ----------- VEHICULOS MEDIANOS - PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        
                                                        if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                                            $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                    $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                $html .= '</div>';
                        
                                                                $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                                        
                                                            $html .= '</div>';
                                                        }
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'DISP_PARCIAL'){ 
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        
                                                            if(count($listarServiciosPorVehiculo) != 0){
                                                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                        $html .= '</div>';

                                                                        for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) { 
                                                                            $serv = "'servicio'";

                                                                                if(($listarServiciosPorVehiculo[$j]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '12:00:00') ){
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                                        $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }else if(($listarServiciosPorVehiculo[$j]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '22:00:00') ){
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                                        $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }else{
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                                                        $html .= '<p></p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }
                                                                            }
                                                                        
                                                                    $html .= '</div>';
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        
        /* ----------- VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        
                                                            if(count($listarServiciosPorVehiculo) != 0){
                                                                    $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                            $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                        $html .= '</div>';

                                                                        for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) { 
                                                                            $serv = "'servicio'";

                                                                                if(($listarServiciosPorVehiculo[$j]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '12:00:00') ){
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                                        $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }else if(($listarServiciosPorVehiculo[$j]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '22:00:00') ){
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                                        $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }else{
                                                                                    $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                                                        $html .= '<p></p>';
                                                                                    $html .= '</div>';
                                                                                    $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                                                }
                                                                            }
                                                                        
                                                                    $html .= '</div>';
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'MTTO_MENOR'){
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                            if(count($listarControlMantenimientosporVehiculo) != 0){
                                                               
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);
                                                                    $fecha2 = new DateTime(date('Y-m-d'));

                                                                    $diff = $fecha1->diff($fecha2); 

                                                                    if((($diff->days + 1) <= 3) && ($listarControlMantenimientosporVehiculo[j]['estado'] == 1)){
                                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                                $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                            $html .= '</div>';

                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                                $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                                            $html .= '</div>';
                                                                            $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                        
                                                                        $html .= '</div>';
                                                                    }else{
                                                                        $html .= '<p> - </p>';
                                                                    }
                                                                }
                        
                        
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        
        /* ----------- VEHICULOS VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                            if(count($listarControlMantenimientosporVehiculo) != 0){
                                                               
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);
                                                                    $fecha2 = new DateTime(date('Y-m-d'));

                                                                    $diff = $fecha1->diff($fecha2); 
                                                                    
                                                                    if((($diff->days + 1) <= 3) && ($listarControlMantenimientosporVehiculo[j]['estado'] == 1)){
                                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                                $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                            $html .= '</div>';

                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                                $html .= '<p class="mr-3" style="font-size: .7rem;">< 3 DÍAS</p>';
                                                                            $html .= '</div>';
                                                                            $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                        
                                                                        $html .= '</div>';
                                                                    }else{
                                                                        $html .= '<p> - </p>';
                                                                    }
                                                                }
                        
                        
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'MTTO_MAYOR'){
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                            if(count($listarControlMantenimientosporVehiculo) != 0){
                                                               
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);
                                                                    $fecha2 = new DateTime(date('Y-m-d'));

                                                                    $diff = $fecha1->diff($fecha2); 

                                                                    if((($diff->days + 1) > 3) && ($listarControlMantenimientosporVehiculo[$j]['estado'] == 1)){
                                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                                $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                            $html .= '</div>';

                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                                $html .= '<p class="mr-3" style="font-size: .7rem;">' . ($diff->days + 1)  .' DÍAS</p>';
                                                                            $html .= '</div>';
                                                                            $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                        
                                                                        $html .= '</div>';
                                                                    }else{
                                                                        $html .= '<p> - </p>';
                                                                    }
                                                                }
                        
                        
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';

                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        
        /* ----------- VEHICULOS VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo2" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros)<i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo2" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvfp['id_vehiculo'], strftime("%Y-%m-%d", $i));
                        
                                                            if(count($listarControlMantenimientosporVehiculo) != 0){
                                                               
                                                                for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                                    $mtto = "'mtto'";
                                                                    $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);
                                                                    $fecha2 = new DateTime(date('Y-m-d'));

                                                                    $diff = $fecha1->diff($fecha2); 

                                                                    if((($diff->days + 1) > 3) && ($listarControlMantenimientosporVehiculo[$j]['estado'] == 1)){
                                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            
                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                                                $html .= '<b><p>' . $lvfp['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                                            $html .= '</div>';

                                                                            $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                                $html .= '<p class="mr-3" style="font-size: .7rem;">' . ($diff->days + 1)  .' DÍAS</p>';
                                                                            $html .= '</div>';
                                                                            $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                                        
                                                                        $html .= '</div>';
                                                                    }else{
                                                                        $html .= '<p> - </p>';
                                                                    }
                                                                }
                        
                        
                                                            }else{
                                                                $html .= '<p> - </p>';
                                                            }
                                                            
                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';

                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }else if($tipo_filtro == 'PLACA'){

        //$vehiculo = $_POST['id_vehiculo'];
        $idvehiculo = 24;
        $listarVehiculoPorId = $vehiculo->listarPorId($idvehiculo);

        /* ----------- POR VEHICULO ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Por Placa - '. $listarVehiculoPorId[0]['placa'] .' <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse show p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                    $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                        $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                            $html .= '<tr>';
                                $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                }
                            $html .= '</tr>';
                        $html .= '</thead>';
                            
                        $html .= '<tbody>';

                            foreach ($listarVehiculoPorId as $lvpi) { 
                                $listarTipoVPorId = $tipoVehiculo->listarPorId($lvpi['id_tipo_vehiculo']); 
                            
                                    $html .= '<tr>';
                                        $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvpi['placa'] . '</td>';
                                        for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                            $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';
                                                $id_vehiculo = " = '" . $lvpi['id_vehiculo'] . "'";
                                                $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                $listarControlMantenimientosporVehiculo = $operativo->listarControlMantenimientosporVehiculo($lvpi['id_vehiculo'], strftime("%Y-%m-%d", $i));
                
                                                $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                    
                                                    if((count($listarServiciosPorVehiculo) == 0) && (count($listarControlMantenimientosporVehiculo) == 0)){
                                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                            $html .= '<b><p>' . $lvpi['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                        $html .= '</div>';
                
                                                        $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; height: 20px;">DISPONIBLE</div>';
                                                    }else{
                                                        $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10" style="border: 1px solid #d7d6d6; height: 20px; font-size: .7rem;">';
                                                            $html .= '<b><p>' . $lvpi['placa'] . " - (" . $listarTipoVPorId[0]['nombre_tipo_vehiculo'] . ")" . '</p></b>';
                                                        $html .= '</div>';
                
                                                        for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) { 
                                                            $serv = "'servicio'";
                                                            if(($listarServiciosPorVehiculo[$j]['hora_inicio'] >= '04:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '12:00:00') ){
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                    $html .= '<p class="mr-4" style="font-size: .7rem;">AM</p>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                            }else if(($listarServiciosPorVehiculo[$j]['hora_inicio'] > '12:00:00') && ($listarServiciosPorVehiculo[$j]['hora_final'] <= '22:00:00') ){
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: start; color: #000; border: 1px solid #d7d6d6; background: linear-gradient(to right, white 0%, white 50%, #00B050 50%, #00B050 100%); height: 20px;">';
                                                                    $html .= '<p class="ml-4" style="font-size: .7rem;">PM</p>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                            }else{
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="color: #d3d3d3; border: 1px solid #d7d6d6; background: #00B050; height: 20px;">';
                                                                    $html .= '<p></p>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" onclick="moreInfoServ('. $listarServiciosPorVehiculo[$j]['id_servicio_base'] .', '. $serv .');" data-toggle="modal" data-target="#modalDetail"><i class="fa fa-plus"></i></div>';
                                                            }
                                                        }
                                                        
                                                        for ($j=0; $j < count($listarControlMantenimientosporVehiculo); $j++) { 
                                                            $mtto = "'mtto'";
                                                            $fecha1 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_mtto']);

                                                            if($listarControlMantenimientosporVehiculo[$j]['fecha_finalizacion'] != ''){
                                                                $fecha2 = new DateTime(strftime("%Y-%m-%d", $i));
                                                            }else{
                                                                $fecha2 = new DateTime($listarControlMantenimientosporVehiculo[$j]['fecha_finalizacion']);
                                                            }

                
                                                            $diff = $fecha1->diff($fecha2); 
                
                                                            if($diff->days <= 2){
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: linear-gradient(to left, white 0%, white 50%, #8EA9DB 50%, #8EA9DB 100%); height: 20px;">';
                                                                    $html .= '<p class="mr-3" style="font-size: .7rem;">' . ($diff->days + 1) .' DÍAS</p>';
                                                                $html .= '</div>';
                                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', '. $mtto .');"><i class="fa fa-plus"></i></div>';
                                                            }else if($diff->days > 2){
                                                                $html .= '<div class="col-xs-10 col-sm-10 col-md-10 col-lg-10 mt-1" style="text-align: end; color: #3d3d3d; border: 1px solid #d7d6d6; background: #8EA9DB; height: 20px;"></div>';
                                                                $html .= '<div class="text-center ml-2 mt-1" style="cursor:pointer;" data-toggle="modal" data-target="#modalDetail" onclick="moreInfoServ('. $listarControlMantenimientosporVehiculo[$j]['id_mantenimiento'] .', ' . $mtto .');"><i class="fa fa-plus"></i></div>';
                                                            }
                                                        }
                
                
                                                    }
                                                    
                                                $html .= '</div>';

                                            $html .= '</td>';
                                        }
                                    $html .= '</tr>';
                            }

                        $html .= '</tbody>';

                    $html .= '</table>';

                $html .= '</section>';

            $html .= '</div>';
        $html .= '</div>';
  
    }else if($tipo_filtro == 'FACTURACION'){
        
        /* ----------- VEHICULOS GRANDES ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo" aria-expanded="true">Vehículos Grandes (Bus - Buseta) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] == 4) || ($lvfp['id_tipo_vehiculo'] == 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        
                                                        $valorMovil = 0;
                                                        $valorCliente = 0;

                                                        for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) {
                                                            $valorVehCli = json_decode($listarServiciosPorVehiculo[$j]['valor_cliente']);
                                                            $valorVehMov = json_decode($listarServiciosPorVehiculo[$j]['valor_movil']);

                                                            $valorM = $valorVehCli->{'entrada'} + $valorVehCli->{'salida'};
                                                            $valorMovil = $valorMovil + $valorM;
                                                            $valorC = $valorVehMov->{'entrada'} + $valorVehMov->{'salida'};
                                                            $valorCliente = $valorCliente + $valorC;
                                                        }

                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; width:auto; font-size: .7rem;">';
                                                                $html .= '<b>Servicios: ' . count($listarServiciosPorVehiculo) . '</b>';
                                                            $html .= '</div>';
                                                        $html .= '</div>';

                                                        $html .= '<div class="row d-flex justify-content-center">';
                                                            $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Movil : $ ' . number_format($valorMovil). '</div>';
                                                            $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Cliente : $ ' . number_format($valorCliente). '</div>';
                                                        $html .= '</div>';
                                                            

                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

        /* ----------- VEHICULOS MEDIANOS Y PEQUEÑOS ----------- */
        $html .= '<div class="card mb-2">';
            $html .= '<button type="button" class="btn infoDisp" data-toggle="collapse" data-target="#demo1" aria-expanded="true">Vehículos Medianos y Pequeños  (Autos, SW, Doblecabina, Camperos, Vans, Micros) <i class="fa fa-caret-down ml-1"></i></button>';
            $html .= '<div id="demo1" class="collapse p-3"> ';
                $html .= '<section class="mt-2 p-4 table-responsive d-flex justify-content-center">';
                    $fechaInicial = strtotime($fecha_inicial);
                    $fechaFinal = strtotime($fecha_final);

                        $html .= '<table class="table table-hover table-sm display text-center" style="width: auto; display: block; overflow-x: auto; white-space: nowrap;">';

                            $html .= '<thead style="background-color: #1b2d3b; color: #fff;">';
                                $html .= '<tr>';
                                    $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="150px;"></th>';
                                    for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                        $html .= '<th style="vertical-align: top; border: 2px solid #fff;" width="250px;">' . utf8_encode(ucwords(strftime("%A - %d de %B", $i))) . '</th>';
                                    }
                                $html .= '</tr>';
                            $html .= '</thead>';
                            
                            $html .= '<tbody>';
                                
                                    foreach ($listarVehiculoFlotaPropia as $lvfp) { 

                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                            
                                        if(($lvfp['id_tipo_vehiculo'] != 4) && ($lvfp['id_tipo_vehiculo'] != 5)){ 

                                            $html .= '<tr>';
                                                $html .= '<td vertical-align: top; style="background-color: #1b2d3b; color: #fff;">' . $lvfp['placa'] . '</td>';
                                                for($i = $fechaInicial; $i <= $fechaFinal; $i+=86400){
                                                    $html .= '<td style="vertical-align: top; border: 2px solid #fff;">';

                                                        $id_vehiculo = " = '" . $lvfp['id_vehiculo'] . "'";
                                                        $listarTipoVPorId = $tipoVehiculo->listarPorId($lvfp['id_tipo_vehiculo']); 
                                                        $listarServiciosPorVehiculo = $operativo->listarServiciosPorVehiculo(strftime("%Y-%m-%d", $i), strftime("%Y-%m-%d", $i), $id_vehiculo);
                                                        
                                                        $valorMovil = 0;
                                                        $valorCliente = 0;

                                                        for ($j=0; $j < count($listarServiciosPorVehiculo); $j++) {
                                                            $valorVehCli = json_decode($listarServiciosPorVehiculo[$j]['valor_cliente']);
                                                            $valorVehMov = json_decode($listarServiciosPorVehiculo[$j]['valor_movil']);

                                                            $valorM = $valorVehCli->{'entrada'} + $valorVehCli->{'salida'};
                                                            $valorMovil = $valorMovil + $valorM;
                                                            $valorC = $valorVehMov->{'entrada'} + $valorVehMov->{'salida'};
                                                            $valorCliente = $valorCliente + $valorC;
                                                        }

                                                        $html .= '<div class="row col-xs-12 col-sm-12 col-md-12 col-lg-12 m-2 text-center" style="border: 1px dashed #d3d3d3; padding: 7px;">';
                                                            $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="border: 1px solid #d7d6d6; height: 20px; width:auto; font-size: .7rem;">';
                                                                $html .= '<b>Servicios: ' . count($listarServiciosPorVehiculo) . '</b>';
                                                            $html .= '</div>';
                                                        $html .= '</div>';

                                                        $html .= '<div class="row d-flex justify-content-center">';
                                                            $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Movil : $ ' . number_format($valorMovil). '</div>';
                                                            $html .= '<div class="col-12 m-1" style="font-size: .7rem;">Valor Cliente : $ ' . number_format($valorCliente). '</div>';
                                                        $html .= '</div>';
                                                            

                                                    $html .= '</td>';
                                                }
                                            $html .= '</tr>';
                                        }
                                    }
                            $html .= '</tbody>';

                        $html .= '</table>';
                $html .= '</section>';
            $html .= '</div>';
        $html .= '</div>';

    }

}




echo $html;


?>