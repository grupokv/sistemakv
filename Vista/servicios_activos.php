<?php 

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Usuario.php");
require_once("../Modelo/Cliente.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/Conductor.php");
require_once("../Modelo/General.php");

$operativo = new Operativo();
$conductor = new Conductor();
$vehiculo = new Vehiculo();
$usuario = new Usuario();
$cliente = new Cliente();

/* ---------------------------- */
/* VALIDAR PERMISOS GENERALES */
/* ---------------------------- */

$modulo = 115;
$permisos = permisos($modulo, $_SESSION['id_usuario']);

$eliminar = $permisos[0]['eliminacion']; 
$editar = $permisos[0]['edicion']; 
$registro = $permisos[0]['agregacion']; 

/* ---------------------------- */
/* VALIDAR PERMISOS ESPECIFICOS */
/* ---------------------------- */

$id_usuario = $_SESSION['id_usuario'];
$listarPermisosUsuariosOperativo = $operativo->listarPermisosUsuariosOperativoIdUsuario($id_usuario);

$reportes = $listarPermisosUsuariosOperativo[0]['lectura_reportes'];
$lectura_reportes = explode(",", $reportes);

$clientes = $listarPermisosUsuariosOperativo[0]['id_cliente'];

/* ---------------------------- */
/* ---------------------------- */


$inicio_semana = date("Y-m-d", strtotime('last Monday'));
$fin_semana = date("Y-m-d", strtotime('this Sunday'));

$listarServiciosActivos = $operativo->listarServiciosActivos(date('Y-m-d'), date('Y-m-d'));

if($clientes == 'ALL'){
    $listarClientes = $cliente->listar();
}else {
    $listarClientes = $cliente->clientesAgrupadosPorId($clientes);
}

$opciones_adicionales = $listarPermisosUsuariosOperativo[0]['opciones_adicionales'];

$listarVehActivos = $vehiculo->listarActivos();
$listarConductoresActivos = $conductor->listarConductoresActivos();
$listarProductos = $operativo->listarProductos();
$listarUsuariosEmisores = $usuario->listarUsuariosEmisores();

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>SistemaKV | Servicios Activos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- STYLES -->
    <?php include("Template/styles.php") ?>
    <link rel="stylesheet" href="../Resources/css/stylesHeader.css">

    <style>

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

        th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
            padding: 10px;
        }

        #servicios thead {
            background-color: #fff;
        }

        #servicios table {
            font-size: .8rem;
        }

        #servicios tr {
            background-color: #fff;
        }

        #servicios th {
            border-radius: 13px;
            border: 3px solid #fff;
            background-color: #274054;
            color: #fff;
        }

        #contEstado {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            cursor: pointer;
        }

        .dropdown-menu .show {
            max-width: 400px !important;
            min-width: 300px !important;
        }

        #buttonExcel {
            width: 115px;
            color: #1d9c72;
            border: 1px solid #1d9c72;
            border-radius: 5px;
            cursor: pointer;
        }

        #buttonExcel:hover {
            color: #fff;
            background-color: #1d9c72;
            transition-duration: .8s;
        }

        #buttonPDF {
            width: 115px;
            color: #d81928;
            border: 1px solid #d81928;
            border-radius: 5px;
            cursor: pointer;
        }

        #buttonPDF:hover {
            color: #fff;
            background-color: #d81928;
            transition-duration: .8s;
        }

        #filterActive {
            height: auto;
            width: auto;
            padding: 0px 10px 0px 10px;
            background: #1b2d3b;
            color: #fff;
            border-radius: 5px;
        }

        .ajs-button {
            border-radius: 5px;
            background-color: #5e99b1;
            color: #fff;
            box-shadow: none;
            border: 0px;
        }

        .ajs-header {
            color: #1b2d3b !important;
        }

        .optionsTable{
            color: #274054; 
            cursor: pointer;
        }

        .optionsTable:hover{
            color: #5e99b1;
        }

    </style>

    <!-- FIN STYLES -->

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
                <li class="breadcrumb-item " aria-current="page"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Servicios</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i><b style="font-size:1.3rem;">BASE
                    SERVICIOS (ACTIVOS)</b></strong>
        </div>

        <div style="width: 100%; height: auto; padding: 5px; background-color: #fff; border-radius: 10px;">

            <!-- REGISTRAR -->
            <?php if($registro == 1){ ?>
            <a href="registrarNuevoServicio.php" class="btn btn-outline-info" id="buttonsKV"
                style="border-radius: 10px;">Nuevo Servicio <i class="fa fa-plus-circle"></i></a>
            <?php } ?>

            <!-- FILTRAR-->
            <button type="button" class="btn mr-3" data-toggle="modal" id="buttonsKV" data-target="#modalFilter"
                style="border-radius: 10px;">Filtrar <i class="fa fa-search ml-1"></i></button>

        </div>

        <div class="mt-2" style="height: auto; padding: 2px; width: 100%; background-color: #fff; border-radius: 10px;">
            <section class="row ml-3">
                <?php for ($i=0; $i < count($lectura_reportes) ; $i++) { ?>
                <?php if($lectura_reportes[$i] == 1) { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('1');">Individual<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 2) { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('2');">Por Cliente<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 3) { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('3');">Por Producto<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 4) { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('4');">Por Movil<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 5) { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('5');" style="width: 148px">Movil
                    Por Recorrido<i class="fa fa-file-excel-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 6) { ?>
                <div id="buttonPDF" class="text-center m-1" onclick="validarExcel('6');" style="width: 148px">
                    Prefactura<i class="fa fa-file-pdf-o ml-1"></i></div>
                <?php } else if($lectura_reportes[$i] == 'ALL') { ?>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('1');">Individual<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('2');">Por Cliente<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('3');">Por Producto<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('4');">Por Movil<i
                        class="fa fa-file-excel-o ml-1"></i></div>
                <div id="buttonExcel" class="text-center m-1" onclick="validarExcel('5');" style="width: 148px">Movil
                    Por Recorrido<i class="fa fa-file-excel-o ml-1"></i></div>
                <div id="buttonPDF" class="text-center m-1" onclick="validarExcel('6');" style="width: 148px">
                    Prefactura<i class="fa fa-file-pdf-o ml-1"></i></div>
                <?php } ?>
                <?php } ?>
            </section>
        </div>

        <div class="mt-2 p-4 table-responsive" id="servicios" style="background-color: #fff;">

            <div class="col-12 d-flex justify-content-end mb-4">

                <?php if($opciones_adicionales == 1){ ?>
                    <p class="optionsTable" id="replicar_serv" data-toggle="modal" data-target="#replicarServicios">| Replicar Servicios <i class="fa fa-reply-all ml-1 mr-1"></i></p>
                    <p class="optionsTable" id="reajustar_valor" onclick="reajustarValores();">| Reajustar Valores <i class="fa fa-refresh ml-1 mr-1"></i></p>
                    <p class="optionsTable" onclick="selectAll();"> | Selecccionar Pag. <i class="fa fa-circle ml-1 mr-1"></i></p>
                    <p class="optionsTable" onclick="unselectAll();"> | Deseleccionar Pag. <i class="fa fa-circle-o ml-1 mr-1"></i> |</p>
                <?php } else if($opciones_adicionales == 2) { ?>
                    <p class="optionsTable" id="reajustar_valor" onclick="reajustarValores();">| Reajustar Valores <i class="fa fa-refresh ml-1 mr-1"></i></p>
                    <p class="optionsTable" onclick="selectAll();"> | Selecccionar Pag. <i class="fa fa-circle ml-1 mr-1"></i></p>
                    <p class="optionsTable" onclick="unselectAll();"> | Deseleccionar Pag. <i class="fa fa-circle-o ml-1 mr-1"></i> |</p>
                <?php } ?>

            </div>

            <table id="data" class="table table-hover table-sm display text-center" style="width:100%">
                <thead style="background-color: #1b2d3b; color: #fff;">
                    <tr>
                        <th style="vertical-align: top;">ID SERVICIO</th>
                        <th style="vertical-align: top;">FECHA INICIO</th>
                        <th style="vertical-align: top;">FECHA FINAL</th>
                        <th style="vertical-align: top;">CONTRATO</th>
                        <th style="vertical-align: top;">CLIENTE</th>
                        <th style="vertical-align: top;">EMPRESA</th>
                        <th style="vertical-align: top;">PRODUCTO</th>
                        <th style="vertical-align: top;">DIVISIÓN</th>
                        <th style="vertical-align: top;">GRUPO</th>
                        <th style="vertical-align: top;">TIPO</th>
                        <th style="vertical-align: top;">SOLICITANTE</th>
                        <th style="vertical-align: top;">ESTADO</th>
                        <th style="vertical-align: top;">OPCIONES</th>
                        <th style="vertical-align: top;"></th>
                    </tr>
                </thead>
                <tbody id="infoServiceTable" style="font-size: .8rem;">
                </tbody>

            </table>
        </div>

    </section>
    <!-- FIN CONTENIDO -->


    <!------------------------------------------------ -->
    <!------------------------------------------------ -->

    <!-- MODAL VEHICULOS -->
    <div class="modal" id="vehiculosServicio" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="contentVehServ">

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL FILTRO -->
    <div class="modal fade" id="modalFilter" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!-- <div class="modal-dialog" style="left: -380px;"> -->
        <div class="modal-dialog">
            <div class="modal-content" style="height: 500px; overflow-y: scroll;">
                <div class="modal-body">
                    <form action="" method="POST" id="filter">
                        <div class="col-12">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i
                                    aria-hidden="true">&times;</i></button>
                            <h5><b><i class="fa fa-filter mr-1"></i>FILTRO(S)</b></h5>
                        </div>

                        <hr class="mt-5">

                        <div class="row" id="dataFilter" style="width: 100%; height: auto; padding: 5px; background-color: #fafafa; border-radius: 10px;">
                            
                        </div>

                        <hr class="mt-2">

                        <section class="col-12 p-2" style=" background-color: #fafafa; font-size: .7rem;">

                            <!-- CLIENTE -->
                            <div class="col-12 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#id_cliente"><b>CLIENTE</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="id_cliente" id="id_cliente" style="border-style: dashed;"
                                    onchange="validarProductosCliente(this.value); validarContratosCliente(this.value);">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarClientes as $lc){ ?>
                                    <option value="<?php echo $lc['id_cliente'] ?>">
                                        <?php echo $lc['razon_social']; ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- CONTRATO -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label><b>CONTRATO</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_contrato"
                                    id="id_contrato" onchange="cargaMasiva();">
                                    <option class="fa" value=""> &#10071; PRIMERO SELECCIONE UN CLIENTE</option>
                                </select>
                            </div>

                            <!-- TIPO SERVICIO -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#tipo_servicio"><b>TIPO SERVICIO</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="tipo_servicio" id="tipo_servicio" style="border-style: dashed;">
                                    <option value="">SELECCIONAR</option>
                                    <option value="OCASIONAL">OCASIONAL</option>
                                    <option value="FIJO">FIJO</option>
                                </select>
                            </div>

                            <!-- FECHAS -->
                            <section class="row mt-3 p-2"
                                style="border: 1px dashed #d3d3d3; background-color: #fff; width: 100%; margin: 0px;">
                                <div class="col-6">
                                    <label for="#fecha_inicial"><b>DESDE</b></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="FECHA INICIAL"
                                        name="fecha_inicial" id="fecha_inicial" style="border-style: dashed;">
                                </div>

                                <div class="col-6">
                                    <label for="#fecha_final"><b>HASTA</b></label>
                                    <input type="text" class="form-control form-control-sm" placeholder="FECHA FINAL"
                                        name="fecha_final" id="fecha_final" style="border-style: dashed;">
                                </div>
                            </section>

                            <!-- EMISOR -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#emisor"><b>EMISOR</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="emisor" id="emisor" style="border-style: dashed;">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarUsuariosEmisores as $lue){ ?>
                                    <option value="<?php echo $lue['id_usuario'] ?>"><?php echo $lue['nombre'] ?>
                                    </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- VEHICULO -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#id_vehiculo"><b>VEHÍCULO - MOVIL</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="id_vehiculo" id="id_vehiculo" style="border-style: dashed;">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarVehActivos as $lva){ ?>
                                    <option value="<?php echo $lva['id_vehiculo'] ?>">
                                        <?php echo $lva['placa'] . ' - ' . $lva['numero_movil'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- CONDUCTOR  -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#id_conductor"><b>CONDUCTOR</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="id_conductor" id="id_conductor" style="border-style: dashed;">
                                    <option value="">SELECCIONAR</option>
                                    <?php foreach ($listarConductoresActivos as $lca){ ?>
                                    <option value="<?php echo $lca['id_conductor'] ?>">
                                        <?php echo $lca['nombre_conductor']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <!-- PENDIENTE ASIGNACIÓN -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#pend_asignacion"><b>PENDIENTE ASIGNACIÓN</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="pend_asignacion" id="pend_asignacion" style="border-style: dashed;">
                                    <option value="">SELECCIONAR</option>
                                    <option value="PA">SI</option>
                                    <option value="A">NO</option>
                                </select>
                            </div>

                            <!-- PRODUCTO -->
                            <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                <label for="#id_producto"><b>PRODUCTO</b></label>
                                <select class="form-control form-control-sm selectpicker" data-live-search="true"
                                    name="id_producto" id="id_producto" style="border-style: dashed;">

                                </select>
                            </div>

                        </section>

                        <hr>
                            <section class="col-12 p-2" style=" background-color: #fafafa; font-size: .7rem;">
                                <div class="col-12 d-flex justify-content-center">
                                    <p style="font-size: .8rem;"><b>REPORTE(S) PREFACTURA</b></p>    
                                </div>

                                <div class="col-12 mt-3 p-2" style="border: 1px dashed #d3d3d3; background-color: #fff;">
                                    <label for="#id_producto"><b>N° SERVICIO (OPCIONAL)</b></label>
                                    <input class="form-control form-control-sm" name="num_servicio" id="num_servicio" style="border-style: dashed;">
                            </div>
                            </section>
                        <hr>

                        <section class="d-flex justify-content-center m-2">
                            <button type="button" data-dismiss="modal" class="btn btn-outline-danger btn-sm col-3">
                                Cerrar</button>
                            <button type="button" onclick="limpiarCamposFiltro();"
                                class="btn btn-outline-info btn-sm ml-2 col-3" data-dismiss="modal" id="limpiar">
                                Limpiar Filtro</button>
                            <button type="button" class="btn btn-sm ml-2 col-3" id="buttonsKV"
                                onclick="cargarServicios();" data-dismiss="modal"> Filtrar</button>
                        </section>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- MODAL VEHICULOS -->
    <div class="modal" id="replicarServicios" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <div id="contentRepServ">
                        <section class="row d-flex justify-content-around">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="cont_replicar">
                                <section class="col-12 text-center mt-1 mb-3" style="height: 450; border-radius: 12px; border: 2px solid #f2f2f2">
                                    <p style="font-size: 1.7rem; margin-top: 15px; color: #274054; font-family: 'Hind', sans-serif;">
                                        <b>REPLICAR SERVICIO(S)</b>
                                    </p>

                                    <div id="calendar"></div>
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="cont_replicar">
                                        <div class="col-12 p-2 mt-4">
                                            <textarea name="fechas_duplicar" id="fechas_duplicar" readonly style="width: 100%; border: 1px solid #f2f2f2"></textarea>
                                        </div>
                                    </div>

                                </section>

                                <div class="row m-4">
                                    <section class="col-12 d-flex justify-content-center">
                                        <button type="button" class="btn btn btn-outline-danger col-4" style="border-radius:10px;">Cerrar</button>
                                        <button type="submit" id="buttonsKV" class="btn col-4 ml-2 replicarServ">Replicar</button>
                                    </section>
                                </div>

                            </div>

                        </section>            
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!------------------------------------------------ -->
    <!------------------------------------------------ -->

    <!-- SCRIPT -->
    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">

        var servicios = new Array();

        $(document).ready(function() {
            cargarServicios();

            var id_cliente = $("#id_cliente").val();
            validarProductosCliente(id_cliente);

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

        $('.replicarServ').click(function(){
            if(servicios.length == 0){
                alertify.error("No hay servicios seleccionados para replicar.");
            }else{

                let fechasReplicar = document.getElementById('fechas_duplicar');
                let parametros = {
                    "id_servicios": servicios,
                    "fechas": fechasReplicar.value,
                };

                $.ajax({
                    data: parametros,
                    url: '../Controlador/replicarBaseServicios.php',
                    type: 'POST',
                    beforeSend: function() {
                    },
                    success: function(response) {
                        $('#replicarServicios').modal('hide');
                        alertify.message(response);
                        cargarServicios();
                        servicios.length = 0;
                    }
                });
            }
        });


        function validarContratosCliente(value) {
            var parametros = {
                "id_cliente": value,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/listarContratosPorCliente.php',
                type: 'POST',
                beforeSend: function() {
                    $("#id_contrato").selectpicker("refresh");
                },
                success: function(response) {
                    $("#id_contrato").html(response).selectpicker('refresh');
                }
            });
        }

        function validarProductosCliente(val) {
            //alert(val);
            var parametros = {
                "id_cliente": val,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/validarProductosClienteFiltroServicios.php',
                type: 'POST',
                beforeSend: function() {
                    $("#id_producto").selectpicker("refresh");
                },
                success: function(response) {
                    //alert(response);
                    $("#id_producto").html(response).selectpicker('refresh');
                }
            });
        }

        function validarExcel(val) {

            var id_cliente = $("#id_cliente").val();
            var id_contrato = $("#id_contrato").val();
            var tipo_servicio = $("#tipo_servicio").val();
            var fecha_inicial = $("#fecha_inicial").val();
            var fecha_final = $("#fecha_final").val();
            var emisor = $("#emisor").val();
            var id_vehiculo = $("#id_vehiculo").val();
            var id_conductor = $("#id_conductor").val();
            var pend_asignacion = $("#pend_asignacion").val();
            var id_producto = $("#id_producto").val();
            var num_servicio = $("#num_servicio").val();

            if (val == 1) {
                //alert(val);
                var url = 'Excel/excelGeneralServicios.php?id_cliente=' + id_cliente + '&tipo_servicio=' + tipo_servicio +
                    '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' + emisor +
                    '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                    pend_asignacion + '&id_producto=' + id_producto;
                location.href = url;

            } else if (val == 2) {
                var url = 'Excel/excelClientesServicios.php?id_cliente=' + id_cliente + '&tipo_servicio=' + tipo_servicio +
                    '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' + emisor +
                    '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                    pend_asignacion + '&id_producto=' + id_producto;
                location.href = url;
            } else if (val == 3) {
                var url = 'Excel/excelProductosServicios.php?id_cliente=' + id_cliente + '&tipo_servicio=' + tipo_servicio +
                    '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' + emisor +
                    '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                    pend_asignacion + '&id_producto=' + id_producto;
                location.href = url;
            } else if (val == 4) {
                var url = 'Excel/excelVehiculosServicios.php?id_cliente=' + id_cliente + '&tipo_servicio=' + tipo_servicio +
                    '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' + emisor +
                    '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                    pend_asignacion + '&id_producto=' + id_producto;
                location.href = url;
            } else if (val == 5) {
                if (id_vehiculo != "") {
                    var url = 'Excel/excelRecorridoServicios.php?id_cliente=' + id_cliente + '&tipo_servicio=' +
                        tipo_servicio + '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' +
                        emisor + '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                        pend_asignacion + '&id_producto=' + id_producto;
                    location.href = url;
                } else {
                    alertify.notify('Es necesario seleccionar un vehículo', 'error');
                }
            } else if (val == 6) {
                if (id_cliente != "") {
                    var url = 'PDF/prefactura.php?id_cliente=' + id_cliente + '&id_contrato=' + id_contrato + '&tipo_servicio=' +
                        tipo_servicio + '&fecha_inicial=' + fecha_inicial + '&fecha_final=' + fecha_final + '&emisor=' +
                        emisor + '&id_vehiculo=' + id_vehiculo + '&id_conductor=' + id_conductor + '&pend_asignacion=' +
                        pend_asignacion + '&id_producto=' + id_producto + '&num_servicio=' + num_servicio;
                    //location.href = url;
                    window.open(url, '_blank');
                } else {
                    alertify.notify('Es necesario seleccionar un Cliente', 'error');
                }
            }

        }

        function confirmarEliminaciónServicio(val) {

            var parametros = {
                "id_servicio": val,
            };

            alertify.confirm('Confirmación de Eliminación', 'Esta por eliminar el servicio ¿esta segur@ de esta acción?',
                function() {
                    $.ajax({
                        data: parametros,
                        url: '../Controlador/eliminarBaseServicio.php',
                        type: 'POST',
                        beforeSend: function() {
                            $('#data').DataTable().clear();
                            $('#data').DataTable().destroy();
                        },
                        success: function(response) {
                            //alert(response);
                            cargarServicios();
                            alertify.success('Eliminado');
                        }
                    });
                },
                function() {
                    alertify.error('Acción Cancelada');
                }
            );

        }

        function limpiarCamposFiltro() {

            $('#id_cliente').val('');
            $("#id_cliente").selectpicker("refresh");

            $('#tipo_servicio').val('');
            $("#tipo_servicio").selectpicker("refresh");

            $('#fecha_inicial').val('');
            $('#fecha_final').val('');

            $('#emisor').val('');
            $("#emisor").selectpicker("refresh");

            $('#id_vehiculo').val('');
            $("#id_vehiculo").selectpicker("refresh");

            $('#id_conductor').val('');
            $("#id_conductor").selectpicker("refresh");

            $('#pend_asignacion').val('');
            $("#pend_asignacion").selectpicker("refresh");

            $('#id_producto').val('');
            $("#id_producto").selectpicker("refresh");

            $.ajax({
                url: '../Controlador/limpiarFiltroServicios.php',
                type: 'POST',
                beforeSend: function() {
                },
                success: function(response) {
                    cargarServicios();
                    alertify.notify('Filtro Restablecido', 'success');
                }
            });
        }

        function cargarServicios() {

            var id_cliente = $("#id_cliente").val();
            var tipo_servicio = $("#tipo_servicio").val();
            var fecha_inicial = $("#fecha_inicial").val();
            var fecha_final = $("#fecha_final").val();
            var emisor = $("#emisor").val();
            var id_vehiculo = $("#id_vehiculo").val();
            var id_conductor = $("#id_conductor").val();
            var pend_asignacion = $("#pend_asignacion").val();
            var id_producto = $("#id_producto").val();

            var parametros = {
                "id_cliente": id_cliente,
                "tipo_servicio": tipo_servicio,
                "fecha_inicial": fecha_inicial,
                "fecha_final": fecha_final,
                "emisor": emisor,
                "id_vehiculo": id_vehiculo,
                "id_conductor": id_conductor,
                "pend_asignacion": pend_asignacion,
                "id_producto": id_producto,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/baseServicios.php',
                type: 'POST',
                beforeSend: function() {
                    $('#data').DataTable().clear();
                    $('#data').DataTable().destroy();
                },
                success: function(response) {
                    //alert(response);
                    $("#infoServiceTable").empty();
                    $("#infoServiceTable").append(response);
                    $('#data').DataTable({
                        pageLength : 10,
                        lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'All']],
                        processing: true,        
                        scrollX: true,
                        language: {
                            processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
                        },
                        

                    });

                    cargarFiltrosActivos();

                }
            });
        }

        function cargarFiltrosActivos(){
            $.ajax({
                url: '../Controlador/cargarFiltrosServiciosActivos.php',
                type: 'POST',
                beforeSend: function() {
                },
                success: function(response) {
                    //alert(response);
                    $("#dataFilter").html(response);

                }
            });
        }

        function reajustarValores(){
            var parametros = {
                "id_servicios": servicios,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/reajustarValoresServicios.php',
                type: 'POST',
                beforeSend: function() {
                },
                success: function(response) {
                    alertify.message(response);
                    cargarServicios();
                    servicios.length = 0;
                }
            });
        }

        function selectAll(){
            document.querySelectorAll('#infoServiceTable input[type=checkbox]').forEach(function(checkElement) {
                checkElement.checked = true;
                servicios.push(checkElement.value);
            });
        }

        function unselectAll(){
            document.querySelectorAll('#infoServiceTable input[type=checkbox]').forEach(function(checkElement) {
                checkElement.checked = false;
                servicios.shift(checkElement.value);
            });
        }

        function serviciosReajustar(val){
            var servicio = document.getElementById('re_ajustar' + val);
            if(servicio.checked){
                servicios.push(val);
            }else{
                servicios.shift(val);
            }
            
        }

        function vehiculosServicios(val) {
            var parametros = {
                "id_servicio": val,
            };

            $.ajax({
                data: parametros,
                url: '../Controlador/listarVehiculosPorServicio.php',
                type: 'POST',
                beforeSend: function() {},
                success: function(response) {
                    $('#vehiculosServicio').modal();
                    $("#contentVehServ").html(response);
                }
            });
        }
        
        $(function() {
            $("#fecha_inicial").datepicker({
                dateFormat: 'yy-mm-dd'
            });
            $("#fecha_final").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });

    </script>
    <!-- FIN SCRIPT -->

</body>

</html>
