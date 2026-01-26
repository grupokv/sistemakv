<?php 
include ("../Controlador/Sesion/autenticar.php");
require_once("../Modelo/Operativo.php");

$id_servicio = $_GET['id_servicio'];
$operativo = new Operativo();

$listarTipoNovedades = $operativo->listarTipoNovedades();

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">

    <title>SistemaKV | Servicios Activos</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- styles -->
        <?php include("Template/styles.php"); ?>
        <link rel="stylesheet" href="../Resources/css/stylesHeader.css">
    <!--fin  styles -->

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
                <li class="breadcrumb-item active" aria-current="page">Novedad Servicio</li>
            </ol>
        </div>

        <div class="notice notice-sistemakv">
            <strong>
                <i class="fa fa-file-text-o mr-3" style="font-size: 2rem;"></i>
                <b style="font-size:1.3rem;">NOVEDAD DE SERVICIO - ID <?php echo str_pad($id_servicio, 5, "0", STR_PAD_LEFT); ?></b>
            </strong>
        </div>

        <div class="col-12 p-4" style="background-color: #fff;">
            <form action="../Controlador/registrarNovedadBaseServicio.php" method="POST">

                <input type="hidden" id="id_servicio" name="id_servicio" class="form-control" value="<?php echo $id_servicio ?>">

                <!-- TIPO NOVEDAD -->
                    <div class="row mt-4">
                        <div class="label">
                            <label>Tipo Novedad</label>
                        </div>
                        <div class="input">
                            <select class="form-control selectpicker" data-live-search="true" id="tipo_novedad" name="tipo_novedad"
                                style="border-style: dashed;" required>
                                <option value="">SELECCIONAR</option>
                                <?php foreach($listarTipoNovedades as $ltn){ ?>
                                    <option value="<?php echo $ltn['id_tipo_novedad'] ?>">
                                        <?php echo $ltn['tipo_novedad']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                
                <!-- NOVEDAD - DETALLE -->
                    <div class="row mt-4">
                        <div class="label">
                            <label>Detalle Novedad</label>
                        </div>
                        <div class="input">
                            <textarea placeholder="NOVEDAD" class="form-control" id="novedad" name="novedad" style="border-style: dashed;" required></textarea>
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
    <!-- FIN CONTENIDO -->

    <!-- SCRIPT -->
        <?php include("Template/scripts.php"); ?>
    <!-- FIN SCRIPT -->

</body>

</html>