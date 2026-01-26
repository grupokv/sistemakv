<?php 
require_once("../Modelo/Vehiculo.php");

$vehiculo = new Vehiculo();
$listarV = $vehiculo->listarActivos();


$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

$fila = ($_POST['total_filas'] + 1);

$entrada = "'entrada'";
$salida = "'salida'";
$tarifaFija = "'fija'";
$tarifaDisponibilidad = "'disponibilidad'";
$tarifaRelevo = "'relevo'";
$cliente = "'cliente'";
$movil = "'movil'";


$html = '';

$html .= '<table id="table_' . $fila .'" style="text-align: center; width:100%;">';
    $html .= '<thead>';
        $html .= '<tr>';
            $html .= '<th width="60px;"></th>';
            $html .= '<th width="90px;">1</th>';
            $html .= '<th width="170px;"> CLASE VEH. </th>';
            $html .= '<th width="150px;">MOVIL</th>';
            $html .= '<th width="250px;">CONDUCTOR</th>';
            $html .= '<th width="150px;">MOV. RELEVO</th>';
            $html .= '<th width="70px;">CANT. PAX</th>';
            $html .= '<th width="100px;">KMS</th>';
            $html .= '<th width="145px;">VAL. CLIENTE</th>';
            $html .= '<th width="90px;">DESC. %</th>';
            $html .= '<th width="145px;">VAL. MOVIL</th>';
            $html .= '<th width="90px;">DESC. %</th>';
            $html .= '<th width="70px;">DISP.</th>';
        $html .= '</tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

        /* VEHÍCULO ENTRADA */


            $html .= '<tr style="border-bottom: 3px solid #f2f2f2;">';

                
                $html .= '<td rowspan="3">';
                    $html .= '<input type="checkbox" value="1" name="registroAsignacionVeh[]" id="registroAsignacionVeh' . $fila .'">';
                $html .= '</td>';

                $html .= '<td style="color: #274054">';
                    $html .= '<b>ENTRADA</b>';
                $html .= '</td>';

                $html .= '<td id="claseVehiculos" class="p-2" style="color: #274054">';

                    $html .= '<select class="form-control form-control-sm id_tv_cliente_entrada_new" data-live-search="true" name="id_tv_cliente_entrada[]" id="id_tv_cliente_entrada' . $fila . '">';
                        $html .= '<option value="" style="background-color: #fff !important;">CLIENTE</option>';
                    $html .= '</select>';
                    $html .= '<hr>';
                    $html .= '<select class="form-control form-control-sm  id_tv_movil_entrada_new" data-live-search="true" name="id_tv_movil_entrada[]" id="id_tv_movil_entrada' . $fila . '">';
                        $html .= '<option value="">MOVIL</option>';
                    $html .= '</select>';

                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_vehiculo_entrada[]" id="id_vehiculo_entrada'. $fila .'" onchange="listarConductoresPorVehiculo(this.value, '. $entrada . ', ' . $fila . '); validarTarifasClaseVeh(' . $tarifaFija . ', '. $entrada . ', ' . $fila . ')" >';

                        $html .= '<option value="">SELECCIONAR</option>';
                        foreach ($listarV as $lv){ 

                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                            if (count($documentosvencidosPorId) > 0) {
                                $html .= '<option value="' . $lv['id_vehiculo'] . '"disabled style="color:red;font-weight:bolder">' . $lv['placa'] .'</option>';
                            } else { 
                                $html .= '<option value="'. $lv['id_vehiculo'] . '">' . $lv['placa'] . '</option>';
                            }
                            
                        }
                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_conductor_entrada[]" id="id_conductor_entrada'. $fila .'">';
                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_veh_relevo_entrada[]" id="id_veh_relevo_entrada'. $fila .'">';
                        $html .= '<option value="">SELECCIONAR</option>';
                        foreach ($listarV as $lv){ 

                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                            if (count($documentosvencidosPorId) > 0) {
                                $html .= '<option value="' . $lv['id_vehiculo'] . '"disabled style="color:red;font-weight:bolder">' . $lv['placa'] .'</option>';
                            } else { 
                                $html .= '<option value="'. $lv['id_vehiculo'] . '">' . $lv['placa'] . '</option>';
                            }
                            
                        }
                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="cant_pax_entrada[]" id="cant_pax_entrada'. $fila .'" placeholder="PAX">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="kms_entrada[]" id="kms_entrada'. $fila .'" placeholder="KMS">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<div>';
                        $html .= '<input type="text" onkeyup="convertirValorCliente(this.value, ' . $entrada. ',' . $fila. ');" class="form-control form-control-sm input_vehiculos" name="valor_cliente_entrada[]" id="valor_cliente_entrada'. $fila .'" placeholder="VALOR">';
                    $html .= '</div>';
                    
                    $html .= '<div class="col-12" id="valorClienteEntrada' . $fila. '">';
                    $html .= '</div>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="descuento_cliente_entrada[]" id="descuento_cliente_entrada'. $fila .'" placeholder="%" onBlur="aplicarDescuento(this.value, '.$cliente.', '.$entrada.', '.$fila.');">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<div class="col-12">';
                        $html .= '<input type="text" onkeyup="convertirValorMovil(this.value, ' . $entrada. ',' . $fila. ');" class="form-control form-control-sm input_vehiculos" name="valor_movil_entrada[]" id="valor_movil_entrada'. $fila .'" placeholder="VALOR">';
                    $html .= '</div>';
                    $html .= '<div class="col-12" id="valorMovilEntrada' . $fila. '">';
                    $html .= '</div>';
               $html .= '</td>';

               $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="descuento_movil_entrada[]" id="descuento_movil_entrada'. $fila .'" placeholder="%" onBlur="aplicarDescuento(this.value, '.$movil.', '.$entrada.', '.$fila.');">';
                $html .= '</td>';
                

                $html .= '<td>';
                    $html .= '<input type="checkbox" id="identificador_entrada'. $fila .'" name="identificador_entrada[]" onclick="validarTarifasClaseVeh('. $tarifaDisponibilidad .', '. $entrada .', '. $fila .');" />';
                $html .= '</td>';
            $html .= '</tr>';


        /* VEHÍCULO SALIDA */
            $html .= '<tr style="border-bottom: 3px solid #f2f2f2;">';
                $html .= '<td style="color: #274054">';
                    $html .= '<b>SALIDA</b>';
                $html .= '</td>';
                $html .= '<td id="claseVehiculos" class="p-2" style="color: #274054">';

                    $html .= '<select class="form-control form-control-sm id_tv_cliente_salida_new" data-live-search="true" name="id_tv_cliente_salida[]" id="id_tv_cliente_salida' . $fila . '">';
                        $html .= '<option value="" style="background-color: #fff !important;">CLIENTE</option>';
                    $html .= '</select>';
                        
                    $html .= '<hr>';

                    $html .= '<select class="form-control form-control-sm id_tv_movil_salida_new" data-live-search="true" name="id_tv_movil_salida[]" id="id_tv_movil_salida' . $fila . '">';
                        $html .= '<option value="">MOVIL</option>';
                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_vehiculo_salida[]" id="id_vehiculo_salida'. $fila .'" onchange="listarConductoresPorVehiculo(this.value, ' . $salida .', '. $fila .'); validarTarifasClaseVeh('. $tarifaFija .', '.$salida .', '. $fila .');">';
                        $html .= '<option value="">SELECCIONAR</option>';
                        
                        foreach ($listarV as $lv){ 

                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                            if (count($documentosvencidosPorId) > 0) {
                                $html .= '<option value="' . $lv['id_vehiculo'] . '"disabled style="color:red;font-weight:bolder">' . $lv['placa'] .'</option>';
                            } else { 
                                $html .= '<option value="'. $lv['id_vehiculo'] . '">' . $lv['placa'] . '</option>';
                            }
                            
                        }

                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_conductor_salida[]" id="id_conductor_salida'.$fila.'">';
                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<select class="form-control form-control-sm" data-live-search="true" name="id_veh_relevo_salida[]" id="id_veh_relevo_salida'. $fila .'" onchange="validarTarifasClaseVeh('. $tarifaRelevo .', '.$salida .', '. $fila .');">';
                        $html .= '<option value="">SELECCIONAR</option>';

                        foreach ($listarV as $lv){ 

                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                            if (count($documentosvencidosPorId) > 0) {
                                $html .= '<option value="' . $lv['id_vehiculo'] . '"disabled style="color:red;font-weight:bolder">' . $lv['placa'] .'</option>';
                            } else { 
                                $html .= '<option value="'. $lv['id_vehiculo'] . '">' . $lv['placa'] . '</option>';
                            }
                            
                        }

                    $html .= '</select>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="cant_pax_salida[]" id="cant_pax_salida'.$fila.'" placeholder="PAX">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="kms_salida[]" id="kms_salida'.$fila.'" placeholder="KMS">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<div>';
                        $html .= '<input type="text" onkeyup="convertirValorCliente(this.value, '.$salida.', '.$fila.');" class="form-control form-control-sm input_vehiculos" name="valor_cliente_salida[]" id="valor_cliente_salida'.$fila.'" placeholder="VALOR">';
                    $html .= '</div>';
                    $html .= '<div class="col-12" id="valorClienteSalida'.$fila.'">';
                        
                    $html .= '</div>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="descuento_cliente_salida[]" id="descuento_cliente_salida'.$fila.'" placeholder="%" onBlur="aplicarDescuento(this.value, '.$cliente.', '.$salida.', '.$fila.');">';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<div class="col-12">';
                        $html .= '<input type="text" onkeyup="convertirValorMovil(this.value, '.$salida.', '.$fila.');" class="form-control form-control-sm input_vehiculos" name="valor_movil_salida[]" id="valor_movil_salida'.$fila.'" placeholder="VALOR">';
                    $html .= '</div>';
                    $html .= '<div class="col-12" id="valorMovilSalida'.$fila.'">';
                    $html .= '</div>';
                $html .= '</td>';

                $html .= '<td>';
                    $html .= '<input type="text" class="form-control form-control-sm input_vehiculos" name="descuento_movil_salidaa[]" id="descuento_movil_salidaa'.$fila.'" placeholder="%" onBlur="aplicarDescuento(this.value, '.$movil.', '.$salida.', '.$fila.');">';
                $html .= '</td>';


                $html .= '<td>';
                    $html .= '<input type="checkbox" id="identificador_salida'.$fila.'" name="identificador_salida[]" onclick="validarTarifasClaseVeh('.$tarifaDisponibilidad.', '.$salida.', '.$fila.');" />';
                $html .= '</td>';
            $html .= '</tr>';
       
    $html .= '</tbody>';
$html .= '</table>';


echo $html;

?>

