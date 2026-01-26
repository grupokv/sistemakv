<?php
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Operativo.php");
require_once ("../Modelo/EmpresaEnt.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/TipoVehiculo.php");

$id_servicio = $_GET['id_servicio'];

$operativo = new Operativo();
$contrato = new Contrato();
$cliente = new Cliente();
$empresa = new Empresa();
$vehiculo = new Vehiculo();
$tipoVehiculo = new TipoVehiculo();

$listarServiciosPorID = $operativo->listarServiciosPorID($id_servicio);
$listarVehiculosPorServicioID = $operativo->listarVehiculosPorServicioID($id_servicio);
$listarClasesMovilPorIdCliente = $operativo->listarClasesMovilPorIdCliente($listarServiciosPorID[0]['id_cliente']); 
//print_r($listarClasesMovilPorIdCliente);

$listarTV = $tipoVehiculo->listar();
$listarV = $vehiculo->listarActivos();
$listadoClientes = $cliente->listar();

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Actualizar Vehículo</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind&display=swap');

        .ui-state-active,
        .ui-widget-content .ui-state-active,
        .ui-widget-header .ui-state-active {
            background: #5e99b1 !important;
            color: #fff !important;
            border: #fff;
        }

        .ui-datepicker .ui-datepicker-calendar .ui-state-highlight a {
            background: #5e99b1 !important;
        }

        #tabs-2 {
            overflow-y: auto;
        }

        table {
            font-size: .9rem;
        }

        th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
            padding: 10px;
        }

        td {
            padding: 2px;
        }

        .input_vehiculos {
            border-radius: 4px;
            margin: 3px;
            background-color: #f5f7ff;
            border: 1px dashed #e3e3e3;
        }

        .input_vehiculos::placeholder {
            color: #a1a1a1;
            font-family: 'Hind', sans-serif;
        }

        #cont_replicar {
            border-radius: 12px;
            border: 2px solid #c5c5c5;
            height: 450px;
        }

        #calendar {
            position: relative;
            top: 15px;
            width: 100%;
            height: 70%;
        }

        #calendar .ui-widget.ui-widget-content {
            width: 100%;
            height: 100%;
        }

        .form-control {
            font-size: .8rem !important;
        }

        #contenedor_carga {
            background-color: rgba(0, 0, 0, 0.8);
            width: 100%;
            height: 100%;
            position: fixed;
            -webkit-transition: all 1s ease;
            -o-transition: all 1s ease;
            transition: all 1s ease;
            z-index: 10000;
        }

        #carga {
            border: 8px solid #fff;
            border-top-color: #5e99b1;
            border-top-style: groove;
            height: 80px;
            width: 80px;
            border-radius: 100%;

            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;

            -webkit-animation: girar 1.5s linear infinite;
            -o-animation: girar 1.5s linear infinite;
            animation: girar 1.5s linear infinite;
            z-index: 10000;
        }

        @keyframes girar {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }
    </style>

</head>

<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>

    <section class="home_content">
        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="servicios_activos.php">Base Servicios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualizar Servicio</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>NUEVO SERVICIO</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/actualizarBaseServicio.php" method="POST" enctype="multipart/form-data">

                    <!-- CANT VEHICULOS -->
                    <?php if (count($listarVehiculosPorServicioID) > 0) { ?>
                        <input type="hidden" name="cant" id="cant" value="<?php echo count($listarVehiculosPorServicioID); ?>" class="form-control">
                    <?php }else { ?>
                        <input type="hidden" name="cant" id="cant" value="1" class="form-control">
                    <?php } ?>

                    <!-- <section class="col-12">
                        <i class="fa fa-file-pdf-o"></i>Orden
                    </section> -->

                    <div id="tabs">
                        <ul>
                            <li><a href="#tabs-1">Información </a></li>
                            <li><a href="#tabs-2">Vehículo(s)</a></li>
                            <li><a href="#tabs-3">Replicar</a></li>
                        </ul>

                        <!-- INFORMACION BASICA-->
                        <div id="tabs-1" class="p-3">
                            <?php foreach ($listarServiciosPorID as $lspi){ 
                                        
                                        $listarContratosPorCliente = $contrato->listarPorCliente($lspi['id_cliente']); 
                                        $listarProductosPorCliente = $operativo->listarProductosPorCliente($lspi['id_cliente']); 

                                        ?>

                            <!-- ID SERVICIO -->

                            <input type="hidden" name="id_servicio" id="id_servicio" class="form-control"
                                value="<?php echo $lspi['id_servicio_base'] ?>">

                            <!-- CLIENTE -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Cliente</label>
                                </div>
                                <div class="input">
                                    <select class="form-control selectpicker" data-live-search="true" name="id_cliente"
                                        id="id_cliente" required="required"
                                        onchange="validarContratosCliente(this.value); validarProductosCliente(this.value); validarTiposVehiculos(this.value);">
                                        <option value="">SELECCIONAR</option>
                                        <?php foreach ($listadoClientes as $lc){ ?>
                                        <option value="<?php echo $lc['id_cliente']; ?>"
                                            <?php if ($lspi['id_cliente'] == $lc['id_cliente']){ ?> selected="selected"
                                            <?php } ?>>
                                            <?php echo $lc['razon_social'] . ' - Nit: ' . $lc['nit_cliente'];  ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- CONTRATO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Contrato</label>
                                </div>
                                <div class="input">
                                    <select class="form-control selectpicker" data-live-search="true" name="id_contrato"
                                        id="id_contrato">
                                        <option class="fa" value=""> SELECCIONAR</option>
                                        <?php foreach ($listarContratosPorCliente as $lcpc){ 
                                                            $emp = $empresa->listarPorId($lcpc['id_empresa']);
                                                            $cli = $cliente->listarClientePorId($lcpc['id_cliente']);
                                                        ?>
                                        <option value="<?php echo $lcpc['id_contrato'] ?>"
                                            <?php if ($lspi['id_contrato'] == $lcpc['id_contrato']){ ?>
                                            selected="selected" <?php } ?>>
                                            <?php echo 'CONTRATO N° ' . $lcpc['id_contrato'] . " ENTRE " . $cli[0]['razon_social'] . " Y " . $emp[0]['nombre_empresa'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- PRODUCTO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Producto</label>
                                </div>
                                <div class="input">
                                    <select class="form-control selectpicker" data-live-search="true" name="id_producto"
                                        id="id_producto">
                                        <option class="fa" value="">SELECCIONAR</option>
                                        <?php foreach ($listarProductosPorCliente as $lppp){ ?>
                                        <option value="<?php echo $lppp['id_producto'] ?>"
                                            <?php if ($lspi['id_producto'] == $lppp['id_producto']){ ?>
                                            selected="selected" <?php } ?>>
                                            <?php echo $lppp['detalle_producto'] . ' - ' . $lppp['tipo_producto'] ?>
                                        </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <!-- DIVISION CLIENTE -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>División Cliente</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="division_cliente" id="division_cliente"
                                        class="form-control" value="<?php echo $lspi['division_cliente'] ?>">
                                </div>
                            </div>

                            <!-- TIPO SERVICIO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Tipo de Servicio</label>
                                </div>
                                <div class="input">
                                    <select class="form-control selectpicker" data-live-search="true"
                                        name="tipo_servicio" id="tipo_servicio" required="required">
                                        <option value="">SELECCIONAR</option>
                                        <option value="OCASIONAL" <?php if ($lspi['tipo_servicio'] == 'OCASIONAL'){ ?>
                                            selected="selected" <?php } ?>>OCASIONAL</option>
                                        <option value="FIJO" <?php if ($lspi['tipo_servicio'] == 'FIJO'){ ?>
                                            selected="selected" <?php } ?>>FIJO</option>
                                    </select>
                                </div>
                            </div>

                            <!-- GRUPO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Grupo</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="grupo" id="grupo" class="form-control"
                                        value="<?php echo $lspi['grupo'] ?>">
                                </div>
                            </div>

                            <!-- SOLICITANTE -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Solicitante</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="solicitante" id="solicitante"
                                        value="<?php echo $lspi['solicitante'] ?>" class="form-control">
                                </div>
                            </div>

                            <!-- FECHA INICIAL SERVICIO -->

                            <div class="row mt-3">
                                <section class="col-6">
                                    <div class="row">
                                        <div class="label">
                                            <label>Fecha Inicio</label>
                                        </div>
                                        <div class="input">
                                            <input tye="text" id="datepicker" name="fecha_inicial" class="form-control"
                                                style="border-style: dashed;"
                                                value="<?php echo $lspi['fecha_inicio'] ?>">
                                        </div>
                                    </div>
                                </section>
                                <section class="col-6">
                                    <div class="row">
                                        <div class="label">
                                            <label>Hora</label>
                                        </div>
                                        <div class="input">
                                            <div class="input-group clockpicker">
                                                <input type="text" name="hora_inicial" id="hora_inicial"
                                                    class="form-control" required="required"
                                                    value="<?php echo $lspi['hora_inicio'] ?>"
                                                    style="border-style: dashed;">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <!-- ORIGEN -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Origen</label>
                                </div>
                                <div class="input">
                                    <input class="form-control" id="origen" name="origen" style="border-style: dashed;"
                                        value="<?php echo $lspi['origen'] ?>">
                                </div>
                            </div>

                            <!-- DESTINO(S) -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Destino</label>
                                </div>
                                <div class="input">
                                    <input class="form-control" id="destino" name="destino"
                                        style="border-style: dashed;" value="<?php echo $lspi['destino'] ?>">
                                </div>
                            </div>

                            <!-- FECHA INICIAL SERVICIO -->

                            <div class="row mt-3">
                                <section class="col-6">
                                    <div class="row">
                                        <div class="label">
                                            <label>Fecha Finalización</label>
                                        </div>
                                        <div class="input">
                                            <input tye="text" id="datepicker1" name="fecha_final" class="form-control"
                                                style="border-style: dashed;"
                                                value="<?php echo $lspi['fecha_final'] ?>">
                                        </div>
                                    </div>
                                </section>
                                <section class="col-6">
                                    <div class="row">
                                        <div class="label">
                                            <label>Hora</label>
                                        </div>
                                        <div class="input">
                                            <div class="input-group clockpicker">
                                                <input type="text" name="hora_final" id="hora_final"
                                                    class="form-control" required="required"
                                                    style="border-style: dashed;"
                                                    value="<?php echo $lspi['hora_final'] ?>">
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-time"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            </div>

                            <!-- OBSERVACIONES -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Observaciones</label>
                                </div>
                                <div class="input">
                                    <textarea class="form-control" id="observaciones" name="observaciones"
                                        style="border-style: dashed;"><?php echo $lspi['observaciones'] ?></textarea>
                                </div>
                            </div>

                            <!-- REQUISITOS -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Requisitos</label>
                                </div>
                                <div class="input">
                                    <textarea class="form-control" id="requisitos" name="requisitos"
                                        style="border-style: dashed;"><?php echo $lspi['requisitos'] ?></textarea>
                                </div>
                            </div>

                            <?php } ?>
                        </div>

                        <!-- VEHICULO(S)-->
                        <div id="tabs-2">

                            <!-- BOTONES AGREGAR Y ELIMINAR-->
                            <div class="row">
                                <section class="col-6 d-flex justify-content-end">
                                    <button type="button" class="btn btn-outline-info col-2" onclick="agregarFila()"><i
                                            class="fa fa-plus"></i> Agregar</button>
                                </section>
                                <section class="col-6 d-flex justify-content-start">
                                    <button type="button" class="btn btn-outline-danger col-2"
                                        onclick="eliminarFila();"><i class="fa fa-times"></i> Eliminar</button>
                                </section>
                            </div>

                            <hr>

                            <?php if (count($listarVehiculosPorServicioID) > 0){ 
                                        $i = 1; ?>
                            <?php foreach ($listarVehiculosPorServicioID as $lvps){     

                                $servicioJSON = json_decode($lvps['servicio']);
                                $clase_vehJSON = json_decode($lvps['clase_vehiculo']);
                                $id_vehJSON = json_decode($lvps['id_vehiculo']);
                                $id_condJSON = json_decode($lvps['id_conductor']);
                                $id_vehRelevoJSON = json_decode($lvps['id_vehiculo_relevo']);
                                $cant_paxJSON = json_decode($lvps['cant_pasajeros']);
                                $kmsJSON = json_decode($lvps['kms']);
                                $val_clienteJSON = json_decode($lvps['valor_cliente']);
                                $descuentosClienteJSON = json_decode($lvps['descuento_cliente']);
                                $val_movilJSON = json_decode($lvps['valor_movil']);
                                $descuentosMovilJSON = json_decode($lvps['descuento_movil']);
                                $dispJSON = json_decode($lvps['disp']);

                                $listarConductoresVehEntrada = $vehiculo->listarConductoresPorVehiculo($id_vehJSON->{'entrada'});
                                $listarConductoresVehSalida = $vehiculo->listarConductoresPorVehiculo($id_vehJSON->{'salida'});

                            ?>

                            <table id="table_<?php echo $i; ?>" style="text-align: center; width:100%;">

                                <thead>
                                    <tr>
                                        <th width="60px;"></th>
                                        <th width="90px;"><?php echo $i; ?></th>
                                        <th width="170px;"> CLASE VEH. </th>
                                        <th width="150px;">MOVIL</th>
                                        <th width="250px;">CONDUCTOR</th>
                                        <th width="150px;">MOV. RELEVO</th>
                                        <th width="70px;">CANT. PAX</th>
                                        <th width="100px;">KMS</th>
                                        <th width="145px;">VAL. CLIENTE</th>
                                        <th width="90px;">DESC. %</th>
                                        <th width="145px;">VAL. MOVIL</th>
                                        <th width="90px;">DESC. %</th>
                                        <th width="70px;">DISP.</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php if ($servicioJSON->{'entrada'} == 1 ){ ?>
                                        <tr style="border-bottom: 3px solid #f2f2f2;">

                                            <td rowspan="3">
                                                <?php if (($servicioJSON->{'entrada'} == 0) && ($servicioJSON->{'salida'} == 0) ){ ?>
                                                    <input type="checkbox" value="<?php echo $i ?>" name="registroAsignacionVeh[]" id="registroAsignacionVeh<?php echo $i ?>">
                                                <?php }else{ ?>
                                                    <input type="checkbox" value="<?php echo $i ?>" checked name="registroAsignacionVeh[]" id="registroAsignacionVeh<?php echo $i ?>">
                                                <?php } ?>
                                            </td>

                                            <!-- SERVICIO -->
                                            <td style="color: #274054">
                                                <b>
                                                    ENTRADA
                                                </b>
                                            </td>

                                            <!-- CLASE VEHICULO -->
                                            <td id="claseVehiculos" class="p-2" style="color: #274054">

                                                <select class="form-control form-control-sm selectpicker id_tv_cliente_entrada" data-live-search="true" name="id_tv_cliente_entrada[]" id="id_tv_cliente_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">CLIENTE</option>

                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if ($clase_vehJSON->{'entrada'}->{'cliente'} == $ltv['id_tipo_vehiculo']){ ?> selected="selected" <?php } ?> >
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); 
                                                        ?> 
                                                                <option value="<?php echo $lcmpic['id'] ?>" <?php if ($clase_vehJSON->{'entrada'}->{'cliente'} == $lcmpic['id']){ ?> selected="selected" <?php } ?>>
                                                                    <?php echo strtoupper($lcmpic['clase_movil_producto']) . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                    
                                                </select>

                                                <input type="hidden" class="form-control" name="id_tv_cliente_entrada_act"
                                                    id="id_tv_cliente_entrada_act<?php echo $i ?>"
                                                    value="<?php echo $clase_vehJSON->{'entrada'}->{'cliente'} ?>">

                                                <hr>

                                                <select class="form-control form-control-sm selectpicker id_tv_movil_entrada" data-live-search="true" name="id_tv_movil_entrada[]" id="id_tv_movil_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">MOVIL</option>

                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if ($clase_vehJSON->{'entrada'}->{'movil'} == $lcmpic['id']){ ?>
                                                        selected="selected" <?php } ?>>
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                                <option value="<?php echo $lcmpic['id'] ?>" <?php if ($clase_vehJSON->{'entrada'}->{'movil'} == $lcmpic['id']){ ?> selected="selected" <?php } ?>>
                                                                    <?php echo strtoupper($lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'); ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </select>

                                                <input type="hidden" class="form-control" name="id_tv_movil_entrada_act"
                                                    id="id_tv_movil_entrada_act<?php echo $i ?>"
                                                    value="<?php echo $clase_vehJSON->{'entrada'}->{'movil'} ?>">
                                            </td>

                                            <!-- VEHICULO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_vehiculo_entrada[]"
                                                    id="id_vehiculo_entrada<?php echo $i ?>"
                                                    onchange="validarTarifasClaseVeh('fija', 'entrada', '<?php echo $i ?>'); listarConductoresPorVehiculo(this.value, 'entrada', '<?php echo $i ?>');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                                $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                                if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>"
                                                        <?php if($id_vehJSON->{'entrada'} == $lv['id_vehiculo']){ ?>
                                                        selected="selected" <?php } ?>>
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CONDUCTOR -->
                                            <td>
                                                <select class="form-control form-control-sm" data-live-search="true"
                                                    name="id_conductor_entrada[]" id="id_conductor_entrada<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarConductoresVehEntrada as $lcv){ ?>
                                                    <option value="<?php echo $lcv['id_conductor'] ?>"
                                                        <?php if ($id_condJSON->{'entrada'} == $lcv['id_conductor']){ ?>selected="selected"
                                                        <?php } ?>>
                                                        <?php echo $lcv['nombre_conductor']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO RELEVO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_veh_relevo_entrada[]"
                                                    id="id_veh_relevo_entrada<?php echo $i ?>"
                                                    onchange="validarTarifasClaseVeh('relevo', 'entrada', '<?php echo $i ?>');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                            if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>"
                                                        <?php if ($id_vehRelevoJSON->{'entrada'} == $lv['id_vehiculo']){ ?>
                                                        selected="selected" <?php } ?>>
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CANT PAX -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="cant_pax_entrada[]" id="cant_pax_entrada<?php echo $i ?>"
                                                    placeholder="PAX" value="<?php echo $cant_paxJSON->{'entrada'} ?>">
                                            </td>

                                            <!-- KMS -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="kms_entrada[]" id="kms_entrada<?php echo $i ?>" placeholder="PAX"
                                                    value="<?php echo $kmsJSON->{'entrada'} ?>">
                                            </td>

                                            <!-- VALOR CLIENTE-->
                                            <td>
                                                <div>
                                                    <input type="text"
                                                        onkeyup="convertirValorCliente(this.value, 'entrada', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_cliente_entrada[]"
                                                        id="valor_cliente_entrada<?php echo $i ?>" placeholder="VALOR"
                                                        value="<?php echo $val_clienteJSON->{'entrada'} ?>">
                                                </div>
                                                <div class="col-12" id="valorClienteEntrada<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO CLIENTE -->
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="descuento_cliente_entrada[]" id="descuento_cliente_entrada<?php echo $i ?>"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'entrada', 1);" value="<?php echo $descuentosClienteJSON->{'entrada'} ?>">
                                                </td>

                                            <!-- VALOR MOVIL-->
                                            <td>
                                                <div class="col-12">
                                                    <input type="text"
                                                        onkeyup="convertirValorMovil(this.value, 'entrada', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_movil_entrada[]"
                                                        id="valor_movil_entrada<?php echo $i ?>" placeholder="VALOR"
                                                        value="<?php echo $val_movilJSON->{'entrada'} ?>">
                                                </div>
                                                <div class="col-12" id="valorMovilEntrada<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO MOVIL -->
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_vehiculos"
                                                        name="descuento_movil_entrada[]" id="descuento_movil_entrada<?php echo $i ?>"
                                                        placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'entrada', <?php echo $i ?>);" value="<?php echo $descuentosMovilJSON->{'entrada'} ?>">
                                                </td>

                                            <!-- DISPONIBILIDAD-->
                                            <td>
                                                <?php if ($dispJSON->{'entrada'} == 1){ ?>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" checked="true" />
                                                <?php } else { ?>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" />
                                                <?php } ?>
                                            </td>

                                        </tr>
                                    <?php } else { ?>
                                        <tr style="border-bottom: 3px solid #f2f2f2;">
                                            
                                            <td rowspan="3">
                                                <?php if (($servicioJSON->{'entrada'} == 0) && ($servicioJSON->{'salida'} == 0) ){ ?>
                                                    <input type="checkbox" value="<?php echo $i ?>" name="registroAsignacionVeh[]" id="registroAsignacionVeh<?php echo $i ?>">
                                                <?php }else{ ?>
                                                    <input type="checkbox" value="<?php echo $i ?>" checked name="registroAsignacionVeh[]" id="registroAsignacionVeh<?php echo $i ?>">
                                                <?php } ?>
                                            </td>

                                            <!-- SERVICIO -->

                                            <td style="color: #274054">
                                                <b>
                                                    ENTRADA
                                                </b>
                                            </td>

                                            <!-- CLASE VEHICULO -->
                                            <td id="claseVehiculos" class="p-2" style="color: #274054">

                                                <select class="form-control form-control-sm id_tv_cliente_entrada selectpicker"
                                                    data-live-search="true" name="id_tv_cliente_entrada[]"
                                                    id="id_tv_cliente_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">CLIENTE</option>

                                                    <?php foreach ($listarTV as $ltv){ ?>
                                                        <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                            <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                        </option>
                                                    <?php } ?>

                                                </select>

                                                <hr>

                                                <select class="form-control form-control-sm id_tv_movil_entrada selectpicker"
                                                    data-live-search="true" name="id_tv_movil_entrada[]"
                                                    id="id_tv_movil_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">MOVIL</option>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_vehiculo_entrada[]"
                                                    id="id_vehiculo_entrada<?php echo $i ?>"
                                                    onchange="validarTarifasClaseVeh('fija', 'entrada', '1'); listarConductoresPorVehiculo(this.value, 'entrada', '1');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 

                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                            if (count($documentosvencidosPorId) > 0) { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>"
                                                        <?php if($id_vehJSON->{'entrada'} == $lv['id_vehiculo']){ ?>
                                                        selected="selected" <?php } ?>>
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CONDUCTOR -->
                                            <td>
                                                <select class="form-control form-control-sm" data-live-search="true"
                                                    name="id_conductor_entrada[]" id="id_conductor_entrada<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarConductoresVehEntrada as $lcv){ ?>
                                                    <option value="<?php echo $lcv['id_conductor'] ?>">
                                                        <?php echo $lcv['nombre_conductor']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO RELEVO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_veh_relevo_entrada[]"
                                                    id="id_veh_relevo_entrada<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 

                                                                                                $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                                                if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CANT PAX -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="cant_pax_entrada[]" id="cant_pax_entrada<?php echo $i ?>"
                                                    placeholder="PAX">
                                            </td>

                                            <!-- KMS -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="kms_entrada[]" id="kms_entrada<?php echo $i ?>" placeholder="PAX">
                                            </td>

                                            <!-- VALOR CLIENTE-->
                                            <td>
                                                <div>
                                                    <input type="text"
                                                        onkeyup="convertirValorCliente(this.value, 'ENTRADA');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_cliente_entrada[]"
                                                        id="valor_cliente_entrada<?php echo $i ?>" placeholder="VALOR">
                                                </div>
                                                <div class="col-12" id="valorClienteEntrada<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO CLIENTE -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="descuento_cliente_entrada[]" id="descuento_cliente_entrada<?php echo $i ?>"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'entrada', <?php echo $i ?>);">
                                            </td>

                                            <!-- VALOR MOVIL-->
                                            <td>
                                                <div class="col-12">
                                                    <input type="text" onkeyup="convertirValorMovil(this.value, 'ENTRADA');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_movil_entrada[]"
                                                        id="valor_movil_entrada<?php echo $i ?>" placeholder="VALOR">
                                                </div>
                                                <div class="col-12" id="valorMovilEntrada<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO MOVIL-->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="descuento_movil_entrada[]" id="descuento_movil_entrada<?php echo $i ?>"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'entrada', <?php echo $i ?>);">
                                            </td>


                                            <!-- DISPONIBILIDAD-->
                                            <td>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" />
                                            </td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($servicioJSON->{'salida'} == 1 ){ ?>
                                        <tr style="border-bottom: 3px solid #f2f2f2;">
                                            <!-- SERVICIO -->

                                            <td style="color: #274054">
                                                <b>
                                                    SALIDA
                                                </b>
                                            </td>

                                            <!-- CLASE VEHICULO -->
                                            <td id="claseVehiculos" class="p-2" style="color: #274054">
                                                <select class="form-control form-control-sm id_tv_cliente_salida selectpicker"
                                                    data-live-search="true" name="id_tv_cliente_salida[]"
                                                    id="id_tv_cliente_salida<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">CLIENTE</option>

                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if ($clase_vehJSON->{'salida'}->{'cliente'} == $lcmpic['id']){ ?>
                                                        selected="selected" <?php } ?>>
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                                <option value="<?php echo $lcmpic['id'] ?>" <?php if ($clase_vehJSON->{'salida'}->{'cliente'} == $lcmpic['id']){ ?>
                                                        selected="selected" <?php } ?>>
                                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </select>

                                                <hr>

                                                <select class="form-control form-control-sm id_tv_movil_salida selectpicker"
                                                    data-live-search="true" name="id_tv_movil_salida[]"
                                                    id="id_tv_movil_salida<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">MOVIL</option>
                                                    
                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>" <?php if ($clase_vehJSON->{'salida'}->{'movil'} == $lcmpic['id']){ ?>
                                                        selected="selected" <?php } ?>>
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                                <option value="<?php echo $lcmpic['id'] ?>" <?php if ($clase_vehJSON->{'salida'}->{'movil'} == $lcmpic['id']){ ?>
                                                        selected="selected" <?php } ?>>
                                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </select>
                                            </td>

                                            <!-- VEHICULO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_vehiculo_salida[]"
                                                    id="id_vehiculo_salida<?php echo $i ?>"
                                                    onchange="listarConductoresPorVehiculo(this.value, 'salida', '<?php echo $i ?>'); validarTarifasClaseVeh('fija', 'salida', '<?php echo $i ?>');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                                                                            if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>"
                                                        <?php if ($id_vehJSON->{'salida'} == $lv['id_vehiculo']){ ?>
                                                        selected="selected" <?php } ?>>
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CONDUCTOR -->
                                            <td>
                                                <select class="form-control form-control-sm" data-live-search="true"
                                                    name="id_conductor_salida[]" id="id_conductor_salida<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarConductoresVehEntrada as $lcv){ ?>
                                                    <option value="<?php echo $lcv['id_conductor'] ?>"
                                                        <?php if ($id_condJSON->{'salida'} == $lcv['id_conductor']){ ?>selected="selected"
                                                        <?php } ?>>
                                                        <?php echo $lcv['nombre_conductor']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO RELEVO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_veh_relevo_salida[]"
                                                    id="id_veh_relevo_salida<?php echo $i ?>"
                                                    onchange="validarTarifasClaseVeh('relevo', 'salida', '<?php echo $i ?>');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                            
                                                                            if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>"
                                                        <?php if ($id_vehRelevoJSON->{'salida'} == $lv['id_vehiculo']){ ?>
                                                        selected="selected" <?php } ?>>
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CANT PAX -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="cant_pax_salida[]" id="cant_pax_salida<?php echo $i ?>"
                                                    placeholder="PAX" value="<?php echo $cant_paxJSON->{'salida'} ?>">
                                            </td>

                                            <!-- KMS -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="kms_salida[]" id="kms_salida<?php echo $i ?>" placeholder="KMS"
                                                    value="<?php echo $kmsJSON->{'salida'} ?>">
                                            </td>

                                            <!-- VALOR CLIENTE-->
                                            <td>
                                                <div>
                                                    <input type="text"
                                                        onkeyup="convertirValorCliente(this.value, 'salida', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_cliente_salida[]"
                                                        id="valor_cliente_salida<?php echo $i ?>" placeholder="VALOR"
                                                        value="<?php echo $val_clienteJSON->{'salida'} ?>">
                                                </div>
                                                <div class="col-12" id="valorClienteSalida<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO CLIENTE -->
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_vehiculos"
                                                        name="descuento_cliente_salida[]" id="descuento_cliente_salida<?php echo $i ?>"
                                                        placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'salida', <?php echo $i ?>);" value="<?php echo $descuentosClienteJSON->{'salida'} ?>">
                                                </td>

                                            <!-- VALOR MOVIL-->
                                            <td>
                                                <div class="col-12">
                                                    <input type="text"
                                                        onkeyup="convertirValorMovil(this.value, 'salida', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_movil_salida[]" id="valor_movil_salida<?php echo $i ?>"
                                                        placeholder="VALOR"
                                                        value="<?php echo $val_movilJSON->{'salida'} ?>">
                                                </div>
                                                <div class="col-12" id="valorMovilSalida<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO MOVIL -->
                                                <td>
                                                    <input type="text" class="form-control form-control-sm input_vehiculos"
                                                        name="descuento_movil_salida[]" id="descuento_movil_salida<?php echo $i ?>"
                                                        placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'salida', <?php echo $i ?>);" value="<?php echo $descuentosMovilJSON->{'salida'} ?>">
                                                </td>

                                            <!-- DISPONIBILIDAD-->
                                            <td>
                                                <?php if ($dispJSON->{'salida'} == 1){ ?>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" checked="true" />
                                                <?php } else { ?>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" />
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } else { ?>
                                        <tr style="border-bottom: 3px solid #f2f2f2;">
                                            <!-- SERVICIO -->

                                            <td style="color: #274054">
                                                <b>
                                                    SALIDA
                                                </b>
                                            </td>

                                            <!-- CLASE VEHICULO -->
                                            <td id="claseVehiculos" class="p-2" style="color: #274054">
                                                <select class="form-control form-control-sm id_tv_cliente_salida selectpicker"
                                                    data-live-search="true" name="id_tv_cliente_salida[]"
                                                    id="id_tv_cliente_salida<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">CLIENTE</option>
                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                                <option value="<?php echo $lcmpic['id'] ?>">
                                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>

                                                </select>

                                                <hr>

                                                <select class="form-control form-control-sm id_tv_movil_salida selectpicker"
                                                    data-live-search="true" name="id_tv_movil_salida[]"
                                                    id="id_tv_movil_salida<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">MOVIL</option>
                                                    <?php if(count($listarClasesMovilPorIdCliente) == 0 ){ ?>
                                                        <?php foreach ($listarTV as $ltv){ ?>
                                                            <option value="<?php echo $ltv['id_tipo_vehiculo'] ?>">
                                                                <?php echo $ltv['nombre_tipo_vehiculo']; ?>
                                                            </option>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                            $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                                <option value="<?php echo $lcmpic['id'] ?>">
                                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                                </option>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_vehiculo_salida[]"
                                                    id="id_vehiculo_salida<?php echo $i ?>"
                                                    onchange="listarConductoresPorVehiculo(this.value, 'salida', '<?php echo $i ?>'); validarTarifasClaseVeh('fija', 'salida', '<?php echo $i ?>');">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);

                                                                            if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CONDUCTOR -->
                                            <td>
                                                <select class="form-control form-control-sm" data-live-search="true"
                                                    name="id_conductor_salida[]" id="id_conductor_salida<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarConductoresVehEntrada as $lcv){ ?>
                                                    <option value="<?php echo $lcv['id_conductor'] ?>">
                                                        <?php echo $lcv['nombre_conductor']; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- VEHICULO RELEVO -->
                                            <td>
                                                <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_veh_relevo_salida[]"
                                                    id="id_veh_relevo_salida<?php echo $i ?>">
                                                    <option value="">SELECCIONAR</option>
                                                    <?php foreach ($listarV as $lv){ 
                                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                                            
                                                                            if (count($documentosvencidosPorId)>0) {?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                        style="color:red;font-weight:bolder">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } else { ?>
                                                    <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                        <?php echo $lv['placa'] ?>
                                                    </option>
                                                    <?php } ?>

                                                    <?php } ?>
                                                </select>
                                            </td>

                                            <!-- CANT PAX -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="cant_pax_salida[]" id="cant_pax_salida<?php echo $i ?>"
                                                    placeholder="PAX">
                                            </td>

                                            <!-- KMS -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="kms_salida[]" id="kms_salida<?php echo $i ?>" placeholder="KMS">
                                            </td>

                                            <!-- VALOR CLIENTE-->
                                            <td>
                                                <div>
                                                    <input type="text"
                                                        onkeyup="convertirValorCliente(this.value, 'salida', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_cliente_salida[]"
                                                        id="valor_cliente_salida<?php echo $i ?>" placeholder="VALOR">
                                                </div>
                                                <div class="col-12" id="valorClienteSalida<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO -->
                                            <td>    
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="descuento_cliente_salida[]" id="descuento_cliente_salida<?php echo $i ?>"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'salida', <?php echo $i ?>);">
                                            </td>

                                            <!-- VALOR MOVIL-->
                                            <td>
                                                <div class="col-12">
                                                    <input type="text"
                                                        onkeyup="convertirValorMovil(this.value, 'salida', '<?php echo $i ?>');"
                                                        class="form-control form-control-sm input_vehiculos"
                                                        name="valor_movil_salida[]" id="valor_movil_salida<?php echo $i ?>"
                                                        placeholder="VALOR">
                                                </div>
                                                <div class="col-12" id="valorMovilSalida<?php echo $i ?>"></div>
                                            </td>

                                            <!-- DESCUENTO MOVIL -->
                                            <td>
                                                <input type="text" class="form-control form-control-sm input_vehiculos"
                                                    name="descuento_movil_salida[]" id="descuento_movil_salida<?php echo $i ?>"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'salida', <?php echo $i ?>);">
                                            </td>

                                            <!-- DISPONIBILIDAD-->
                                            <td>
                                                <input type="checkbox" id="identificador_entrada<?php echo $i ?>"
                                                    name="identificador_entrada[]" value="1" />
                                            </td>
                                        </tr>
                                    <?php } ?>

                                </tbody>
                            </table>

                            <?php $i++; } ?>
                            <?php } else { ?>

                            <table id="table_1" style="text-align: center; width:100%;">
                                <thead>
                                    <tr>
                                        <th width="60px;"></th>
                                        <th width="80px;">1</th>
                                        <th width="150px;"> CLASE VEH. </th>
                                        <th width="150px;">MOVIL</th>
                                        <th>CONDUCTOR</th>
                                        <th>MOV. RELEVO</th>
                                        <th width="50px;">CANT. PAX</th>
                                        <th>KMS</th>
                                        <th width="145px;">VAL. CLIENTE</th>
                                        <th width="90px;">DESC. %</th>
                                        <th width="145px;">VAL. MOVIL</th>
                                        <th width="90px;">DESC. %</th>
                                        <th width="70px;">DISP.</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    <!-- VEHÍCULO ENTRADA-->
                                    <tr style="border-bottom: 3px solid #f2f2f2;">
                                        
                                        <td rowspan="3">
                                            <input type="checkbox" value="1" name="registroAsignacionVeh[]" id="registroAsignacionVeh1">
                                        </td>

                                        <td style="color: #274054">
                                            <b>
                                                ENTRADA
                                            </b>
                                        </td>

                                        <td id="claseVehiculos" class="p-2" style="color: #274054">
                                                <select class="form-control form-control-sm id_tv_cliente_entrada"
                                                    data-live-search="true" name="id_tv_cliente_entrada[]"
                                                    id="id_tv_cliente_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">CLIENTE</option>

                                                    <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                        $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>
                                                            <option value="<?php echo $lcmpic['id'] ?>">
                                                                <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                            </option>
                                                    <?php } ?>
                                                </select>

                                                <hr>

                                                <select class="form-control form-control-sm id_tv_movil_entrada"
                                                    data-live-search="true" name="id_tv_movil_entrada[]"
                                                    id="id_tv_movil_entrada<?php echo $i ?>">
                                                    <option value="" disabled selected="selected">MOVIL</option>
                                                    <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                        $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']);
                                                        ?>
                                                    <option value="<?php echo $lcmpic['id'] ?>">
                                                        <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                    </option>
                                                    <?php } ?>
                                                </select>
                                            </td>

                                        <td>
                                            <select class="form-control form-control-sm selectpicker"
                                                    data-live-search="true" name="id_vehiculo_entrada[]"
                                                    id="id_vehiculo_entrada1"
                                                    onchange="validarTarifasClaseVeh('fija', 'entrada', '1'); listarConductoresPorVehiculo(this.value, 'entrada', '1');">
                                                    <option value="">SELECCIONAR</option>
                                                    
                                                    <?php foreach ($listarV as $lv){ 

                                                        $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                        if (count($documentosvencidosPorId)>0) {?>
                                                            <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                                style="color:red;font-weight:bolder">
                                                                <?php echo $lv['placa'] ?>
                                                            </option>
                                                        <?php } else { ?>
                                                            <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                                <?php echo $lv['placa'] ?>
                                                            </option>
                                                        <?php } ?>

                                                    <?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control form-control-sm" data-live-search="true"
                                                name="id_conductor_entrada[]" id="id_conductor_entrada1">
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control form-control-sm selectpicker"
                                                data-live-search="true" name="id_veh_relevo_entrada[]"
                                                id="id_veh_relevo_entrada1"
                                                onchange="validarTarifasClaseVeh('relevo', 'entrada', '1');">
                                                <option value="">SELECCIONAR</option>
                                                <?php foreach ($listarV as $lv){ 

                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                            if (count($documentosvencidosPorId)>0) {?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                    style="color:red;font-weight:bolder">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } else { ?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } ?>

                                                <?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="cant_pax_entrada[]" id="cant_pax_entrada1" placeholder="PAX">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="kms_entrada[]" id="kms_entrada1" placeholder="KMS">
                                        </td>

                                        <td>
                                            <div>
                                                <input type="text"
                                                    onkeyup="convertirValorCliente(this.value, 'entrada', '1');"
                                                    class="form-control form-control-sm input_vehiculos"
                                                    name="valor_cliente_entrada[]" id="valor_cliente_entrada1"
                                                    placeholder="VALOR">
                                            </div>
                                            <div class="col-12" id="valorClienteEntrada1">

                                            </div>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="descuento_movil_entrada[]" id="descuento_entrada"
                                                placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'entrada', 1);">
                                        </td>

                                        <td>
                                            <div class="col-12">
                                                <input type="text"
                                                    onkeyup="convertirValorMovil(this.value, 'entrada', '1');"
                                                    class="form-control form-control-sm input_vehiculos"
                                                    name="valor_movil_entrada[]" id="valor_movil_entrada1"
                                                    placeholder="VALOR">
                                            </div>
                                            <div class="col-12" id="valorMovilEntrada1">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="descuento_movil_entrada[]" id="descuento_movil_entrada1"
                                                placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'entrada', 1);">
                                        </td>

                                        <td>
                                            <input type="checkbox" id="identificador_entrada1"
                                                name="identificador_entrada[]" value="1"
                                                onclick="validarTarifasClaseVeh('disponibilidad', 'entrada', '1');" />
                                        </td>
                                    </tr>

                                    <!-- VEHÍCULO SALIDA-->
                                    <tr style="border-bottom: 3px solid #f2f2f2;">
                                        <td style="color: #274054">
                                            <b>
                                                SALIDA
                                            </b>
                                        </td>
                                        <td id="claseVehiculos" class="p-2" style="color: #274054">
                                            <select class="form-control form-control-sm id_tv_cliente_salida"
                                                data-live-search="true" name="id_tv_cliente_salida[]"
                                                id="id_tv_cliente_salida<?php echo $i ?>">
                                                <option value="" disabled selected="selected">CLIENTE</option>

                                                <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                                        $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>

                                                <option value="<?php echo $lcmpic['id'] ?>">
                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                </option>
                                                <?php } ?>

                                            </select>

                                            <hr>

                                            <select class="form-control form-control-sm id_tv_movil_salida"
                                                data-live-search="true" name="id_tv_movil_salida[]"
                                                id="id_tv_movil_salida<?php echo $i ?>">
                                                <option value="" disabled selected="selected">MOVIL</option>

                                                <?php foreach ($listarClasesMovilPorIdCliente as $lcmpic){ 
                                                                        $listarTipoV = $tipoVehiculo->listarPorId($lcmpic['id_tipo_vehiculo']); ?>

                                                <option value="<?php echo $lcmpic['id'] ?>">
                                                    <?php echo $lcmpic['clase_movil_producto'] . ' ( ' . $listarTipoV[0]['nombre_tipo_vehiculo'] . ' )'; ?>
                                                </option>
                                                <?php } ?>

                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control form-control-sm selectpicker"
                                                data-live-search="true" name="id_vehiculo_salida[]"
                                                id="id_vehiculo_salida1"
                                                onchange="listarConductoresPorVehiculo(this.value, 'salida', '1'); validarTarifasClaseVeh('fija', 'salida', '1');">
                                                <option value="">SELECCIONAR</option>
                                                <?php foreach ($listarV as $lv){ 
                                                    $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                            if (count($documentosvencidosPorId)>0) {?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                    style="color:red;font-weight:bolder">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } else { ?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } ?>

                                                <?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control form-control-sm" data-live-search="true"
                                                name="id_conductor_salida[]" id="id_conductor_salida1">
                                            </select>
                                        </td>

                                        <td>
                                            <select class="form-control form-control-sm selectpicker"
                                                data-live-search="true" name="id_veh_relevo_salida[]"
                                                id="id_veh_relevo_salida1" onchange="validarTarifasClaseVeh('relevo', 'salida', '1');">
                                                <option value="">SELECCIONAR</option>
                                                <?php foreach ($listarV as $lv){ 

                                                            $documentosvencidosPorId = $vehiculo->documentosvencidosPorId($lv['id_vehiculo'], $hoy, $fecha2);
                                                            if (count($documentosvencidosPorId)>0) {?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>" disabled
                                                    style="color:red;font-weight:bolder">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } else { ?>
                                                <option value="<?php echo $lv['id_vehiculo'] ?>">
                                                    <?php echo $lv['placa'] ?>
                                                </option>
                                                <?php } ?>

                                                <?php } ?>
                                            </select>
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="cant_pax_salida[]" id="cant_pax_salida1" placeholder="PAX">
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="kms_salida[]" id="kms_salida1" placeholder="KMS">
                                        </td>

                                        <td>
                                            <div>
                                                <input type="text"
                                                    onkeyup="convertirValorCliente(this.value, 'salida', '1');"
                                                    class="form-control form-control-sm input_vehiculos"
                                                    name="valor_cliente_salida[]" id="valor_cliente_salida1"
                                                    placeholder="VALOR">
                                            </div>
                                            <div class="col-12" id="valorClienteSalida1">

                                            </div>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="descuento_cliente_salida[]" id="descuento_cliente_salida1"
                                                placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'salida', 1);">
                                        </td>

                                        <td>
                                            <div class="col-12">
                                                <input type="text"
                                                    onkeyup="convertirValorMovil(this.value, 'salida', '1');"
                                                    class="form-control form-control-sm input_vehiculos"
                                                    name="valor_movil_salida[]" id="valor_movil_salida1"
                                                    placeholder="VALOR">
                                            </div>
                                            <div class="col-12" id="valorMovilSalida1">
                                            </div>
                                        </td>
                                        
                                        <td>
                                            <input type="text" class="form-control form-control-sm input_vehiculos"
                                                name="descuento_movil_salida[]" id="descuento_movil_salida1"
                                                placeholder="%" onBlur="aplicarDescuento(this.value, 'movil', 'salida', 1);">
                                        </td>


                                        <td>
                                            <input type="checkbox" id="identificador_salida1"
                                                name="identificador_salida[]"
                                                onclick="validarTarifasClaseVeh('disponibilidad', 'salida', '1');" />
                                        </td>
                                    </tr>

                                </tbody>
                            </table>

                            <?php }   ?>

                            <div id="añadirCamposVeh"></div>
                        </div>

                        <!-- REPLICAR-->

                        <div id="tabs-3" class="p-4">
                            <section class="row d-flex justify-content-around">
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 d-flex justify-content-center"
                                    id="cont_replicar">
                                    <section class="col-12 text-center mt-3 mb-3"
                                        style="background: #f7f7f7; border-radius: 12px; border: 2px solid #f2f2f2">

                                        <p
                                            style="font-size: 1.7rem; margin-top: 20px; color: #274054; font-family: 'Hind', sans-serif;">
                                            <b>REPLICAR SERVICIO</b>
                                        </p>

                                        <hr style="border: 2px solid #fff;">

                                        <div id="calendar">
                                        </div>
                                    </section>
                                </div>

                                <div class="col-xs-12 col-sm-12 col-md-7 col-lg-7" id="cont_replicar">
                                    <div class="col-12 p-2 mt-4"
                                        style="background: #f7f7f7; border-radius: 12px; border: 2px solid #f2f2f2">
                                        <textarea name="fechas_duplicar" id="fechas_duplicar"
                                            style="width: 100%; height: 200px;"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-end mt-3">
                                        <button type="button" class="btn eliminarFechas" id="buttonsKV"
                                            onclick="eliminarFechas();">Borrar</button>
                                    </div>
                                </div>
                            </section>
                        </div>


                    </div>

                    <!-- BOTONES -->
                    <section class="col-12 mt-5 d-flex justify-content-center">

                        <!-- CANCELAR REGISTRO -->
                        <a href="servicios_activos.php"
                            class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>

                        <!-- REGISTRAR -->
                        <button type="submit" id="Registrar"
                            class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3">Guardar</button>

                    </section>
                    <!-- FIN BOTONES -->

                </form>

                <!--FIN FORMULARIO-->

            </div>
        </section>
    </section>

    <!-- CONTENEDOR CARGA -->
    <div id="contenedor_carga" style="display: none;">
        <div id="carga"></div>
    </div>



    <!-- SCRIPT -->

    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
    $(function() {
        $("#datepicker").datepicker({
            dateFormat: 'yy-mm-dd'
        });
        $("#datepicker1").datepicker({
            dateFormat: 'yy-mm-dd'
        });
    });

    function soloNumeros() {
        $('.numero_documento').keypress(function(tecla) {
            if (tecla.charCode < 48 || tecla.charCode > 57) return false;
        });
    }

    $(function() {
        $("#calendar").multiDatesPicker({
            dateFormat: 'yy-mm-dd',
            altField: '#fechas_duplicar',
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre",
                "Octubre", "Noviembre", "Diciembre"
            ],
            dayNames: ["Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado"],
            dayNamesMin: ["Dom", "Lun", "Mar", "Mier", "Jue", "Vier", "Sab"],
            multidate: true,
        });
    });

    $('.eliminarFechas').on('click', function() {
        $("#calendar").multiDatesPicker('removeIndexes', 0);
    });

    $(function() {
        $("#tabs").tabs();
    });

    $('.clockpicker').clockpicker({
        placement: 'top',
        align: 'left',
        donetext: 'Aplicar'
    });

    $('.clockpicker1').clockpicker({
        placement: 'top',
        align: 'left',
        donetext: 'Aplicar'
    });

    function validarTarifasClaseVeh(tipo_tarifa, servicio, id) {

        if (tipo_tarifa == 'fija') {
            $('#id_veh_relevo_' + servicio + id).val("");
            $('#id_veh_relevo_' + servicio + id).selectpicker("refresh");
        }

        var producto = $("#id_producto").val();
        var tipo_servicio = $("#tipo_servicio").val();
        var clase_veh = $("#id_tv_cliente_" + servicio + id).val();
        var fecha_inicial = $("#datepicker").val();
        var hora_inicial = $("#hora_inicial").val();
        var fecha_final = $("#datepicker1").val();
        var hora_final = $("#hora_final").val();

        var contenedor = document.getElementById("contenedor_carga");

        var parametros = {
            "id_producto": producto,
            "tipo_vehiculo_cliente": clase_veh,
            "tipo_tarifa": tipo_tarifa,
            "fecha_inicial": fecha_inicial,
            "hora_inicial": hora_inicial,
            "fecha_final": fecha_final,
            "hora_final": hora_final,
        };

        console.log(parametros);

        if (tipo_servicio == 'FIJO') {

            $.ajax({
                data: parametros,
                url: '../Controlador/listarTarifasClaseVehPorProd.php',
                type: 'POST',
                beforeSend: function() {
                    contenedor.style.display = 'flex';
                },
                success: function(response) {

                    //alert(response);
                    contenedor.style.display = 'none';
                    contenedor.style.opacity = '0';

                    if (response == 0) {
                        alertify.notify('No se encontraron tarifas para este producto', 'error');
                    } else {
                        let valores = response.split('_');

                        document.getElementById('valor_cliente_' + servicio + id).value = valores[0];
                        document.getElementById('valor_movil_' + servicio + id).value = valores[1];
                    }
                }
            });

        }
    }

    function validarContratosCliente(value) {
        var parametros = {
            "id_cliente": value,
        };

        $.ajax({
            data: parametros,
            url: '../Controlador/listarContratosPorCliente.php',
            type: 'POST',
            beforeSend: function() {
                $("#id_contrato").html("<option value=''>Procesando, espere por favor...</option>");
            },
            success: function(response) {
                $('#id_contrato').empty();
                $("#id_contrato").append(response);
            }
        });
    }

    function validarProductosCliente(value) {
        var parametros = {
            "id_cliente": value,
        };

        $.ajax({
            data: parametros,
            url: '../Controlador/listarProductosPorCliente.php',
            type: 'POST',
            beforeSend: function() {
                $("#id_producto").html("<option value=''>Procesando, espere por favor...</option>");
            },
            success: function(response) {
                $("#id_producto").html(response);
            }
        });
    }


    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

    function capitalizarPrimeraLetra(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }


    function convertirValorCliente(value, servicio, id) {
        if (value != "") {
            $("#valorCliente" + capitalizarPrimeraLetra(servicio) + id).html(
                '<p style="font-family: "Hind", sans-serif;"><b>$ ' + addCommas(value) + '</b></p>');
        } else {
            $("#valorCliente" + capitalizarPrimeraLetra(servicio) + id).html('');
        }
    }

    function convertirValorMovil(value, servicio, id) {
        if (value != "") {
            $("#valorMovil" + capitalizarPrimeraLetra(servicio) + id).html(
                '<p style="font-family: "Hind", sans-serif;"><b>$ ' + addCommas(value) + '</b></p>');
        } else {
            $("#valorMovil" + capitalizarPrimeraLetra(servicio) + id).html('');
        }
    }

    function listarConductoresPorVehiculo(id_vehiculo, servicio, id) {

        var parametros = {
            "id_vehiculo": id_vehiculo
        };
        $.ajax({
            data: parametros,
            url: '../Controlador/listarConductoresVehiculo.php',
            type: 'POST',
            beforeSend: function() {
                $("#id_conductor_" + servicio + id).html(
                    '<option value=""> CARGANDO CONDUCTORES ...</option>');
            },
            success: function(response) {
                $("#id_conductor_" + servicio + id).html(response);
            }
        });

    }

    function validarTiposVehiculos(value) {
        var parametros = {
            "id_cliente": value
        };

        $.ajax({
            data: parametros,
            url: '../Controlador/listarTiposVehiculoPorProductoCliente.php',
            type: 'POST',
            beforeSend: function() {
                $(".id_tv_cliente_entrada_new").html(
                    '<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                $(".id_tv_movil_entrada_new").html(
                    '<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                $(".id_tv_cliente_salida_new").html(
                    '<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                $(".id_tv_movil_salida_new").html(
                '<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
            },
            success: function(response) {
                $(".id_tv_cliente_entrada_new").html(response);
                $(".id_tv_movil_entrada_new").html(response);
                $(".id_tv_cliente_salida_new").html(response);
                $(".id_tv_movil_salida_new").html(response);
            }
        });
    }


    /* --------------------------------------- */
    /* --------------------------------------- */
    /* --------------------------------------- */


    function agregarFila(index) {
        var cliente = document.getElementById("id_cliente").value;
        var nFilas = $("#tabs-2 table").length;

        //alert(nFilas);
        var contenedor = document.getElementById("contenedor_carga");

        var parametros = {
            "total_filas": nFilas
        };

        $.ajax({
            data: parametros,
            url: '../Controlador/AgregarFilaVehSevicio.php',
            type: 'POST',
            beforeSend: function() {
                contenedor.style.display = 'flex';
            },
            success: function(response) {
                //alert(response);
                contenedor.style.display = 'none';
                contenedor.style.opacity = '0';

                $('#cant').val(nFilas + 1);
                $('#añadirCamposVeh').append(response);
                validarTiposVehiculos(cliente);


            }
        });

        soloNumeros();
    }

    function eliminarFila() {
        var nFilas = $("#tabs-2 table").length;
        var nVeh = $(".id_tv_cliente_salida").length;

        //alert(nVeh);

        var celdaAnterior = parseFloat(nFilas) - parseFloat(1);
        if (nFilas > nVeh) {
            $("#tabs-2 table:last").remove();
            $('#cant').val(celdaAnterior);
        }

    }

    function aplicarDescuento(descuento, tarifa, servicio, id){

        const valor = $("#valor_" + tarifa + "_" + servicio + id).val();
        const Totaldescuento = (valor*descuento)/100;

        if(descuento != ""){
            $("#valor" + capitalizarPrimeraLetra(tarifa) + capitalizarPrimeraLetra(servicio) + id).html(
                '<p style="font-family: "Hind", sans-serif;"><b>$ ' + addCommas(Math.round(valor - Totaldescuento)) + '</b></p>');
        }else{
            $("#valor" + capitalizarPrimeraLetra(tarifa) + capitalizarPrimeraLetra(servicio) + id).html('');
        }

    }

    </script>

    <!-- FIN SCRIPT -->

</body>

</html>