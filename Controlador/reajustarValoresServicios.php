<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$operativo = new Operativo();

$servicios = $_POST['id_servicios'];

for ($i=0; $i < count($servicios); $i++) { 
    
    $listarServicioPorID = $operativo->listarServiciosPorID($servicios[$i]);
    
    if($listarServicioPorID[0]['id_producto'] != 0){
        
        $listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($servicios[$i]);
        $listarProductosPorID = $operativo->listarProductosPorID($listarServicioPorID[0]['id_producto']);

        for ($j=0; $j < count($listarVehiculosPorServicioID); $j++) { 
                
            $servicio = json_decode($listarVehiculosPorServicioID[$j]['servicio']);
            $tipoVehiculoCliente = json_decode($listarVehiculosPorServicioID[$i]['clase_vehiculo']);
        
            if($servicio->{'entrada'} == 1){

                $cliente = $tipoVehiculoCliente->{'entrada'}->{'cliente'};

                if($tipoVehiculoCliente->{'entrada'}->{'movil'} == ""){
                    $movil = $cliente;
                }else{
                    $movil = $tipoVehiculoCliente->{'entrada'}->{'movil'};
                }

                $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[0]['id_producto'], $cliente);

                if($cliente != $movil){
                    
                    $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[0]['id_producto'], $cliente);
                    $listarTVMovil = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[0]['id_producto'], $movil);
                    
                    /*---------------- VALOR RECORRIDO ----------------*/
                    
                        if ($listarTVCliente[0]['valor_recorrido'] != NULL) {
                    
                            $val_recorrido_cliente = json_decode($listarTVCliente[0]['valor_recorrido']);
                
                            $val_cliente_entrada = $val_recorrido_cliente->{'cliente'};
                
                        }

                        if ($listarTVMovil[0]['valor_recorrido'] != NULL) {
                    
                            $val_recorrido_movil = json_decode($listarTVMovil[0]['valor_recorrido']);
                
                            $val_movil_entrada = $val_recorrido_movil->{'movil'};
                
                        }

                    /*-------------------------------------------------*/

                    /*---------------- VALOR HORA ----------------*/

                        if ($listarTVCliente[0]['valor_hora'] != NULL) {
                            
                            $val_hora_cliente = json_decode($listarTVCliente[0]['valor_hora']);
                
                            $date1_cliente = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_inicio'] . " " . $listarServicioPorID[0]['hora_inicio']));
                            $date2_cliente = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_final'] . " " . $listarServicioPorID[0]['hora_final']));
                            
                            $date1_cliente = new DateTime($date1_cliente);
                            $date2_cliente = new DateTime($date2_cliente);
                
                            $diff_cliente = $date1_cliente->diff($date2_cliente);
                
                            $min_cliente = ($diff_cliente->d * 24 * 60);
                            $min_cliente += ($diff_cliente->h * 60);
                            $min_cliente += ($diff_cliente->i);
                
                            $val_cliente_entrada = round($val_hora_cliente->{'cliente'} * ($min_cliente / 60));
                        }

                        if ($listarTVMovil[0]['valor_hora'] != NULL) {
                            
                            $val_hora_movil = json_decode($listarTVMovil[0]['valor_hora']);
                
                            $date1_movil = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_inicio'] . " " . $listarServicioPorID[0]['hora_inicio']));
                            $date2_movil = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_final'] . " " . $listarServicioPorID[0]['hora_final']));
                            
                            $date1_movil = new DateTime($date1_movil);
                            $date2_movil = new DateTime($date2_movil);
                
                            $diff_movil = $date1_movil->diff($date2_movil);
                
                            $min_movil = ($diff_movil->d * 24 * 60);
                            $min_movil += ($diff_movil->h * 60);
                            $min_movil += ($diff_movil->i);
            
                            $val_movil_entrada = round($val_hora_movil->{'movil'} * ($min_movil / 60));
                        }
                    
                    /*--------------------------------------------*/

                    /*---------------- VALOR MENSUAL -----------------*/
                    
                        $listarServiciosPorProducto = $operativo->listarServiciosPorProducto($listarServicioPorID[0]['id_producto']);

                        if (($listarTVCliente[0]['recorridos_x_dia'] != NULL) && ($listarTVCliente[0]['valor_mensual'] != NULL)) {
                            
                            $recorridos_x_dia_cliente = json_decode($listarTVCliente[0]['recorridos_x_dia']);
                            $val_mensual_cliente = json_decode($listarTVCliente[0]['valor_mensual']);
                
                            if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){
                                $days_cliente = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                            }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                                $month_start_cliente = strtotime('first day of this month', time());
                                $month_end_cliente = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                                $ultimoDía_cliente = date('Y-m-d', $month_end_cliente);
                                $festivo_cliente = 'SD';
                
                                $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDía_cliente, $festivo_cliente);
                            }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                                $month_start_cliente = strtotime('first day of this month', time());
                                $month_end_cliente = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                                $ultimoDía_cliente = date('Y-m-d', $month_end_cliente);
                                $festivo_cliente = 'S';
                
                                $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDía_cliente, $festivo_cliente);
                            }
                            
                            $val_cliente_entrada = round($val_mensual_cliente->{'cliente'} / ($recorridos_x_dia_cliente->{'cliente'} * $days_cliente));
                            
                        }else{
                            $val_movil_entrada = round($val_mensual_cliente->{'cliente'} / count($listarServiciosPorProducto));
                        }

                        if (($listarTVMovil[0]['recorridos_x_dia'] != NULL) && ($listarTVMovil[0]['valor_mensual'] != NULL)) {
                            
                            $recorridos_x_dia_movil = json_decode($listarTVMovil[0]['recorridos_x_dia']);
                            $val_mensual_movil = json_decode($listarTVMovil[0]['valor_mensual']);
                
                            if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){

                                $days_movil = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                                
                            }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                                $month_start_movil = strtotime('first day of this month', time());
                                $month_end_movil = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia_movil = date('Y-m-d', $month_start_movil);
                                $ultimoDía_movil = date('Y-m-d', $month_end_movil);
                                $festivo_movil = 'SD';
                
                                $days_movil = $festivos->daysWeek($primerDia_movil, $ultimoDía_movil, $festivo_movil);
                            }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                                $month_start_movil = strtotime('first day of this month', time());
                                $month_end_movil = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia_movil = date('Y-m-d', $month_start_movil);
                                $ultimoDía_movil = date('Y-m-d', $month_end_movil);
                                $festivo_movil = 'S';
                
                                $days_movil = $festivos->daysWeek($primerDia_movil, $ultimoDía_movil, $festivo_movil);
                            }
                            
                            $val_movil_entrada = round($val_mensual_movil->{'movil'} / ($recorridos_x_dia_movil->{'movil'} * $days_movil));
                            
                        }else{
                            if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_ALEATORIOS'){
                                $val_movil_entrada = round($val_mensual_movil->{'movil'} / count($listarServiciosPorProducto));
                            }
                        }
                        
                    /* ------------------------------------------------ */

                }else{

                    $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[0]['id_producto'], $cliente);
                    
                    if ($listarTVCliente[0]['valor_recorrido'] != NULL) {
                
                        $val_recorrido_cliente = json_decode($listarTVCliente[0]['valor_recorrido']);
            
                        $val_cliente_entrada = $val_recorrido_cliente->{'cliente'};
                        $val_movil_entrada = $val_recorrido_cliente->{'movil'};
            
                    }
            
                    if ($listarTVCliente[0]['valor_hora'] != NULL) {
                        
                        $val_hora_cliente = json_decode($listarTVCliente[0]['valor_hora']);
            
                        $date1_cliente = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_inicio'] . " " . $listarServicioPorID[0]['hora_inicio']));
                        $date2_cliente = date("Y-m-d H:i:s", strtotime($listarServicioPorID[0]['fecha_final'] . " " . $listarServicioPorID[0]['hora_final']));
                        
                        $date1_cliente = new DateTime($date1_cliente);
                        $date2_cliente = new DateTime($date2_cliente);
            
                        $diff_cliente = $date1_cliente->diff($date2_cliente);
            
                        $min_cliente = ($diff_cliente->d * 24 * 60);
                        $min_cliente += ($diff_cliente->h * 60);
                        $min_cliente += ($diff_cliente->i);
            
                        $val_cliente_entrada = round($val_hora_cliente->{'cliente'} * ($min_cliente / 60));
                        $val_movil_entrada = round($val_hora_cliente->{'movil'} * ($min_cliente / 60));
                    }
            
                    if (($listarTVCliente[0]['recorridos_x_dia'] != NULL) && ($listarTVCliente[0]['valor_mensual'] != NULL)) {
                        
                        $recorridos_x_dia_cliente = json_decode($listarTVCliente[0]['recorridos_x_dia']);
                        $val_mensual_cliente = json_decode($listarTVCliente[0]['valor_mensual']);
            
                        if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){
                            $days_cliente = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                        }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                            $month_start_cliente = strtotime('first day of this month', time());
                            $month_end_cliente = strtotime('last day of this month', time());
            
                            /*------------------------------------*/
                            $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                            $ultimoDia_cliente = date('Y-m-d', $month_end_cliente);
                            $festivo_cliente = 'SD';
            
                            $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDia_cliente, $festivo_cliente);
                        }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                            $month_start_cliente = strtotime('first day of this month', time());
                            $month_end_cliente = strtotime('last day of this month', time());
            
                            /*------------------------------------*/
                            $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                            $ultimoDia_cliente = date('Y-m-d', $month_end_cliente);
                            $festivo_cliente = 'S';
            
                            $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDia_cliente, $festivo_cliente);
                        }
                        
                        $val_cliente_entrada = round($val_mensual_cliente->{'cliente'} / ($recorridos_x_dia_cliente->{'cliente'} * $days_cliente));
                        $val_movil_entrada = round($val_mensual_cliente->{'movil'} / ($recorridos_x_dia_cliente->{'movil'} * $days_cliente));
                       
                    }else{
                        if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_ALEATORIOS'){
                            $val_cliente_entrada = round($val_mensual_cliente->{'cliente'} / count($listarServiciosPorProducto));
                            $val_movil_entrada = round($val_mensual_cliente->{'movil'} / count($listarServiciosPorProducto));
                        }
                    }

                }
            
            }

            if($servicio->{'salida'} == 1){
                
                $cliente = $tipoVehiculoCliente->{'salida'}->{'cliente'};

                if($tipoVehiculoCliente->{'salida'}->{'movil'} == ""){
                $movil = $cliente;
                }else{
                    $movil = $tipoVehiculoCliente->{'salida'}->{'movil'};
                }


                $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[0]['id_producto'], $cliente);

                if($cliente != $movil){
                    
                    $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[$i]['id_producto'], $cliente);
                    $listarTVMovil = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[$i]['id_producto'], $movil);
                    
                    /*---------------- VALOR RECORRIDO ----------------*/
                    
                        if ($listarTVCliente[0]['valor_recorrido'] != NULL) {
                    
                            $val_recorrido = json_decode($listarTVCliente[0]['valor_recorrido']);
                
                            $val_cliente_salida = $val_recorrido->{'cliente'};
                
                        }

                        if ($listarTVMovil[0]['valor_recorrido'] != NULL) {
                    
                            $val_recorrido = json_decode($listarTVCliente[0]['valor_recorrido']);
                
                            $val_movil_salida = $val_recorrido->{'movil'};
                
                        }

                    /*-------------------------------------------------*/

                    /*---------------- VALOR HORA ----------------*/

                        if ($listarTVCliente[0]['valor_hora'] != NULL) {
                            
                            $val_hora = json_decode($listarTVCliente[0]['valor_hora']);
                
                            $date1 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_inicio'] . " " . $listarServicioPorID[$i]['hora_inicio']));
                            $date2 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_final'] . " " . $listarServicioPorID[$i]['hora_final']));
                            
                            $date1 = new DateTime($date1);
                            $date2 = new DateTime($date2);
                
                            $diff = $date1->diff($date2);
                
                            $min = ($diff->d * 24 * 60);
                            $min += ($diff->h * 60);
                            $min += ($diff->i);
                
                            $val_cliente_salida = round($val_hora->{'cliente'} * ($min / 60));
                        }

                        if ($listarTVMovil[0]['valor_hora'] != NULL) {
                            
                            $val_hora = json_decode($listarTVMovil[0]['valor_hora']);
                
                            $date1 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_inicio'] . " " . $listarServicioPorID[$i]['hora_inicio']));
                            $date2 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_final'] . " " . $listarServicioPorID[$i]['hora_final']));
                            
                            $date1 = new DateTime($date1);
                            $date2 = new DateTime($date2);
                
                            $diff = $date1->diff($date2);
                
                            $min = ($diff->d * 24 * 60);
                            $min += ($diff->h * 60);
                            $min += ($diff->i);
            
                            $val_movil_salida = round($val_hora->{'movil'} * ($min / 60));
                        }
                    
                    /*--------------------------------------------*/

                    /*---------------- VALOR MENSUAL -----------------*/

                        if (($listarTVCliente[0]['recorridos_x_dia'] != NULL) && ($listarTVCliente[0]['valor_mensual'] != NULL)) {
                            
                            $recorridos_x_dia = json_decode($listarTVCliente[0]['recorridos_x_dia']);
                            $val_mensual = json_decode($listarTVCliente[0]['valor_mensual']);
                
                            if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){
                                $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                            }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                                $month_start = strtotime('first day of this month', time());
                                $month_end = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia = date('Y-m-d', $month_start);
                                $ultimoDía = date('Y-m-d', $month_end);
                                $festivo = 'SD';
                
                                $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                            }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                                $month_start = strtotime('first day of this month', time());
                                $month_end = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia = date('Y-m-d', $month_start);
                                $ultimoDía = date('Y-m-d', $month_end);
                                $festivo = 'S';
                
                                $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                            }
                            
                
                            $val_cliente_salida = round($val_mensual->{'cliente'} / ($recorridos_x_dia->{'cliente'} * $days));

                        }

                        if (($listarTVMovil[0]['recorridos_x_dia'] != NULL) && ($listarTVMovil[0]['valor_mensual'] != NULL)) {
                            
                            $recorridos_x_dia = json_decode($listarTVMovil[0]['recorridos_x_dia']);
                            $val_mensual = json_decode($listarTVMovil[0]['valor_mensual']);
                
                            if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){
                                $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                            }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                                $month_start = strtotime('first day of this month', time());
                                $month_end = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia = date('Y-m-d', $month_start);
                                $ultimoDía = date('Y-m-d', $month_end);
                                $festivo = 'SD';
                
                                $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                            }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                                $month_start = strtotime('first day of this month', time());
                                $month_end = strtotime('last day of this month', time());
                
                                /*------------------------------------*/
                                $primerDia = date('Y-m-d', $month_start);
                                $ultimoDía = date('Y-m-d', $month_end);
                                $festivo = 'S';
                
                                $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                            }
                            
                            $val_movil_salida = round($val_mensual->{'movil'} / ($recorridos_x_dia->{'movil'} * $days));
                        }
                        
                    /*------------------------------------------------*/

                }else{

                    $listarTVCliente = $operativo->listarTarifasProductosPorIdYTipoVehiculo($listarServicioPorID[$i]['id_producto'], $cliente);
                    
                    if ($listarTVCliente[0]['valor_recorrido'] != NULL) {
                
                        $val_recorrido = json_decode($listarTVCliente[0]['valor_recorrido']);
            
                        $val_cliente_salida = $val_recorrido->{'cliente'};
                        $val_movil_salida = $val_recorrido->{'movil'};
            
                    }
            
                    if ($listarTVCliente[0]['valor_hora'] != NULL) {
                        
                        $val_hora = json_decode($listarTVCliente[0]['valor_hora']);
            
                        $date1 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_inicio'] . " " . $listarServicioPorID[$i]['hora_inicio']));
                        $date2 = date("Y-m-d H:i:s", strtotime($listarServicioPorID[$i]['fecha_final'] . " " . $listarServicioPorID[$i]['hora_final']));
                        
                        $date1 = new DateTime($date1);
                        $date2 = new DateTime($date2);
            
                        $diff = $date1->diff($date2);
            
                        $min = ($diff->d * 24 * 60);
                        $min += ($diff->h * 60);
                        $min += ($diff->i);
            
                        $val_cliente_salida = round($val_hora->{'cliente'} * ($min / 60));
                        $val_movil_salida = round($val_hora->{'movil'} * ($min / 60));
                    }
            
                    if (($listarTVCliente[0]['recorridos_x_dia'] != NULL) && ($listarTVCliente[0]['valor_mensual'] != NULL)) {
                        
                        $recorridos_x_dia = json_decode($listarTVCliente[0]['recorridos_x_dia']);
                        $val_mensual = json_decode($listarTVCliente[0]['valor_mensual']);
            
                        if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'TODOS'){
                            $days = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                        }else if ($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                            $month_start = strtotime('first day of this month', time());
                            $month_end = strtotime('last day of this month', time());
            
                            /*------------------------------------*/
                            $primerDia = date('Y-m-d', $month_start);
                            $ultimoDía = date('Y-m-d', $month_end);
                            $festivo = 'SD';
            
                            $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                        }else if($listarProductosPorID[$i]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
                            $month_start = strtotime('first day of this month', time());
                            $month_end = strtotime('last day of this month', time());
            
                            /*------------------------------------*/
                            $primerDia = date('Y-m-d', $month_start);
                            $ultimoDía = date('Y-m-d', $month_end);
                            $festivo = 'S';
            
                            $days = $festivos->daysWeek($primerDia, $ultimoDía, $festivo);
                        }
                        
            
                        $val_cliente_salida = round($val_mensual->{'cliente'} / ($recorridos_x_dia->{'cliente'} * $days));
                        $val_movil_salida = round($val_mensual->{'movil'} / ($recorridos_x_dia->{'movil'} * $days));
                    }

                }
            
            }
        
            $val_cliente = [
                'entrada' => $val_cliente_entrada,
                'salida' => $val_cliente_salida,
            ]; 

            $val_movil = [
                'entrada' => $val_movil_entrada,
                'salida' => $val_movil_salida,
            ]; 

            $val_clienteJSON = json_encode($val_cliente);
            $val_movilJSON = json_encode($val_movil);   
            
            $actualizarValoresServicio = $operativo->actualizarValoresServicio($servicios[$i], $val_clienteJSON, $val_movilJSON);
        
        }

        echo "Se han reajustado correctamente los valores.";

    }else{
        echo "No se pudo reajustar porque no tiene producto asignado (OCASIONAL)";
    }
    
}

?>