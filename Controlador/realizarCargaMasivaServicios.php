<?php

include ("../Controlador/Sesion/autenticar.php");
require_once ('../Resources/PHPExcel-1.8/Classes/PHPExcel.php');
require_once ('../Modelo/Operativo.php');
require_once ('../Modelo/Conductor.php');
require_once ('../Modelo/Vehiculo.php');
require_once("../Modelo/Festivos.php");

$operativo = new Operativo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$festivos = new Festivos();

//$archivo = "../Plantilla Carga Masiva.xlsx";
$archivo = $_FILES['doc_carga_masiva']['tmp_name'];
//$archivo = $_FILES['name']['doc_carga_masiva'];

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);

$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow(); 
$highestColumn = $sheet->getHighestColumn();

for ($row = 2; $row <= $highestRow; $row++){ 

    $id_cliente = $sheet->getCell("A".$row)->getValue();
    $id_contrato = $sheet->getCell("B".$row)->getValue();
    $fecha_inicio = $sheet->getCell("C".$row)->getFormattedValue();
    $hora_inicio = $sheet->getCell("D".$row)->getFormattedValue();
    $fecha_final = $sheet->getCell("E".$row)->getFormattedValue();
    $hora_final = $sheet->getCell("F".$row)->getFormattedValue();
    $divison = $sheet->getCell("G".$row)->getValue();
    $tipo_servicio = $sheet->getCell("H".$row)->getValue();
    $producto = "%" . $sheet->getCell("I".$row)->getValue() . "%";
    $listarProductosPorID= $operativo->listarProductosPorNombreYCliente($id_cliente, $producto);
    
    if($sheet->getCell("I".$row)->getValue() != ""){
        $id_producto = $listarProductosPorID[0]['id_producto'];
    }else{
        $id_producto = 0;
    }

    $grupo = $sheet->getCell("J".$row)->getValue();
    $clase_veh_entrada = "%" . $sheet->getCell("K".$row)->getValue() . "%";

    if($sheet->getCell("K".$row)->getValue() != ""){
        $listarClasesMovilEntrada = $operativo->listarClasesMovilPorNombreYCliente($id_cliente, $clase_veh_entrada);
        $id_clase_veh_entrada = $listarClasesMovilEntrada[0]['id'];
    }else{
        $id_clase_veh_entrada = "";
    }

    $vehiculo_entrada = $sheet->getCell("L".$row)->getValue();
    $listarVehEntrada = $vehiculo->listarPorPlaca($vehiculo_entrada);
    $id_vehiculo_entrada = $listarVehEntrada[0]['id_vehiculo'];

    $conductor_entrada = explode(" - ", $sheet->getCell("M".$row)->getValue());
    $buscarConductorPorDocumentoEntrada = $conductor->buscarConductorPorDocumento($conductor_entrada[0]);
    $id_conductor_entrada = $buscarConductorPorDocumentoEntrada[0]['id_conductor'];

    $cant_pax_entrada = $sheet->getCell("N".$row)->getValue();
    $kms_entrada = $sheet->getCell("O".$row)->getValue();
    
    $clase_veh_salida = "%" . $sheet->getCell("P".$row)->getValue() . "%";

    if($sheet->getCell("P".$row)->getValue() != ""){
        $listarClasesMovilSalida = $operativo->listarClasesMovilPorNombreYCliente($id_cliente, $clase_veh_salida);
        $id_clase_veh_salida = $listarClasesMovilSalida[0]['id'];
    }else{
        $id_clase_veh_salida = "";
    }

    $vehiculo_salida = $sheet->getCell("Q".$row)->getValue();
    $listarVehSalida = $vehiculo->listarPorPlaca($vehiculo_salida);
    $id_vehiculo_salida = $listarVehSalida[0]['id_vehiculo'];

    $conductor_salida = explode(" - ", $sheet->getCell("R".$row)->getValue());
    $buscarConductorPorDocumentoSalida = $conductor->buscarConductorPorDocumento($conductor_salida[0]);
    $id_conductor_salida = $buscarConductorPorDocumentoSalida[0]['id_conductor'];

    $cant_pax_salida = $sheet->getCell("S".$row)->getValue();
    $kms_salida = $sheet->getCell("T".$row)->getValue();
    $solicitante = $sheet->getCell("U".$row)->getValue();
    $observaciones = $sheet->getCell("V".$row)->getValue();
    $requisitos = $sheet->getCell("W".$row)->getValue();
    $origen = $sheet->getCell("X".$row)->getValue();
    $destino = $sheet->getCell("Y".$row)->getValue();
    $valor_total_cliente = $sheet->getCell("Z".$row)->getValue();
    $valor_total_movil = $sheet->getCell("AA".$row)->getValue();

    if((isset($id_clase_veh_entrada)) && (isset($id_clase_veh_salida))){
        $estado = 'A';
    }else{
        $estado = 'PA';
    }

    $id_usuario_creador = $_SESSION['id_usuario'];
    $fecha_creacion = date('Y-m-d H:i:s');

    /* ----------------------------------------------------------*/
    /* ------------------ REGISTRO SERVICIO -------------------- */
    /* ----------------------------------------------------------*/

    $registrarServicio = $operativo->registrarServicio($id_cliente, $id_contrato, $id_producto, $divison, $tipo_servicio, $grupo, $solicitante, $fecha_inicio, $hora_inicio, $origen, $destino, $fecha_final, $hora_final, $observaciones, $requisitos, $estado, $id_usuario_creador, $fecha_creacion);

    /* ----------------------------------------------------------*/
    /* --------------- REGISTRO VEHICULO SERVICIO ---------------*/
    /* ----------------------------------------------------------*/

    if ($sheet->getCell("K".$row)->getValue() != "") {
        $entrada = 1;
        $listarTarifasEntradas = $operativo->listarTarifasProductosPorIdYTipoVehiculo($id_producto, $id_clase_veh_entrada);

    }else{
        $entrada = 0;
    }
    
    if ($sheet->getCell("P".$row)->getValue() != "") {
        $salida = 1;
        $listarTarifasSalidas = $operativo->listarTarifasProductosPorIdYTipoVehiculo($id_producto, $id_clase_veh_salida);    
    }else{
        $salida = 0;
    }

    if($tipo_servicio == 'FIJO'){
        
        /* VALOR ENTRADA */
        if ($entrada != 0) {

            if (count($listarTarifasEntradas) > 0) {

                if ($listarTarifasEntradas[0]['valor_recorrido'] != NULL) {
                
                    $val_recorrido_cliente = json_decode($listarTarifasEntradas[0]['valor_recorrido']);
        
                    $val_cliente_entrada = $val_recorrido_cliente->{'cliente'};
                    $val_movil_entrada = $val_recorrido_cliente->{'movil'};
        
                }
        
                if ($listarTarifasEntradas[0]['valor_hora'] != NULL) {
                    
                    $val_hora_cliente = json_decode($listarTarifasEntradas[0]['valor_hora']);
        
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
        
                if (($listarTarifasEntradas[0]['recorridos_x_dia'] != NULL) && ($listarTarifasEntradas[0]['valor_mensual'] != NULL)) {
                    
                    $recorridos_x_dia_cliente = json_decode($listarTarifasEntradas[0]['recorridos_x_dia']);
                    $val_mensual_cliente = json_decode($listarTarifasEntradas[0]['valor_mensual']);
                    
                    if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'TODOS'){
                        $days_cliente = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                    }else if ($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                        $month_start_cliente = strtotime('first day of this month', time());
                        $month_end_cliente = strtotime('last day of this month', time());
        
                        /*------------------------------------*/
                        $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                        $ultimoDia_cliente = date('Y-m-d', $month_end_cliente);
                        $festivo_cliente = 'SD';
        
                        $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDia_cliente, $festivo_cliente);
                    }else if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
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
                    if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_ALEATORIOS'){
                        $val_cliente_entrada = round($val_mensual_cliente->{'cliente'} / count($listarServiciosPorProducto));
                        $val_movil_entrada = round($val_mensual_cliente->{'movil'} / count($listarServiciosPorProducto));
                    }
                }
            }

        }else{
            $val_cliente_entrada = 0;
            $val_movil_entrada = 0;
        }

        /* VALOR SALIDA */
        if ($salida != 0) {
            if (count($listarTarifasSalidas) > 0) {

                $val_cliente_salida = 0;
                $val_movil_salida = 0;

                if ($listarTarifasSalidas[0]['valor_recorrido'] != NULL) {
                
                    $val_recorrido_cliente = json_decode($listarTarifasSalidas[0]['valor_recorrido']);
        
                    $val_cliente_entrada = $val_recorrido_cliente->{'cliente'};
                    $val_movil_entrada = $val_recorrido_cliente->{'movil'};
                }
        
                if ($listarTarifasSalidas[0]['valor_hora'] != NULL) {
                    
                    $val_hora_cliente = json_decode($listarTarifasSalidas[0]['valor_hora']);
        
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
        
                if (($listarTarifasSalidas[0]['recorridos_x_dia'] != NULL) && ($listarTarifasSalidas[0]['valor_mensual'] != NULL)) {
                    
                    $recorridos_x_dia_cliente = json_decode($listarTarifasSalidas[0]['recorridos_x_dia']);
                    $val_mensual_cliente = json_decode($listarTarifasSalidas[0]['valor_mensual']);
                    
                    if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'TODOS'){
                        $days_cliente = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
                    }else if ($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES') {
                        $month_start_cliente = strtotime('first day of this month', time());
                        $month_end_cliente = strtotime('last day of this month', time());
        
                        /*------------------------------------*/
                        $primerDia_cliente = date('Y-m-d', $month_start_cliente);
                        $ultimoDia_cliente = date('Y-m-d', $month_end_cliente);
                        $festivo_cliente = 'SD';
        
                        $days_cliente = $festivos->daysWeek($primerDia_cliente, $ultimoDia_cliente, $festivo_cliente);
                    }else if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_HABILES_SABADOS'){
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
                    if($listarProductosPorID[0]['dias_aplicados_mensualidad'] == 'DIAS_ALEATORIOS'){
                        $val_cliente_entrada = round($val_mensual_cliente->{'cliente'} / count($listarServiciosPorProducto));
                        $val_movil_entrada = round($val_mensual_cliente->{'movil'} / count($listarServiciosPorProducto));
                    }
                }

            }
        }else{
            $val_cliente_salida = 0;
            $val_movil_salida = 0;
        }  

    }else if($tipo_servicio == 'OCASIONAL'){

        if ($entrada != 0 && $salida != 0) {

            $valor_cliente = ($valor_total_cliente / 2);
            $valor_movil = ($valor_total_movil / 2);
    
            /* VALOR ENTRADA */
            $val_cliente_entrada = $valor_cliente; 
            $val_movil_entrada = $valor_movil; 

            /* VALOR SALIDA */
            $val_cliente_salida = $valor_cliente; 
            $val_movil_salida = $valor_movil; 

        }else if ($entrada != 0 && $salida == 0) {
            
            $val_cliente_entrada = $valor_total_cliente; 
            $val_movil_entrada = $valor_total_movil; 

            $val_cliente_salida = 0;
            $val_movil_salida = 0;
            
        }else if ($entrada == 0 && $salida != 0) {
            
            $val_cliente_entrada = 0;
            $val_movil_entrada = 0;

            $val_cliente_salida = $valor_total_cliente; 
            $val_movil_salida = $valor_total_movil; 

        }

    }
    
    $servicio = [
        'entrada' => $entrada,
        'salida' => $salida,
    ];

    $clase_veh = [
        'entrada' => [
            'cliente' => $id_clase_veh_entrada,
            'movil' => $id_clase_veh_entrada,
        ],
        'salida' => [
            'cliente' => $id_clase_veh_salida,
            'movil' => $id_clase_veh_salida,
        ]
    ];

    $id_veh = [
        'entrada' => $id_vehiculo_entrada,
        'salida' => $id_vehiculo_salida,
    ];


    $id_cond = [
        'entrada' => $id_conductor_entrada,
        'salida' => $id_conductor_salida,
    ];

    $id_veh_relevo = [
        'entrada' => null,
        'salida' => null,
    ];

    $cant_pax = [
        'entrada' => $cant_pax_entrada,
        'salida' => $cant_pax_salida,
    ];

    $kms = [
        'entrada' => $kms_entrada,
        'salida' => $kms_salida,
    ];

    $val_cliente = [
        'entrada' => $val_cliente_entrada,
        'salida' => $val_cliente_salida,
    ];

    $descuento = [
        'entrada' => null,
        'salida' => null,
    ];

    $val_movil = [
        'entrada' => $val_movil_entrada,
        'salida' => $val_movil_salida,
    ];

    $disp = [
        'entrada' => null,
        'salida' => null,
    ];

    $servicioJSON = json_encode($servicio);
    $clase_vehJSON = json_encode($clase_veh);
    $id_vehJSON = json_encode($id_veh);
    $id_condJSON = json_encode($id_cond);
    $id_veh_relevoJSON = json_encode($id_veh_relevo);
    $cant_paxJSON = json_encode($cant_pax);
    $kmsJSON = json_encode($kms);
    $val_clienteJSON = json_encode($val_cliente);
    $descuentoJSON = json_encode($descuento);
    $val_movilJSON = json_encode($val_movil);
    $dispJSON = json_encode($disp);

    $registrarVehiculosServicio = $operativo->registrarVehiculosServicio($registrarServicio, $servicioJSON, $clase_vehJSON, $id_vehJSON, $id_condJSON, $id_veh_relevoJSON, $cant_paxJSON, $kmsJSON, $val_clienteJSON, $descuentoJSON, $val_movilJSON, $dispJSON);
}

?>

<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

        <?php include("../Vista/Template/styles.php"); ?>
    </head>
    <body>
        <section class="row d-flex justify-content-center">
            <div class="col-6 text-center" style="margin-top: 100px;">
                <i style="font-size: 8rem; color: #3d6685;" class="fa fa-spinner fa-pulse mt-3" aria-hidden="true"></i>
                <p class="mt-4"><strong style="font-size: 1.5rem; color: #1b2d3b;"><?php echo $resultadoAuth->{'status'}->{'message'} ?></strong></p>
                <p style="font-size: 1.5rem; color: #1b2d3b;" class="mt-2">Validando Información para la respectiva carga masiva. </p>
                
                <div class="row d-flex justify-content-around mt-5" style="font-size: 1.6rem;">
                    <b><a style="color:#FEAF20;" target="_blank" href="../Vista/inicio.php" class="logo">SISTEMA <span style="color:#5e99b1;" class="lite">KV</span></a></b>
                </div>
            </div>
        </section>
        <?php include("../Vista/Template/scripts.php"); ?>
    </body>
</html>

<?php 
    if (($objReader->load($archivo) == true) || ($registrarServicio != 0)) {
        echo "<script>setTimeout(function(){ alertify.confirm('Se ha cargado toda la información correctamente.', function(){ window.location='../Vista/servicios_activos.php'; }); }, 500);</script>";
    }else{
        echo "<script>setTimeout(function(){ alertify.confirm('Error al realizar la carga de la información, verifique el documento y su respectiva información.', function(){ alertify.success('Finalizar') }); }, 1500);</script>";
    }
?>