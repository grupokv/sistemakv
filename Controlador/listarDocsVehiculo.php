<?php

require_once "../Modelo/Vehiculo.php";

require_once "../Modelo/FotografiaVehiculo.php";





$ip = '../Documentos';

$id_vehiculo = $_POST['id_vehiculo'];



$vehiculo = new Vehiculo();

$fotografiaVehiculo = new FotografiaVehiculo();



$listarFotografiasPorIdVehiculo = $fotografiaVehiculo->listarPorIdVehiculo($id_vehiculo);

$listarVehId = $vehiculo->listarPorId($id_vehiculo);



$cant = count($listarVehId);

$cant2 = count($listarFotografiasPorIdVehiculo);



date_default_timezone_set('America/Bogota');

$fecha = date('YmdHis');





$html = '<div>';
    if($cant > 0){
        foreach($listarVehId as $lvi){

            /*Tarjeta de operacion*/
                if ($lvi['licencia_transito'] == '') {
                    $html .= '<p><strong>Licencia de Transito</strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['licencia_transito'].'" target="_blank"><strong>Licencia de Transito</strong><span class="fa fa-file-text ml-3"></span></a>' . '<hr>';
                }

            /*Tarjeta de operacion*/
                if ($lvi['tarjeta_operacion'] == '') {
                    $html .= '<p><strong>Tarjeta de Operación</strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['tarjeta_operacion'].'" target="_blank"><strong>Tarjeta de Operación</strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_to'] . '<br>' . '<hr>';
                }


            /*Soat*/
                if ($lvi['soat'] == '') {
                    $html .= '<p><strong>Soat</strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['soat'].'" target="_blank"><strong>Soat </strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_soat'] . '<br>' . '<hr>';
                }


            /*Revision Tecnomecanica*/
                if ($lvi['revision_tecnomecanica'] == '') {
                    $html .= '<p><strong>Revision Tecnomecanica</strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['revision_tecnomecanica'].'" target="_blank"><strong>Revision Tecnomecanica </strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_rt'] . '<br>' . '<hr>';
                }


            /*Revision Preventiva*/
                if ($lvi['revision_preventiva'] == '') {
                    $html .= '<p><strong>Revision Preventiva </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['revision_preventiva'].'" target="_blank"><strong>Revision Preventiva </strong><span class="fa fa-file-text"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_rp'] . '<br>'. '<hr>';
                }


            /*Polizas contra*/
                if ($lvi['poliza_contra'] == '') {
                    $html .= '<p><strong>Poliza Contractual </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['poliza_contra'].'" target="_blank"><strong>Poliza Contractual </strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_contra']. '<br>'. '<hr>';
                }


            /*Polizas extra*/
                if ($lvi['poliza_extra'] == '') {
                    $html .= '<p><strong>Poliza Extra Contractual </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['poliza_extra'].'" target="_blank"><strong>Poliza Extra Contractual</strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_vencimiento_extra']. '<br>'. '<hr>';
                }


            /*Dispositivo velicidad*/
                if ($lvi['disp_velocidad'] == '') {
                    $html .= '<p><strong>Dispositivo de Velocidad </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['disp_velocidad'].'" target="_blank"><strong>Dispositivo de Velocidad</strong><span class="fa fa-file-text ml-3"></span></a>'. '  |  ' . $lvi['fecha_exp_disp_velocidad']. '<br>'. '<hr>';
                }
            
            

            /*Contrato Vinculación*/
                if ($lvi['contrato_vinculacion'] == '') {
                    $html .= '<p><strong>Contrato de Vinculación </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                        $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['contrato_vinculacion'].'" target="_blank"><strong>Contrato de Vinculación</strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }
            

            /*Ficha Tecnica de Homologación*/
                if ($lvi['ficha_tecnica_homologacion'] == '') {
                    $html .= '<p><strong>Ficha Tecnica de Homologación </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                        $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['ficha_tecnica_homologacion'].'" target="_blank"><strong>Ficha Tecnica de Homologación</strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }
            

            /*Seguro Todo Riesgo*/
                if ($lvi['seguro_todo_riesgo'] == '') {
                    $html .= '<p><strong>Seguro Todo Riesgo </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                        $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['seguro_todo_riesgo'].'" target="_blank"><strong>Seguro Todo Riesgo</strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }


            /*Camara de Comercio*/
                if ($lvi['camara_comercio'] == '') {
                    $html .= '<p><strong>Camara de comercio </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                        $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['camara_comercio'].'" target="_blank"><strong>Camara de comercio </strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }


            /*Contrato banco*/
                if ($lvi['contrato_banco'] == '') {
                    $html .= '<p><strong>Contrato Banco </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['contrato_banco'].'" target="_blank"><strong>Contrato Banco </strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }


            /*Hoja de Vida*/
                if ($lvi['hoja_vida'] == '') {
                    $html .= '<p><strong>Hoja de Vida </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['hoja_vida'].'" target="_blank"><strong>Hoja de Vida </strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }


            /*rut*/
                if ($lvi['rut'] == '') {
                    $html .= '<p><strong>Registro Único Tributario </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['rut'].'" target="_blank"><strong>Registro Único Tributario </strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }

            /*Contrato banco*/
                if ($lvi['poder_apoderado'] == '') {
                    $html .= '<p><strong>Poder Apoderado </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['poder_apoderado'].'" target="_blank"><strong>Poder Apoderado </strong><span class="fa fa-file-text ml-3"></span></a><br><hr>';
                }



            /*Fotocopia de la cedula del propietario*/
                if ($lvi['fotocopia_cedula_propietario'] == '') {
                    $html .= '<p><strong>Fotocopia de la cedula propietario </strong> | No hay documento cargado actualmente.</p><hr>';
                }else{
                    $html .= '<a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lvi['fotocopia_cedula_propietario'].'" target="_blank"><strong>Fotocopia de la cedula propietario </strong><span class="fa fa-file-text ml-3"></span></a></br>';
                }



            /* FOTOGRAFIAS VEHICULO*/

                $html .= '<div class="col-12 text-center">';
                        $html .= '<h6 class="mt-5"><strong>FOTOGRAFÍAS DEL VEHICULO</strong></h6>';
                $html .= '</div>';



                if($cant2 > 0){
                    foreach ($listarFotografiasPorIdVehiculo as $lfpiv) {
                        $html .= '<div class="row text-center">';
                            if ($lfpiv['fotografia_frontal'] == '') {
                                $html .= '<div class="col-12 text-center">';   
                                    $html .= '<p class="mt-3" style="font-size:.8rem;"><strong>NO TIENE FOTOGRAFÍAS CARGADAS ACTUALMENTE</strong></p>';
                                $html .= '</div>';
                            }else{
                                /*Fotografia frontal*/
                                if (file_exists($ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_frontal'])) {
                                    
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $html .= '</br><a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_frontal'] .' "  target="_blank"><img style="width: 100%;" class="img-frontal" src="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_frontal'] .'" /></a></br>';
                                    $html .= '</div>';

                                }else{
                                    $html .= '<div class="col-12 text-center">';   
                                        $html .= '<p class="mt-3" style="font-size:.8rem;">NO SE ENCONTRO FOTOGRAFIA FRONTAL CARGADA EN EL SERVIDOR.</p>';
                                    $html .= '</div>';
                                }


                                if (file_exists($ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_trasera'])) {
                                /*Fotografia Trasera*/
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $html .= '</br><a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_trasera'] .'"  target="_blank"><img style="width: 100%;" class="img-trasera" src="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_trasera'] .'" /></a></br>';
                                    $html .= '</div>';

                                }else{
                                    $html .= '<div class="col-12 text-center">';   
                                        $html .= '<p class="mt-3" style="font-size:.8rem;">NO SE ENCONTRO FOTOGRAFIA TRASERA CARGADA EN EL SERVIDOR.</p>';
                                    $html .= '</div>';
                                }



                                if (file_exists($ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_lateral_izq'])) {
                                /*Fotografia lateral izquierda*/
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $html .= '</br><a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_lateral_izq'] .'"  target="_blank"><img style="width: 100%;" class="img-izq" src="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_lateral_izq'] .'" /></a></br>';
                                    $html .= '</div>';

                                }else{
                                    $html .= '<div class="col-12 text-center" >';   
                                        $html .= '<p class="mt-3" style="font-size:.8rem;">NO SE ENCONTRO FOTOGRAFIA LATERAL IZQ CARGADA EN EL SERVIDOR.</p>';
                                    $html .= '</div>';
                                }



                                if (file_exists($ip . '/Vehiculos/'. $lvi['placa'] .'/'. $lfpiv['fotografia_lateral_der'])) {
                                /*Fotografia lateral derecha*/
                                    $html .= '<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">';
                                            $html .= '</br><a href="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_lateral_der'] .'"  target="_blank"><img style="width: 100%;" class="img-der" src="' . $ip . '/Vehiculos/'. $lvi['placa'] .'/'.$lfpiv['fotografia_lateral_der'] .'" /></a></br>';
                                    $html .= '</div>';

                                }else{
                                    $html .= '<div class="col-12 text-center">';   
                                        $html .= '<p class="mt-3" style="font-size:.8rem;">NO SE ENCONTRO FOTOGRAFIA LATERAL DER CARGADA EN EL SERVIDOR.</p>';
                                    $html .= '</div>';
                                }

                            }

                        $html .= '</div>';  
                    }

                } else {   
                    $html .= '<div class="col-12 text-center">';         
                        $html .= '<h5>No tiene fotografias cargadas actualmente.</h5>';    
                    $html .= '</div>'; 
                }
        }

    }else{
            $html .= '<p class="text-center"><strong>SIN DOCUMENTOS</strong></p>';
    } 



$html .= '</div>';

echo $html;





?>