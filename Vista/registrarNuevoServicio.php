<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Contrato.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Operativo.php");

$vehiculo = new Vehiculo();
$cliente = new Cliente();
$operativo = new Operativo();

$hoy = date('Y-m-d');
$fecha2 = strtotime('-1 year',strtotime(date('Y-m-d')));
$fecha2 = date('Y-m-d',$fecha2);

/* ---------------------------- */
/* VALIDAR PERMISOS ESPECIFICOS */
/* ---------------------------- */

$id_usuario = $_SESSION['id_usuario'];
$listarPermisosUsuariosOperativo = $operativo->listarPermisosUsuariosOperativoIdUsuario($id_usuario);

$clientes = $listarPermisosUsuariosOperativo[0]['id_cliente'];
$registro = $listarPermisosUsuariosOperativo[0]['registro'];

/* ---------------------------- */
/* ---------------------------- */

$listarV = $vehiculo->listarActivos();

if($clientes == 'ALL'){
    $listadoClientes = $cliente->listar();
}else {
    $listadoClientes = $cliente->clientesAgrupadosPorId($clientes);
}

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>SistemaKV | Nuevo Servicio</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <?php include("Template/styles.php"); ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hind&display=swap');

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

    <!--MENU-->
    <?php include("Template/header.php"); ?>
        <?php include("Template/newMenu.php"); ?>
    <!--FIN MENU-->

    <!--**************************--->
  
    <!-- CONTENIDO -->
    
    <section class="home_content">  
        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="servicios_activos.php">Base Servicios</a></li>
                <li class="breadcrumb-item active" aria-current="page">Nuevo Servicio</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong>
                <i class="fa fa-gears mr-3" style="font-size: 2rem;"></i>
                <b style="font-size:1.3rem;">NUEVO SERVICIO</b>
            </strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/registrarBaseServicio.php" method="POST" enctype="multipart/form-data">

                    <!-- CANT VEHICULOS -->
                    <input type="hidden" name="cant" id="cant" value="1" class="form-control">

                    <div id="tabs">
                        <ul>
                            <?php if($registro == 'S'){ ?>
                                <li><a href="#tabs-1">Información </a></li>
                            <?php }else{ ?>
                                <li><a href="#tabs-1">Información </a></li>
                                <li><a href="#tabs-2">Vehículo(s)</a></li>
                                <li><a href="#tabs-3">Replicar</a></li>
                            <?php } ?>
                        </ul>

                        <?php if($registro == 'S'){ ?>
                            
                            <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-3">

                                <!-- CLIENTE -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Cliente <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="id_cliente"
                                            id="id_cliente" required="required"
                                            onchange="validarContratosCliente(this.value); validarProductosCliente(this.value); validarTiposVehiculosInitial(this.value);">
                                            <option value="">SELECCIONAR</option>
                                            <?php foreach ($listadoClientes as $lc){ ?>
                                            <option value="<?php echo $lc['id_cliente']; ?>">
                                                <?php echo $lc['razon_social'] . ' - Nit: ' . $lc['nit_cliente'];  ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- CONTRATO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Contrato <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control" data-live-search="true" name="id_contrato"
                                            id="id_contrato">
                                            <option class="fa" value=""> &#10071; PRIMERO SELECCIONE UN CLIENTE</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- TIPO SERVICIO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Tipo de Servicio <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            name="tipo_servicio" id="tipo_servicio" required="required"
                                            onchange="validarTipoServicio(this.value);">
                                            <option value="">SELECCIONAR</option>
                                            <option value="OCASIONAL">OCASIONAL</option>
                                            <option value="FIJO">FIJO</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- PRODUCTO -->
                                <div class="row mt-4" id="producto" style="display: none;">
                                    <div class="label">
                                        <label>Producto</label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control" data-live-search="true" name="id_producto"
                                            id="id_producto">
                                            <option class="fa" value=""> &#10071; PRIMERO SELECCIONE UN CLIENTE</option>
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
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- GRUPO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Grupo</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="grupo" id="grupo" class="form-control">
                                    </div>
                                </div>

                                <!-- SOLICITANTE -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Solicitante</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="solicitante" id="solicitante" value=""
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- FECHA INICIAL SERVICIO -->
                                <div class="row mt-3">
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Fecha Inicio <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <input tye="text" id="datepicker" name="fecha_inicial" class="form-control"
                                                    style="border-style: dashed;">
                                            </div>
                                        </div>
                                    </section>
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Hora <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="hora_inicial" id="hora_inicial" class="form-control"
                                                        required="required" style="border-style: dashed;">
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
                                        <label>Origen <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <input class="form-control" id="origen" name="origen" style="border-style: dashed;">
                                    </div>
                                </div>

                                <!-- DESTINO(S) -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Destino <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <input class="form-control" id="destino" name="destino"
                                            style="border-style: dashed;">
                                    </div>
                                </div>

                                <!-- FECHA INICIAL SERVICIO -->
                                <div class="row mt-3">
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Fecha Finalización <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <input tye="text" id="datepicker1" name="fecha_final" class="form-control"
                                                    style="border-style: dashed;">
                                            </div>
                                        </div>
                                    </section>
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Hora <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="hora_final" id="hora_final" class="form-control"
                                                        required="required" style="border-style: dashed;">
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
                                            style="border-style: dashed;" placeholder="(Banco de Consignación y Numero de Cuenta - Ocasionales)"></textarea>
                                    </div>
                                </div>

                                <!-- REQUISITOS -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Requisitos</label>
                                    </div>
                                    <div class="input">
                                        <textarea class="form-control" id="requisitos" name="requisitos"
                                            style="border-style: dashed;"></textarea>
                                    </div>
                                </div>

                            </div>

                        <?php }else{ ?>

                            <!-- INFORMACION BASICA-->
                            <div id="tabs-1" class="p-3">

                                <!-- CLIENTE -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Cliente <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true" name="id_cliente"
                                            id="id_cliente" required="required"
                                            onchange="validarContratosCliente(this.value); validarProductosCliente(this.value); validarTiposVehiculosInitial(this.value);">
                                            <option value="">SELECCIONAR</option>
                                            <?php foreach ($listadoClientes as $lc){ ?>
                                            <option value="<?php echo $lc['id_cliente']; ?>">
                                                <?php echo $lc['razon_social'] . ' - Nit: ' . $lc['nit_cliente'];  ?>
                                            </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>

                                <!-- CONTRATO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Contrato <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control" data-live-search="true" name="id_contrato"
                                            id="id_contrato" onchange="cargaMasiva();">
                                            <option class="fa" value=""> &#10071; PRIMERO SELECCIONE UN CLIENTE</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-11 m-4" style="display:none;" id="cargaMasiva">
                                    <div style="text-align:end;">
                                        <a style="cursor:pointer; font-size:.7rem; color:#5e99b1;" data-toggle="modal" data-target="#cargaMasivaModal"><b>PLANTILLA - CARGA MASIVA</b><i style="color:green;" class="fa fa-upload ml-2"></i></a>
                                    </div>
                                </div>

                                <!-- TIPO SERVICIO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Tipo de Servicio <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control selectpicker" data-live-search="true"
                                            name="tipo_servicio" id="tipo_servicio" required="required"
                                            onchange="validarTipoServicio(this.value);">
                                            <option value="">SELECCIONAR</option>
                                            <option value="OCASIONAL">OCASIONAL</option>
                                            <option value="FIJO">FIJO</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- PRODUCTO -->
                                <div class="row mt-4" id="producto" style="display: none;">
                                    <div class="label">
                                        <label>Producto</label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control" data-live-search="true" name="id_producto"
                                            id="id_producto">
                                            <option class="fa" value=""> &#10071; PRIMERO SELECCIONE UN CLIENTE</option>
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
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- GRUPO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Grupo</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="grupo" id="grupo" class="form-control">
                                    </div>
                                </div>

                                <!-- SOLICITANTE -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Solicitante</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="solicitante" id="solicitante" value=""
                                            class="form-control">
                                    </div>
                                </div>

                                <!-- FECHA INICIAL SERVICIO -->
                                <div class="row mt-3">
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Fecha Inicio <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <input tye="text" id="datepicker" name="fecha_inicial" class="form-control"
                                                    style="border-style: dashed;">
                                            </div>
                                        </div>
                                    </section>
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Hora <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="hora_inicial" id="hora_inicial" class="form-control"
                                                        required="required" style="border-style: dashed;">
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
                                        <label>Origen <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <input class="form-control" id="origen" name="origen" style="border-style: dashed;">
                                    </div>
                                </div>

                                <!-- DESTINO(S) -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Destino <i style="font-size: .4rem;"
                                                class="fa fa-asterisk"></i></label></label>
                                    </div>
                                    <div class="input">
                                        <input class="form-control" id="destino" name="destino"
                                            style="border-style: dashed;">
                                    </div>
                                </div>

                                <!-- FECHA INICIAL SERVICIO -->
                                <div class="row mt-3">
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Fecha Finalización <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <input tye="text" id="datepicker1" name="fecha_final" class="form-control"
                                                    style="border-style: dashed;">
                                            </div>
                                        </div>
                                    </section>
                                    <section class="col-6">
                                        <div class="row">
                                            <div class="label">
                                                <label>Hora <i style="font-size: .4rem;"
                                                        class="fa fa-asterisk"></i></label></label>
                                            </div>
                                            <div class="input">
                                                <div class="input-group clockpicker">
                                                    <input type="text" name="hora_final" id="hora_final" class="form-control"
                                                        required="required" style="border-style: dashed;">
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
                                            style="border-style: dashed;" placeholder="(Banco de Consignación y Numero de Cuenta - Ocasionales)"></textarea>
                                    </div>
                                </div>

                                <!-- REQUISITOS -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Requisitos</label>
                                    </div>
                                    <div class="input">
                                        <textarea class="form-control" id="requisitos" name="requisitos"
                                            style="border-style: dashed;"></textarea>
                                    </div>
                                </div>

                                <hr>

                                <!-- ************************************* -->
                                <div class="col-12 p-3" style="border: 1px dashed #d3d3d3; display:none;">

                                    <p class="text-center mt-2"><i class="fa fa-star mr-2" style="color: gold;"></i>Calificación del Servicio (Ocasional - Express)</p>
                                    

                                    <div class="row mt-5">
                                        <div class="label">
                                            <label>Puntualidad</label>
                                        </div>
                                        <div class="input">
                                            <select name="puntualidad" id="puntualidad" class="form-control form-control-sm selectpicker" data-live-search="true" title="Calificar">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>

                                            <textarea name="detalle_punt" id="detalle_punt" class="form-control form-control-sm mt-2" style="border-style:dashed;"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Limpieza del Vehículo  Presentación del Conductor</label>
                                        </div>
                                        <div class="input">
                                            <select name="limpieza_presentacion" id="puntualidad" class="form-control form-control-sm selectpicker" data-live-search="true" title="Calificar">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>

                                            <textarea name="detalle_punt" id="detalle_punt" class="form-control form-control-sm mt-2" style="border-style:dashed;"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Atención y Servicio del Conductor</label>
                                        </div>
                                        <div class="input">
                                            <select name="atencion_servicio" id="atencion_servicio" class="form-control form-control-sm selectpicker" data-live-search="true" title="Calificar">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="10">10</option>
                                            </select>
                                            
                                            <textarea name="detalle_punt" id="detalle_punt" class="form-control form-control-sm mt-2" style="border-style:dashed;"></textarea>
                                        </div>
                                    </div>

                                    <div class="row mt-4">
                                        <div class="label">
                                            <label>Critica Constructiva para el mejoramiento del servicio</label>
                                        </div>
                                        <div class="input">
                                            <textarea name="critica_constructiva" id="" class="form-control"></textarea>
                                        </div>
                                    </div>

                                </div>

                            </div>

                            <!-- VEHICULO(S)-->
                            <div id="tabs-2">

                                <table id="table_1" style="text-align: center; width:100%;">
                                    <thead>
                                        <tr>
                                            <th width="60px;"></th>
                                            <th width="90px;">1</th>
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

                                        <!-- BOTONES AGREGAR Y ELIMINAR-->
                                        <div class="row">
                                            <section class="col-6 d-flex justify-content-end">
                                                <button type="button" class="btn btn-outline-info col-2"
                                                    onclick="agregarFila()"><i class="fa fa-plus"></i> Agregar</button>
                                            </section>
                                            <section class="col-6 d-flex justify-content-start">
                                                <button type="button" class="btn btn-outline-danger col-2"
                                                    onclick="eliminarFila();"><i class="fa fa-times"></i> Eliminar</button>
                                            </section>
                                        </div>

                                        <hr>

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
                                                    id="id_tv_cliente_entrada1">
                                                    <option value="" style="background-color: #fff !important;">CLIENTE
                                                    </option>
                                                </select>
                                                <hr>
                                                <select class="form-control form-control-sm id_tv_movil_entrada"
                                                    data-live-search="true" name="id_tv_movil_entrada[]"
                                                    id="id_tv_movil_entrada1">
                                                    <option value="">MOVIL</option>
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
                                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                                    name="id_conductor_entrada[]" id="id_conductor_entrada1">
                                                    <option value="">CONDUCTOR</option>
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
                                                    name="descuento_cliente_entrada[]" id="descuento_cliente_entrada1"
                                                    placeholder="%" onBlur="aplicarDescuento(this.value, 'cliente', 'entrada', 1);">
                                            </td>

                                            <td>
                                                <div>
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
                                                    id="id_tv_cliente_salida1">
                                                    <option value="" style="background-color: #fff !important;">CLIENTE
                                                    </option>
                                                </select>

                                                <hr>

                                                <select class="form-control form-control-sm id_tv_movil_salida"
                                                    data-live-search="true" name="id_tv_movil_salida[]"
                                                    id="id_tv_movil_salida1">
                                                    <option value="">MOVIL</option>
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
                                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                                    name="id_conductor_salida[]" id="id_conductor_salida1">
                                                    <option value="">CONDUCTOR</option>
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
                                                <div">
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
                                            <button class="btn eliminarFechas" id="buttonsKV"
                                                onclick="eliminarFechas();">Borrar</button>
                                        </div>
                                    </div>
                                </section>
                            </div>

                        <?php } ?>

                    </div>

                    <!-- BOTONES -->

                    <section class="col-12 mt-5 d-flex justify-content-center">

                        <!-- CANCELAR REGISTRO -->
                        <a href="servicios_activos.php"
                            class="btn btn-outline-danger col-xs-12 col-sm-12 col-md-3 mr-3">Cancelar</a>

                        <!-- REGISTRAR -->
                        <button type="submit" id="Registrar" class="btn btn-outline-success col-xs-12 col-sm-12 col-md-3" onclick="validarReplicar();">Guardar</button>

                    </section>
                    <!-- FIN BOTONES -->

                </form>
            </div>
        </section>

    </section>

    <!---------------------->

    <!-- CONTENEDOR CARGA -->

    <div id="contenedor_carga" style="display: none;">
        <div id="carga"></div>
    </div>

    <!---------------------->

    <!-- MODAL -->

    <div class="modal fade" id="cargaMasivaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body p-4">
                    <p style="font-size:1.3rem;"><b>Carga Masiva:</b></p>
                    <p>
                        La carga masiva permite cargar multiples servicios a través de archivos en excel a la plataforma 
                        <p style="color:#FEAF20;">SISTEMA <span style="color:#5e99b1;" class="lite">KV</span></p>
                    </p>
                    <p style="color:#77b9d3; cursor:pointer;" class="mt-2 mb-2" onclick="descargarPlantillaExcelCargaMasiva();"><i class="fa fa-circle-thin mr-2" style="color:#5e99b1; font-size: .5rem;"></i>Descargar Formato<i style="font-size:1.2rem;" class="fa fa-file-excel-o ml-2"></i></p>
                    <div class="p-3 mt-3" style="border: 2px dashed #ededed;">
                        <p class="mt-1 mb-1" style="font-size:.8rem;"><b>Nota: </b> Por favor, seguir el orden y formato de los datos segun la plantilla suministrada, la carga solo se realizará si se ha seleccionado <b>un cliente y contrato activo</b>.</p>
                    </div>
                    
                    <hr>

                    
                    <section class="d-flex justify-content-center p-3">
                        <form action="../Controlador/realizarCargaMasivaServicios.php" method="POST" enctype="multipart/form-data">
                            <div class="row" style="border: 2px dashed #ededed;">
                                <div class="col-12 mt-2">
                                    <label for="doc_carga_masiva">Documento Excel (Plantilla)</label>
                                    <input type="file" id="doc_carga_masiva" name="doc_carga_masiva" class="form-control form-control-sm">
                                </div>
                                <div class="col-12 mt-4 mb-3 d-flex justify-content-center" >
                                    <button type="submit" class="btn btn-outline-success btn-sm col-6">Cargar</button>
                                </div>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->

    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        
        $(function() {

            $("#tabs").tabs();

            $("#datepicker").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#datepicker1").datepicker({
                dateFormat: 'yy-mm-dd'
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

        });

        function soloNumeros() {
            $('.numero_documento').keypress(function(tecla) {
                if (tecla.charCode < 48 || tecla.charCode > 57) return false;
            });
        }

        function cargaMasiva() {
            var id_cliente = $("#id_cliente").val();
            var id_contrato = $("#id_contrato").val();

            if(id_cliente != "" && id_contrato != ""){
                document.getElementById("cargaMasiva").style.display = 'block';
            }else{
                document.getElementById("cargaMasiva").style.display = 'none';
            }
        }

        function descargarPlantillaExcelCargaMasiva(){
            
            var id_cliente = $("#id_cliente").val();
            var id_contrato = $("#id_contrato").val();

            if(id_cliente != "" && id_contrato != ""){
                var url = 'Excel/CargaMasivaExcelBaseServicios.php?id_cliente=' + id_cliente + '&id_contrato=' + id_contrato;
                location.href = url;
            }else{
                alertify.notify('Debe seleccionar un cliente y contrato para poder realizar la descarga.', 'error');
            }
            
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

        function validarReplicar(){
            var fechas_duplicar = document.getElementId("fechas_duplicar").value;

            if(fechas_duplicar != ""){
                alertify.confirm("Esta por replicar el servicio, ¿esta seguro de esta acción?", function(){ alertify.success('Confirmar') });    
            }
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

        /* ----------------------------------------------------- */
        /* ---------------------- FUNCIONES  ------------------- */
        /* ----------------------------------------------------- */

        function validarTipoServicio(val) {
            //alert(val);
            if (val == 'FIJO') {
                document.getElementById("producto").style.display = 'flex';
            } else {
                document.getElementById("producto").style.display = 'none';
            }
        }

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
            //alert(id_vehiculo);
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
                    //$("#id_conductor_" + servicio + id).html(response);
                    $("#id_conductor_" + servicio + id).html(response).selectpicker('refresh');
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
                    $(".id_tv_cliente_entrada_new").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_movil_entrada_new").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_cliente_salida_new").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_movil_salida_new").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                },
                success: function(response) {
                    $(".id_tv_cliente_entrada_new").html(response).selectpicker('refresh');
                    $(".id_tv_movil_entrada_new").html(response).selectpicker('refresh');
                    $(".id_tv_cliente_salida_new").html(response).selectpicker('refresh');
                    $(".id_tv_movil_salida_new").html(response).selectpicker('refresh');
                }
            });
        }

        function validarTiposVehiculosInitial(value) {
            var parametros = {
                "id_cliente": value
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/listarTiposVehiculoPorProductoCliente.php',
                type: 'POST',
                beforeSend: function() {
                    $(".id_tv_cliente_entrada").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_movil_entrada").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_cliente_salida").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                    $(".id_tv_movil_salida").html('<option value=""> CARGANDO TIPOS VEHICULOS ...</option>');
                },
                success: function(response) {
                    $(".id_tv_cliente_entrada").html(response).selectpicker('refresh');
                    $(".id_tv_movil_entrada").html(response).selectpicker('refresh');
                    $(".id_tv_cliente_salida").html(response).selectpicker('refresh');
                    $(".id_tv_movil_salida").html(response).selectpicker('refresh');
                }
            });
        }

        /* ------------------------------------------------------------- */
        /* ---------------------- OPCIONES VEHICULOS ------------------- */
        /* ------------------------------------------------------------- */

        function agregarFila(index) {

            var cliente = document.getElementById("id_cliente").value;
            var nFilas = $("#tabs-2 table").length;

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
            var celdaAnterior = parseFloat(nFilas) - parseFloat(1);
            if (nFilas > 1) {
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