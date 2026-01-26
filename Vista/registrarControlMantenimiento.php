<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/General.php");
require_once("../Modelo/Vehiculo.php");

$id_mantenimiento = $_GET['id_mantenimiento'];

$operativo = new Operativo();
$vehiculo = new Vehiculo();

$listarControlMantenimientosID = $operativo->listarControlMantenimientosID($id_mantenimiento);
$listarVehActivos = $vehiculo->listarVehiculoFlotaPropia();

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

        
    </style>

</head>

<body>

    <?php include("Template/header.php"); ?>
    <?php include("Template/newMenu.php"); ?>

    <section class="home_content">
        <div aria-label="breadcrumb" class="mt-1">
            <ol class="breadcrumb" style="background: #fff;">
                <li class="breadcrumb-item"><a href="inicio.php">Inicio</a></li>
                <li class="breadcrumb-item"><a href="servicios_activos.php">Control Mantenimientos</a></li>
                <li class="breadcrumb-item active" aria-current="page">Actualizar Control</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong><i class="fa fa-car mr-3" style="font-size: 2rem;"></i>ACTUALIZAR INFO DE MANTENIMIENTO</strong>
        </div>

        <section class="form-usuarios mt-1 p-3 mb-2">
            <div class="formulario mt-3 mb-3" style="width: 100%;">
                <form action="../Controlador/registrarControlMantenimiento.php" method="POST" enctype="multipart/form-data">

                        <!-- TIPO SERVICIO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Estado</label>
                                </div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="estado"
                                        id="estado" required="required" title="SELECCIONAR">
                                        <option value="1">EN PROCESO - ACTIVO</option>
                                        <option value="0">FINALIZADO</option>
                                    </select>
                                </div>
                            </div>

                        <!-- VEHICULO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Vehículo</label>
                                </div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="id_vehiculo"
                                        id="id_vehiculo" required="required" title="SELECCIONAR">
                                        <?php foreach($listarVehActivos as $lva){ ?>
                                            <option value="<?php echo $lva['id_vehiculo']; ?>"><?php echo $lva['placa'] . ' - ' . $lva['numero_movil'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                        <!-- TIPO SERVICIO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Tipo Servicio</label>
                                </div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="tipo_servicio"
                                        id="tipo_servicio" required="required" title="SELECCIONAR">
                                        <option value="MTTO. CORRECTIVO">MTTO. CORRECTIVO</option>
                                        <option value="MTTO. PREVENTIVO">MTTO. PREVENTIVO</option>
                                    </select>
                                </div>
                            </div>

                        <!-- ENVIADO POR -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Enviado Por</label>
                                </div>
                                <div class="input">
                                    <select class="form-control form-control-sm selectpicker" data-live-search="true" name="enviado_por"
                                        id="enviado_por" required="required" title="SELECCIONAR">
                                        <option value="MANTENIMIENTO">MANTENIMIENTO</option>
                                        <option value="VARADO">VARADO</option>
                                    </select>
                                </div>
                            </div>

                        <!-- FECHA DE MANTENIMIENTO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Fecha del Mantenimiento</label>
                                </div>
                                <div class="input">
                                    <input type="text" name="fecha_mtto" id="fecha_mtto" class="form-control form-control-sm">
                                </div>
                            </div>

                        <!-- DETALLE - CONCEPTO MTTO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Detalle o Concepto del MTTO</label>
                                </div>
                                <div class="input">
                                    <textarea class="form-control form-control-sm" name="detalle_mtto" id="detalle_mtto"></textarea>
                                </div>
                            </div>

                        <!-- VALOR MTTO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Valor del Mantenimiento</label>
                                </div>
                                <div class="input">
                                    <input type="text" class="form-control form-control-sm" name="valor_mtto" id="valor_mtto">
                                </div>
                            </div>

                        <!-- FORMA DE PAGO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Forma de Pago</label>
                                </div>
                                <div class="input">
                                    <select name="forma_pago" id="forma_pago" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                        <option value="DEBITO">DEBITO</option>
                                        <option value="CREDITO">CREDITO</option>
                                    </select>
                                </div>
                            </div>

                        <!-- DETALLE - CONCEPTO MTTO -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Observaciones</label>
                                </div>
                                <div class="input">
                                    <textarea class="form-control form-control-sm" name="observaciones" id="observaciones"></textarea>
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
            </div>
        </section>

    </section>


    <!-- SCRIPT -->

    <?php include("Template/scripts.php"); ?>

    <script type="text/javascript">
        $(function() {
            $("#fecha_mtto").datepicker({
                dateFormat: 'yy-mm-dd'
            });
        });
    </script>

    <!-- FIN SCRIPT -->

</body>

</html>