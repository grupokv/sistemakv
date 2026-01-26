<?php

include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");
require_once("../Modelo/Vehiculo.php");
require_once("../Modelo/General.php");

$id_mantenimiento = $_GET['id_mantenimiento'];

$operativo = new Operativo();
$vehiculo = new Vehiculo();

$listarControlMantenimientosID = $operativo->listarControlMantenimientosID($id_mantenimiento);
$listarVehActivos = $vehiculo->listarActivos();

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
                <form action="../Controlador/actualizarControlMantenimiento.php" method="POST" enctype="multipart/form-data">

                    <?php foreach ($listarControlMantenimientosID as $lcmi){ ?>

                            <!-- ID MANTENIMIENTO -->

                            <input type="hidden" name="id_mantenimiento" id="id_mantenimiento" class="form-control"
                                value="<?php echo $lcmi['id_mantenimiento'] ?>">

                            <!-- ESTADO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Estado</label>
                                    </div>
                                    <div class="input">
                                        <select class="form-control form-control-sm selectpicker" data-live-search="true" name="estado"
                                            id="estado" required="required" title="SELECCIONAR">
                                            <option value="1" <?php if($lcmi['estado'] == 1){ ?> selected <?php } ?>>EN PROCESO - ACTIVO</option>
                                            <option value="0" <?php if($lcmi['estado'] == 0){ ?> selected <?php } ?>>FINALIZADO</option>
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
                                            <option value="<?php echo $lva['id_vehiculo']; ?>" <?php if($lcmi['id_vehiculo'] == $lva['id_vehiculo']){ ?> selected <?php } ?>><?php echo $lva['placa'] . ' - ' . $lva['numero_movil'] ?></option>
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
                                            <option value="MTTO. CORRECTIVO" <?php if($lcmi['tipo_servicio'] == 'MTTO. CORRECTIVO'){ ?> selected <?php } ?>>MTTO. CORRECTIVO</option>
                                            <option value="MTTO. PREVENTIVO" <?php if($lcmi['tipo_servicio'] == 'MTTO. PREVENTIVO'){ ?> selected <?php } ?>>MTTO. PREVENTIVO</option>
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
                                            <option value="MANTENIMIENTO" <?php if($lcmi['enviado_por'] == 'MANTENIMIENTO'){ ?> selected <?php } ?>>MANTENIMIENTO</option>
                                            <option value="VARADO" <?php if($lcmi['enviado_por'] == 'VARADO'){ ?> selected <?php } ?>>VARADO</option>
                                        </select>
                                    </div>
                                </div>

                            <!-- FECHA DE MANTENIMIENTO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Fecha del Mantenimiento</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" name="fecha_mtto" id="fecha_mtto" class="form-control form-control-sm" value="<?php echo $lcmi['fecha_mtto'] ?>">
                                    </div>
                                </div>

                            <!-- DETALLE - CONCEPTO MTTO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Detalle o Concepto del MTTO</label>
                                    </div>
                                    <div class="input">
                                        <textarea class="form-control form-control-sm" name="detalle_mtto" id="detalle_mtto"><?php echo $lcmi['detalle_mtto'] ?></textarea>
                                    </div>
                                </div>

                            <!-- VALOR MTTO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Valor del Mantenimiento</label>
                                    </div>
                                    <div class="input">
                                        <input type="text" class="form-control form-control-sm" name="valor_mtto" id="valor_mtto" value="<?php echo $lcmi['valor_mtto'] ?>">
                                    </div>
                                </div>

                            <!-- FORMA DE PAGO -->
                                <div class="row mt-4">
                                    <div class="label">
                                        <label>Forma de Pago</label>
                                    </div>
                                    <div class="input">
                                        <select name="forma_pago" id="forma_pago" class="form-control form-control-sm selectpicker" data-live-search="true" title="SELECCIONAR">
                                            <option value="DEBITO" <?php if($lcmi['forma_pago'] == 'DEBITO'){ ?> selected <?php } ?>>DEBITO</option>
                                            <option value="CREDITO" <?php if($lcmi['forma_pago'] == 'CREDITO'){ ?> selected <?php } ?>>CREDITO</option>
                                        </select>
                                    </div>
                                </div>

                            
                        <!-- OBSERVACIONES -->
                            <div class="row mt-4">
                                <div class="label">
                                    <label>Observaciones</label>
                                </div>
                                <div class="input">
                                    <textarea class="form-control form-control-sm" name="observaciones" id="observaciones"><?php echo $lcmi['observaciones'] ?></textarea>
                                </div>
                            </div>


                    
                    <?php } ?>
                    
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